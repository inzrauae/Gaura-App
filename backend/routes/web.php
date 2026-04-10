<?php

use App\Models\Expense;
use App\Models\Client;
use App\Models\Project;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$resolveActiveProject = function ($availableProjects, ?string $requestedProject = null) {
    $selectedProjectName = null;

    if ($requestedProject !== null) {
        $requestedProject = trim($requestedProject);

        if ($requestedProject === '' || strcasecmp($requestedProject, 'all') === 0) {
            session()->forget('active_project');

            return null;
        }

        $matchedProject = $availableProjects->first(fn ($name) => strcasecmp($name, $requestedProject) === 0);

        if ($matchedProject) {
            session(['active_project' => $matchedProject]);

            return $matchedProject;
        }

        session()->forget('active_project');

        return null;
    }

    $selectedProjectName = session('active_project');

    if ($selectedProjectName) {
        $matchedProject = $availableProjects->first(fn ($name) => strcasecmp($name, $selectedProjectName) === 0);

        if ($matchedProject) {
            return $matchedProject;
        }

        session()->forget('active_project');
    }

    return null;
};

$buildMonthlyTotals = function ($expenseQuery) {
    return (clone $expenseQuery)
        ->orderBy('expense_date')
        ->get(['expense_date', 'amount'])
        ->groupBy(fn (Expense $expense) => optional($expense->expense_date)->format('Y-m'))
        ->filter(fn ($expenses, $month) => $month !== null)
        ->map(fn ($expenses, $month) => (object) [
            'month' => $month,
            'total' => (float) $expenses->sum('amount'),
        ])
        ->values();
};

Route::get('/expenses', function () use ($resolveActiveProject) {
    $availableProjects = Project::orderBy('name')->pluck('name');
    $selectedProjectName = $resolveActiveProject(
        $availableProjects,
        request()->exists('active_project') ? (string) request()->query('active_project', '') : null
    );

    $recentSiteCosts = Expense::query()
        ->when($selectedProjectName, fn ($query) => $query->where('project_name', $selectedProjectName))
        ->latest('expense_date')
        ->latest('id')
        ->take(50)
        ->get();

    return view('pos', [
        'availableProjects' => $availableProjects,
        'sidebarProjectName' => 'GAURA',
        'sidebarProjectSubtitle' => 'GAURA',
        'selectedProjectName' => $selectedProjectName,
        'recentSiteCosts' => $recentSiteCosts,
    ]);
})->name('expenses.create');

Route::get('/', function () use ($resolveActiveProject, $buildMonthlyTotals) {
    $availableProjects = Project::orderBy('name')->pluck('name');
    $selectedProjectName = $resolveActiveProject(
        $availableProjects,
        request()->exists('active_project') ? (string) request()->query('active_project', '') : null
    );

    $dashboardExpenses = Expense::query()
        ->when($selectedProjectName, fn ($query) => $query->where('project_name', $selectedProjectName));

    $totalExpenses = (clone $dashboardExpenses)->count();
    $totalAmount = (clone $dashboardExpenses)->sum('amount');
    $thisMonthAmount = (clone $dashboardExpenses)
        ->whereYear('expense_date', now()->year)
        ->whereMonth('expense_date', now()->month)
        ->sum('amount');

    $recentExpenses = (clone $dashboardExpenses)
        ->latest('expense_date')
        ->latest('id')
        ->take(10)
        ->get();

    $monthlyRows = $buildMonthlyTotals($dashboardExpenses);

    $categoryRows = (clone $dashboardExpenses)
        ->selectRaw('category, SUM(amount) as total')
        ->groupBy('category')
        ->orderByDesc('total')
        ->get();

    return view('dashboard', [
        'totalExpenses' => $totalExpenses,
        'totalAmount' => $totalAmount,
        'thisMonthAmount' => $thisMonthAmount,
        'recentExpenses' => $recentExpenses,
        'monthlyChartLabels' => $monthlyRows->pluck('month')->values(),
        'monthlyChartValues' => $monthlyRows->pluck('total')->map(fn ($v) => (float) $v)->values(),
        'categoryChartLabels' => $categoryRows->pluck('category')->values(),
        'categoryChartValues' => $categoryRows->pluck('total')->map(fn ($v) => (float) $v)->values(),
        'availableProjects' => $availableProjects,
        'selectedProjectName' => $selectedProjectName,
        'sidebarProjectName' => 'GAURA',
        'sidebarProjectSubtitle' => 'GAURA',
    ]);
})->name('dashboard');

