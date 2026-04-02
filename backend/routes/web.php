<?php

use App\Models\Expense;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $availableProjects = Project::orderBy('name')->pluck('name');
    return view('pos', ['availableProjects' => $availableProjects]);
})->name('expenses.create');

Route::get('/dashboard', function () {
    $totalExpenses = Expense::count();
    $totalAmount = Expense::sum('amount');
    $thisMonthAmount = Expense::query()
        ->whereYear('expense_date', now()->year)
        ->whereMonth('expense_date', now()->month)
        ->sum('amount');

    $recentExpenses = Expense::query()
        ->latest('expense_date')
        ->latest('id')
        ->take(10)
        ->get();

    return view('dashboard', [
        'totalExpenses' => $totalExpenses,
        'totalAmount' => $totalAmount,
        'thisMonthAmount' => $thisMonthAmount,
        'recentExpenses' => $recentExpenses,
    ]);
})->name('dashboard');

Route::get('/analytics', function () {
    $totalAmount = (float) Expense::sum('amount');

    $categoryTotals = Expense::query()
        ->selectRaw('category, SUM(amount) as total')
        ->groupBy('category')
        ->orderByDesc('total')
        ->get();

    $paymentTotals = Expense::query()
        ->selectRaw('payment_type, SUM(amount) as total')
        ->groupBy('payment_type')
        ->get()
        ->keyBy('payment_type');

    $directorTotals = Expense::query()
        ->selectRaw('director_name, SUM(amount) as total')
        ->where('payment_type', 'director_paid')
        ->whereNotNull('director_name')
        ->groupBy('director_name')
        ->orderByDesc('total')
        ->get();

    $monthlyTotals = Expense::query()
        ->selectRaw("strftime('%Y-%m', expense_date) as month, SUM(amount) as total")
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    return view('analytics', [
        'totalAmount' => $totalAmount,
        'categoryTotals' => $categoryTotals,
        'companyPaidTotal' => (float) optional($paymentTotals->get('company_paid'))->total,
        'directorPaidTotal' => (float) optional($paymentTotals->get('director_paid'))->total,
        'directorTotals' => $directorTotals,
        'monthlyTotals' => $monthlyTotals,
    ]);
})->name('analytics');

Route::get('/projects', function () {
    $allProjects = Project::orderBy('name')->get();

    $expenseAggregates = Expense::query()
        ->selectRaw('project_name, COUNT(*) as expense_count, SUM(amount) as total')
        ->whereNotNull('project_name')
        ->where('project_name', '!=', '')
        ->groupBy('project_name')
        ->get()
        ->keyBy('project_name');

    $projects = $allProjects->map(fn ($p) => (object) [
        'project_name'  => $p->name,
        'expense_count' => (int) optional($expenseAggregates->get($p->name))->expense_count,
        'total'         => (float) optional($expenseAggregates->get($p->name))->total,
    ]);

    $unassignedCount = Expense::query()
        ->where(fn ($q) => $q->whereNull('project_name')->orWhere('project_name', ''))
        ->count();

    $recentExpenses = Expense::query()
        ->whereNotNull('project_name')
        ->where('project_name', '!=', '')
        ->latest('expense_date')
        ->latest('id')
        ->take(20)
        ->get();

    return view('projects', [
        'projects'        => $projects,
        'unassignedCount' => $unassignedCount,
        'recentExpenses'  => $recentExpenses,
    ]);
})->name('projects');

Route::post('/projects', function (Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'max:100', 'unique:projects,name'],
    ]);

    Project::create(['name' => trim($request->input('name'))]);

    return redirect()->route('projects')->with('success', 'Project "' . trim($request->input('name')) . '" created.');
})->name('projects.store');
