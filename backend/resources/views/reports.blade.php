<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAURA - Reports</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="preload" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 border-b border-gray-200 bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 py-4 md:px-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-[#003d9b] to-[#0052cc] rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">G</span>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-[#003d9b]">GAURA</h1>
                            <p class="text-xs text-gray-600">Reports</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 text-sm">
                        <a href="/" class="text-gray-600 hover:text-[#003d9b] text-sm font-medium">Dashboard</a>
                        <a href="/expenses" class="text-gray-600 hover:text-[#003d9b] text-sm font-medium">Site Costs</a>
                        <a href="/projects" class="text-gray-600 hover:text-[#003d9b] text-sm font-medium">Projects</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 pb-28 md:px-6 md:py-12 md:pb-12">
            <!-- Header -->
            <div class="mb-8">
                <h2 class="mb-2 text-2xl font-bold text-[#003d9b] md:text-3xl">Reports & Exports</h2>
                <p class="text-gray-600">Download comprehensive expense reports in PDF or Excel format</p>
            </div>

            <!-- Overall Reports Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-[#003d9b] to-[#0052cc]">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-2xl">assessment</span>
                        Overall Reports
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Summary Stats -->
                        <div class="space-y-4">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
                                <p class="text-sm font-semibold text-blue-900">Total Expenses</p>
                                <p class="text-3xl font-bold text-blue-700 mt-2">{{ $totalExpenses }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-4 rounded-lg border border-amber-200">
                                <p class="text-sm font-semibold text-amber-900">Total Amount</p>
                                <p class="text-3xl font-bold text-amber-700 mt-2">LKR {{ number_format($totalAmount, 2) }}</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-4">
                            <a href="/api/reports/download-excel" class="flex w-full items-center justify-center gap-3 rounded-lg bg-gradient-to-r from-green-500 to-green-600 px-6 py-3 font-semibold text-white shadow-md transition-all hover:from-green-600 hover:to-green-700 hover:shadow-lg">
                                <span class="material-symbols-outlined">download</span>
                                Download Excel Report
                            </a>
                            <a href="/api/reports/download-pdf" class="flex w-full items-center justify-center gap-3 rounded-lg bg-gradient-to-r from-red-500 to-red-600 px-6 py-3 font-semibold text-white shadow-md transition-all hover:from-red-600 hover:to-red-700 hover:shadow-lg">
                                <span class="material-symbols-outlined">picture_as_pdf</span>
                                Download PDF Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project-Specific Reports Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-[#003d9b] to-[#0052cc]">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-2xl">location_on</span>
                        Project-Specific Reports
                    </h3>
                </div>
                <div class="p-6">
                    @if($projects->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($projects as $project)
                                <div class="bg-gradient-to-br from-slate-50 to-slate-100 border-2 border-[#fdc425] rounded-lg p-6 hover:shadow-lg transition-shadow">
                                    <h4 class="font-bold text-[#785a00] text-lg mb-4">{{ $project->name }}</h4>
                                    <p class="text-sm text-gray-700 mb-4">{{ $project->expenses_count }} expenses tracked</p>
                                    <div class="flex flex-col gap-2">
                                        <a href="/api/reports/project/{{ urlencode($project->name) }}/excel" class="flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded transition-colors text-sm">
                                            <span class="material-symbols-outlined text-lg">download</span>
                                            Excel
                                        </a>
                                        <a href="/api/reports/project/{{ urlencode($project->name) }}/pdf" class="flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded transition-colors text-sm">
                                            <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
                                            PDF
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <span class="material-symbols-outlined text-5xl text-gray-300 block mb-3">folder_open</span>
                            <p class="text-gray-500">No projects found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <nav class="fixed bottom-0 left-0 z-50 flex w-full justify-around border-t border-slate-100 bg-white px-2 py-3 md:hidden">
            <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-[10px]">Dashboard</span>
            </a>
            <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('expenses.create') }}">
                <span class="material-symbols-outlined">receipt_long</span>
                <span class="text-[10px]">Costs</span>
            </a>
            <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('projects') }}">
                <span class="material-symbols-outlined">architecture</span>
                <span class="text-[10px]">Sites</span>
            </a>
            <a class="flex flex-col items-center gap-1 text-[#003d9b]" href="{{ route('reports') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">assessment</span>
                <span class="text-[10px] font-bold">Reports</span>
            </a>
        </nav>
    </div>
</body>
</html>