Route::get('/dashboard', function () {
    return redirect()->route('dashboard', request()->only('active_project'));
});

Route::get('/analytics', function () use ($resolveActiveProject, $buildMonthlyTotals) {
    $availableProjects = Project::orderBy('name')->pluck('name');
    $selectedProjectName = $resolveActiveProject(
        $availableProjects,
        request()->exists('active_project')
            ? (string) request()->query('active_project', '')
            : (request()->exists('project_name') ? (string) request()->query('project_name', '') : null)
    );

    $analyticsExpenses = Expense::query()
        ->when($selectedProjectName, fn ($query) => $query->where('project_name', $selectedProjectName));

    $totalAmount = (float) (clone $analyticsExpenses)->sum('amount');

    $categoryTotals = (clone $analyticsExpenses)
        ->selectRaw('category, SUM(amount) as total')
        ->groupBy('category')
        ->orderByDesc('total')
        ->get();

    $paymentTotals = (clone $analyticsExpenses)
        ->selectRaw('payment_type, SUM(amount) as total')
        ->groupBy('payment_type')
        ->get()
        ->keyBy('payment_type');

    $directorTotals = (clone $analyticsExpenses)
        ->selectRaw("director_name,
            SUM(CASE WHEN director_fund_source = 'cash_in_hand' THEN amount ELSE 0 END) as hand_total,
            SUM(CASE WHEN director_fund_source = 'bank_balance' THEN amount ELSE 0 END) as bank_total,
            SUM(amount) as total")
        ->where('payment_type', 'director_paid')
        ->whereNotNull('director_name')
        ->groupBy('director_name')
        ->orderByDesc('total')
        ->get();

    $directorNames = ['Buddhika', 'Nilitha', 'Vihaga'];

    $directorHandExpenseTables = collect($directorNames)->map(function (string $directorName) use ($selectedProjectName) {
        $rows = Expense::query()
            ->select(['expense_date', 'project_name', 'title', 'amount'])
            ->where('payment_type', 'director_paid')
            ->where('director_fund_source', 'cash_in_hand')
            ->where('director_name', $directorName)
            ->when($selectedProjectName, fn ($query) => $query->where('project_name', $selectedProjectName))
            ->latest('expense_date')
            ->latest('id')
            ->take(10)
            ->get();

        return [
            'director_name' => $directorName,
            'total' => (float) $rows->sum('amount'),
            'rows' => $rows,
        ];
    });

    $monthlyTotals = $buildMonthlyTotals($analyticsExpenses);

    return view('analytics', [
        'totalAmount' => $totalAmount,
        'categoryTotals' => $categoryTotals,
        'companyPaidTotal' => (float) optional($paymentTotals->get('company_paid'))->total,
        'directorPaidTotal' => (float) optional($paymentTotals->get('director_paid'))->total,
        'directorTotals' => $directorTotals,
        'directorHandExpenseTables' => $directorHandExpenseTables,
        'monthlyTotals' => $monthlyTotals,
        'availableProjects' => $availableProjects,
        'selectedProjectName' => $selectedProjectName,
        'sidebarProjectName' => 'GAURA',
        'sidebarProjectSubtitle' => 'GAURA',
    ]);
})->name('analytics');

Route::get('/projects', function () use ($resolveActiveProject) {
    $allProjects = Project::orderBy('name')->get();
    $availableProjects = $allProjects->pluck('name');
    $selectedProjectName = $resolveActiveProject(
        $availableProjects,
        request()->exists('active_project') ? (string) request()->query('active_project', '') : null
    );

    $projectFilteredExpenses = Expense::query()
        ->when($selectedProjectName, fn ($query) => $query->where('project_name', $selectedProjectName));

    $expenseAggregates = (clone $projectFilteredExpenses)
        ->selectRaw('project_name, COUNT(*) as expense_count, SUM(amount) as total')
        ->whereNotNull('project_name')
        ->where('project_name', '!=', '')
        ->groupBy('project_name')
        ->get()
        ->keyBy('project_name');

    $projects = $allProjects
        ->when($selectedProjectName, fn ($collection) => $collection->where('name', $selectedProjectName))
        ->map(fn ($p) => (object) [
        'project_name'  => $p->name,
        'expense_count' => (int) optional($expenseAggregates->get($p->name))->expense_count,
        'total'         => (float) optional($expenseAggregates->get($p->name))->total,
    ]);

    $unassignedCount = (clone $projectFilteredExpenses)
        ->where(fn ($q) => $q->whereNull('project_name')->orWhere('project_name', ''))
        ->count();

    $recentExpenses = (clone $projectFilteredExpenses)
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
        'availableProjects' => $availableProjects,
        'selectedProjectName' => $selectedProjectName,
        'sidebarProjectName' => 'GAURA',
        'sidebarProjectSubtitle' => 'GAURA',
    ]);
})->name('projects');

