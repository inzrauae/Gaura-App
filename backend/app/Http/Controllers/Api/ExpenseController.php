<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $expenses = Expense::query()
            ->when(request('category'), fn ($q, $category) => $q->where('category', $category))
            ->when(request('payment_type'), fn ($q, $paymentType) => $q->where('payment_type', $paymentType))
            ->when(request('director_name'), fn ($q, $directorName) => $q->where('director_name', $directorName))
            ->when(request('project_name'), fn ($q, $projectName) => $q->where('project_name', $projectName))
            ->when(request('from_date'), fn ($q, $fromDate) => $q->whereDate('expense_date', '>=', $fromDate))
            ->when(request('to_date'), fn ($q, $toDate) => $q->whereDate('expense_date', '<=', $toDate))
            ->when(request('search'), function ($q, $search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('notes', 'like', "%{$search}%");
                });
            })
            ->latest('expense_date')
            ->latest('id')
            ->paginate((int) request('per_page', 15));

        return response()->json($expenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (($validated['payment_type'] ?? null) === 'company_paid') {
            $validated['director_name'] = null;
            $validated['director_fund_source'] = null;
        }

        if ($request->hasFile('receipt')) {
            $validated['receipt_path'] = $request->file('receipt')->store('receipts', 'public');
        }

        unset($validated['receipt']);

        $expense = Expense::create($validated);

        return response()->json([
            'message' => 'Expense created successfully.',
            'data' => $expense,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense): JsonResponse
    {
        return response()->json([
            'data' => $expense,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense): JsonResponse
    {
        $validated = $request->validated();

        $effectivePaymentType = $validated['payment_type'] ?? $expense->payment_type;
        if ($effectivePaymentType === 'company_paid') {
            $validated['director_name'] = null;
            $validated['director_fund_source'] = null;
        }

        if ($request->hasFile('receipt')) {
            if ($expense->receipt_path) {
                Storage::disk('public')->delete($expense->receipt_path);
            }

            $validated['receipt_path'] = $request->file('receipt')->store('receipts', 'public');
        }

        unset($validated['receipt']);

        $expense->update($validated);

        return response()->json([
            'message' => 'Expense updated successfully.',
            'data' => $expense,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense): JsonResponse
    {
        if ($expense->receipt_path) {
            Storage::disk('public')->delete($expense->receipt_path);
        }

        $expense->delete();

        return response()->json([
            'message' => 'Expense deleted successfully.',
        ]);
    }
}
