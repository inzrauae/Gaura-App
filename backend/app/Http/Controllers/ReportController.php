<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $projects = Project::withCount('expenses')->orderBy('name')->get();
        $totalExpenses = Expense::count();
        $totalAmount = Expense::sum('amount');
        
        return view('reports', [
            'projects' => $projects,
            'totalExpenses' => $totalExpenses,
            'totalAmount' => $totalAmount,
        ]);
    }

    public function downloadExcel($type = 'all')
    {
        try {
            $expenses = Expense::orderBy('expense_date', 'desc')
                ->orderBy('id', 'desc')
                ->get();

            return $this->downloadSpreadsheet(
                $expenses,
                'GAURA_Expenses_' . now()->format('Y-m-d_H-i-s') . '.xls'
            );
        } catch (\Exception $e) {
            \Log::error('Excel Export Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate Excel report'], 500);
        }
    }

    public function downloadPdf($type = 'all')
    {
        try {
            $expenses = Expense::orderBy('expense_date', 'desc')->get();
            
            // Calculate summary data
            $totalAmount = $expenses->sum('amount');
            $totalCompanyPaid = $expenses->where('payment_type', 'company_paid')->sum('amount');
            $totalDirectorPaid = $expenses->where('payment_type', 'director_paid')->sum('amount');
            $expenseCount = $expenses->count();
            
            // Group by category
            $byCategory = $expenses->groupBy('category')->map(function ($items) {
                return [
                    'count' => $items->count(),
                    'total' => $items->sum('amount'),
                ];
            })->sortByDesc('total');

            // Group by project
            $byProject = $expenses->groupBy('project_name')->map(function ($items) {
                return [
                    'count' => $items->count(),
                    'total' => $items->sum('amount'),
                ];
            })->sortByDesc('total');

            $pdf = PDF::loadView('reports.pdf', [
                'expenses' => $expenses,
                'totalAmount' => $totalAmount,
                'totalCompanyPaid' => $totalCompanyPaid,
                'totalDirectorPaid' => $totalDirectorPaid,
                'expenseCount' => $expenseCount,
                'byCategory' => $byCategory,
                'byProject' => $byProject,
                'generatedDate' => now()->format('F j, Y H:i'),
            ]);
            
            $pdf->setPaper('a4', 'portrait');
            
            return $pdf->download('GAURA_Expenses_' . now()->format('Y-m-d_H-i-s') . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Export Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate PDF report'], 500);
        }
    }

    public function downloadProjectExcel($projectName)
    {
        try {
            $projectName = urldecode($projectName);

            $expenses = Expense::where('project_name', $projectName)
                ->orderBy('expense_date', 'desc')
                ->orderBy('id', 'desc')
                ->get();

            if ($expenses->isEmpty()) {
                return response()->json(['error' => 'No expenses found for this project'], 404);
            }

            return $this->downloadSpreadsheet(
                $expenses,
                'GAURA_' . str_replace(' ', '_', $projectName) . '_' . now()->format('Y-m-d_H-i-s') . '.xls'
            );
        } catch (\Exception $e) {
            \Log::error('Project Excel Export Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate Excel report'], 500);
        }
    }

    public function downloadProjectPdf($projectName)
    {
        try {
            $projectName = urldecode($projectName);

            $expenses = Expense::where('project_name', $projectName)
                ->orderBy('expense_date', 'desc')
                ->get();

            if ($expenses->isEmpty()) {
                return response()->json(['error' => 'No expenses found for this project'], 404);
            }

            $totalAmount = $expenses->sum('amount');
            $totalCompanyPaid = $expenses->where('payment_type', 'company_paid')->sum('amount');
            $totalDirectorPaid = $expenses->where('payment_type', 'director_paid')->sum('amount');
            
            $byCategory = $expenses->groupBy('category')->map(function ($items) {
                return ['count' => $items->count(), 'total' => $items->sum('amount')];
            })->sortByDesc('total');

            $pdf = PDF::loadView('reports.pdf-project', [
                'projectName' => $projectName,
                'expenses' => $expenses,
                'totalAmount' => $totalAmount,
                'totalCompanyPaid' => $totalCompanyPaid,
                'totalDirectorPaid' => $totalDirectorPaid,
                'byCategory' => $byCategory,
                'generatedDate' => now()->format('F j, Y H:i'),
            ]);
            
            $pdf->setPaper('a4', 'portrait');
            
            return $pdf->download('GAURA_' . str_replace(' ', '_', $projectName) . '_' . now()->format('Y-m-d_H-i-s') . '.pdf');
        } catch (\Exception $e) {
            \Log::error('Project PDF Export Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate PDF report'], 500);
        }
    }

    private function downloadSpreadsheet($expenses, string $filename)
    {
        $content = $this->generateSpreadsheetXml($expenses);

        return response($content, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0, no-cache, no-store, must-revalidate',
            'Pragma' => 'public',
        ]);
    }

    private function generateSpreadsheetXml($expenses): string
    {
        $rows = [
            ['Date', 'Project', 'Category', 'Title', 'Amount', 'Payment Type', 'Director', 'Fund Source', 'Notes'],
        ];

        foreach ($expenses as $expense) {
            $rows[] = [
                optional($expense->expense_date)->format('Y-m-d') ?? '',
                $expense->project_name ?? 'Unassigned',
                $expense->category,
                $expense->title,
                number_format((float) $expense->amount, 2, '.', ''),
                ucfirst(str_replace('_', ' ', $expense->payment_type)),
                $expense->director_name ?? '-',
                $expense->director_fund_source ? ucfirst(str_replace('_', ' ', $expense->director_fund_source)) : '-',
                $expense->notes ?? '-',
            ];
        }

        $xmlRows = collect($rows)->map(function (array $row, int $index) {
            $cells = collect($row)->map(function ($value) use ($index) {
                $type = is_numeric($value) && $index !== 0 ? 'Number' : 'String';

                return '<Cell><Data ss:Type="' . $type . '">' . htmlspecialchars((string) $value, ENT_XML1) . '</Data></Cell>';
            })->implode('');

            $style = $index === 0 ? ' ss:StyleID="Header"' : '';

            return '<Row' . $style . '>' . $cells . '</Row>';
        })->implode('');

        return <<<XML
<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">
 <Styles>
  <Style ss:ID="Header">
   <Font ss:Bold="1" ss:Color="#FFFFFF"/>
   <Interior ss:Color="#003d9b" ss:Pattern="Solid"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Expenses">
  <Table>
   {$xmlRows}
  </Table>
 </Worksheet>
</Workbook>
XML;
    }
}