Route::post('/projects', function (Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'max:100', 'unique:projects,name'],
    ]);

    Project::create(['name' => trim($request->input('name'))]);

    return redirect()->route('projects')->with('success', 'Project "' . trim($request->input('name')) . '" created.');
})->name('projects.store');

Route::get('/clients', function () use ($resolveActiveProject) {
    $availableProjects = Project::orderBy('name')->pluck('name');
    $search = trim((string) request('q', ''));
    $selectedProjectName = $resolveActiveProject(
        $availableProjects,
        request()->exists('active_project') ? (string) request()->query('active_project', '') : null
    );

    $clients = Client::query()
        ->when($search !== '', function ($query) use ($search) {
            $query->where(function ($inner) use ($search) {
                $inner->where('name', 'like', "%{$search}%")
                    ->orWhere('entity_type', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
            });
        })
        ->latest('id')
        ->get();

    return view('clients', [
        'clients' => $clients,
        'availableProjects' => $availableProjects,
        'selectedProjectName' => $selectedProjectName,
        'search' => $search,
        'sidebarProjectName' => 'GAURA',
        'sidebarProjectSubtitle' => 'GAURA',
    ]);
})->name('clients');

Route::post('/clients', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:150'],
        'entity_type' => ['required', 'in:client,person'],
        'company' => ['nullable', 'string', 'max:150'],
        'phone' => ['nullable', 'string', 'max:50'],
        'email' => ['nullable', 'email', 'max:150'],
        'address' => ['nullable', 'string', 'max:255'],
        'notes' => ['nullable', 'string'],
    ]);

    Client::create($validated);

    return redirect()->route('clients')->with('success', 'Client/person saved successfully.');
})->name('clients.store');

Route::get('/settings', function () use ($resolveActiveProject) {
    $availableProjects = Project::orderBy('name')->pluck('name');
    $selectedProjectName = $resolveActiveProject(
        $availableProjects,
        request()->exists('active_project') ? (string) request()->query('active_project', '') : null
    );

    return view('settings', [
        'availableProjects' => $availableProjects,
        'selectedProjectName' => $selectedProjectName,
        'sidebarProjectName' => 'GAURA',
        'sidebarProjectSubtitle' => 'GAURA',
    ]);
})->name('settings');

Route::controller(ReportController::class)->group(function () {
    Route::get('/reports', 'index')->name('reports');
    Route::get('/api/reports/download-excel', 'downloadExcel')->name('reports.download.excel');
    Route::get('/api/reports/download-pdf', 'downloadPdf')->name('reports.download.pdf');
    Route::get('/api/reports/project/{projectName}/excel', 'downloadProjectExcel')->name('reports.download.project.excel');
    Route::get('/api/reports/project/{projectName}/pdf', 'downloadProjectPdf')->name('reports.download.project.pdf');
});
