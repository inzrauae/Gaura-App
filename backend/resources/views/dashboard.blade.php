<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#003d9b" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default" />
  <title>Gaura Dashboard</title>
  <link rel="icon" type="image/png" href="{{ asset('img/gaura-logo.png') }}" />
  <link rel="apple-touch-icon" href="{{ asset('img/gaura-logo.png') }}" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
  <style>
    body { font-family: Inter, sans-serif; background: #faf8ff; color: #131b2e; }
    body {
      background-image:
        linear-gradient(rgba(19, 27, 46, 0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(19, 27, 46, 0.025) 1px, transparent 1px),
        radial-gradient(circle at 90% 0%, rgba(247, 190, 29, 0.12), transparent 34%);
      background-size: 26px 26px, 26px 26px, 100% 100%;
      background-position: 0 0, 0 0, 0 0;
    }
    h1, h2, h3 { font-family: Manrope, sans-serif; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
  </style>
</head>
<body>
  <aside class="fixed left-0 top-0 z-40 hidden h-screen w-64 flex-col bg-[#faf8ff] shadow-[8px_0_24px_rgba(19,27,46,0.06)] md:flex">
    <div class="px-6 py-8">
      <div class="mb-8 rounded-xl bg-[#f2f3ff] p-4">
        <div class="flex items-center gap-3">
          <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white border border-slate-200 shadow-sm">
            <img src="{{ asset('img/gaura-logo.png') }}" alt="GAURA mark" class="h-7 w-7 object-contain" />
          </div>
          <div>
            <div class="inline-block rounded-md bg-white px-2 py-0.5 text-sm font-bold text-[#003d9b]">{{ $sidebarProjectName }}</div>
            <div class="text-xs text-slate-500">Construction Operations</div>
          </div>
        </div>
        <form action="{{ route('dashboard') }}" method="GET" class="mt-3">
          <select name="active_project" onchange="this.form.submit()" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 focus:border-[#003d9b] focus:ring-[#003d9b]">
            <option value="">All Sites</option>
            @foreach($availableProjects as $projectName)
              <option value="{{ $projectName }}" {{ $selectedProjectName === $projectName ? 'selected' : '' }}>{{ $projectName }}</option>
            @endforeach
          </select>
        </form>
      </div>
      <nav class="space-y-1">
        <a class="flex items-center gap-3 rounded-lg border-r-4 border-[#003d9b] bg-[#e2e7ff] px-4 py-3 text-[#003d9b]" href="{{ route('dashboard') }}">
          <span class="material-symbols-outlined">dashboard</span>
          <span class="text-sm font-medium">Site Dashboard</span>
        </a>
        <a class="flex items-center gap-3 rounded-lg border-r-4 border-transparent px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('expenses.create') }}">
          <span class="material-symbols-outlined">receipt_long</span>
          <span class="text-sm font-medium">Site Costs</span>
        </a>
        <a class="flex items-center gap-3 rounded-lg border-r-4 border-transparent px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('projects') }}">
          <span class="material-symbols-outlined">architecture</span>
          <span class="text-sm font-medium">Sites</span>
        </a>
        <a class="flex items-center gap-3 rounded-lg border-r-4 border-transparent px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('analytics') }}">
          <span class="material-symbols-outlined">bar_chart</span>
          <span class="text-sm font-medium">Cost Insights</span>
        </a>
        <a class="flex items-center gap-3 rounded-lg border-r-4 border-transparent px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('reports') }}">
          <span class="material-symbols-outlined">assessment</span>
          <span class="text-sm font-medium">Reports</span>
        </a>
        <a class="flex items-center gap-3 rounded-lg border-r-4 border-transparent px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('clients') }}">
          <span class="material-symbols-outlined">groups</span>
          <span class="text-sm font-medium">Clients</span>
        </a>
        <a class="flex items-center gap-3 rounded-lg border-r-4 border-transparent px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('settings') }}">
          <span class="material-symbols-outlined">settings</span>
          <span class="text-sm font-medium">Settings</span>
        </a>
      </nav>
    </div>
    <div class="mt-auto px-6 py-6">
      <a class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-br from-[#003d9b] to-[#0052cc] px-4 py-3 font-bold text-white" href="{{ route('expenses.create') }}">
        <span class="material-symbols-outlined">add</span>
        Add Site Cost
      </a>
    </div>
  </aside>

  <div class="flex min-h-screen flex-col md:ml-64">
    <header class="sticky top-0 z-30 flex w-full items-center justify-between bg-[#faf8ff] px-4 py-3 md:px-6">
      <div class="text-xl font-black text-[#003d9b] md:hidden">GA</div>
      <nav class="hidden items-center gap-6 md:flex">
        <a class="font-bold text-[#003d9b] border-b-2 border-[#003d9b] pb-1" href="{{ route('dashboard') }}">Dashboard</a>
        <a class="text-[#434654] hover:bg-[#e2e7ff] rounded px-2 py-1" href="{{ route('expenses.create') }}">Site Costs</a>
      </nav>
      <div class="flex items-center gap-2">
        <a class="rounded-lg bg-[#003d9b] px-3 py-2 text-sm font-semibold text-white md:px-4" href="{{ route('expenses.create') }}">Add Cost</a>
      </div>
    </header>

    <main class="mx-auto w-full max-w-6xl flex-1 p-4 pb-28 md:p-10 md:pb-10">
      <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-[#003d9b] md:text-3xl">Construction Cost Dashboard</h1>
        <p class="text-sm text-slate-600">Overview of site spending, trends, and recent cost entries.</p>
      </div>

      <section class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm md:p-5">
          <p class="text-sm text-slate-500">Total Records</p>
          <p class="mt-2 text-3xl font-extrabold">{{ $totalExpenses }}</p>
        </div>
        <div class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm md:p-5">
          <p class="text-sm text-slate-500">Total Amount</p>
          <p class="mt-2 text-3xl font-extrabold">LKR {{ number_format((float) $totalAmount, 2) }}</p>
        </div>
        <div class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm md:p-5">
          <p class="text-sm text-slate-500">This Month</p>
          <p class="mt-2 text-3xl font-extrabold">LKR {{ number_format((float) $thisMonthAmount, 2) }}</p>
        </div>
      </section>

      <section class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="overflow-hidden rounded-xl border border-slate-100 bg-white p-4 shadow-sm lg:col-span-2 md:p-5">
          <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold">Monthly Expense Trend</h2>
            <span class="rounded-full bg-[#e2e7ff] px-3 py-1 text-xs font-semibold text-[#003d9b]">Live Data</span>
          </div>
          <div class="h-64 md:h-72">
            <canvas id="monthly-trend-chart"></canvas>
          </div>
        </div>
        <div class="overflow-hidden rounded-xl border border-slate-100 bg-white p-4 shadow-sm md:p-5">
          <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold">Category Split</h2>
            <span class="rounded-full bg-[#e2e7ff] px-3 py-1 text-xs font-semibold text-[#003d9b]">Top Categories</span>
          </div>
          <div class="h-64 md:h-72">
            <canvas id="category-split-chart"></canvas>
          </div>
        </div>
      </section>

      <section class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
          <h2 class="text-lg font-bold">Recent Costs</h2>
        </div>
        <div class="space-y-3 p-4 md:hidden">
          @forelse($recentExpenses as $expense)
            <article class="rounded-xl border border-slate-100 bg-slate-50 p-4 shadow-sm">
              <div class="flex items-start justify-between gap-3">
                <div>
                  <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ optional($expense->expense_date)->format('Y-m-d') }}</p>
                  <h3 class="mt-1 font-bold text-slate-900">{{ $expense->title }}</h3>
                </div>
                <p class="text-right text-sm font-extrabold text-[#003d9b]">LKR {{ number_format((float) $expense->amount, 2) }}</p>
              </div>
              <div class="mt-3 grid grid-cols-2 gap-3 text-xs text-slate-600">
                <div>
                  <p class="font-semibold uppercase tracking-wide text-slate-500">Category</p>
                  <p class="mt-1">{{ $expense->category }}</p>
                </div>
                <div>
                  <p class="font-semibold uppercase tracking-wide text-slate-500">Payment</p>
                  <p class="mt-1">{{ str_replace('_', ' ', ucfirst($expense->payment_type)) }}</p>
                </div>
                <div>
                  <p class="font-semibold uppercase tracking-wide text-slate-500">Director</p>
                  <p class="mt-1">{{ $expense->director_name ?? '-' }}</p>
                </div>
                <div>
                  <p class="font-semibold uppercase tracking-wide text-slate-500">Receipt</p>
                  @if($expense->receipt_path)
                    <a class="mt-1 inline-flex items-center gap-1 font-semibold text-[#003d9b]" href="{{ url('/storage/' . $expense->receipt_path) }}" target="_blank" rel="noopener noreferrer">
                      <span class="material-symbols-outlined text-base">description</span>
                      View
                    </a>
                  @else
                    <p class="mt-1">No receipt</p>
                  @endif
                </div>
              </div>
            </article>
          @empty
            <p class="rounded-xl bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">No costs saved yet.</p>
          @endforelse
        </div>
        <div class="hidden overflow-x-auto md:block">
          <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
              <tr>
                <th class="px-5 py-3 text-left">Date</th>
                <th class="px-5 py-3 text-left">Title</th>
                <th class="px-5 py-3 text-left">Category</th>
                <th class="px-5 py-3 text-left">Payment Type</th>
                <th class="px-5 py-3 text-left">Director</th>
                <th class="px-5 py-3 text-right">Amount</th>
                <th class="px-5 py-3 text-center">Receipt</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentExpenses as $expense)
                <tr class="border-t border-slate-100">
                  <td class="px-5 py-3">{{ optional($expense->expense_date)->format('Y-m-d') }}</td>
                  <td class="px-5 py-3">{{ $expense->title }}</td>
                  <td class="px-5 py-3">{{ $expense->category }}</td>
                  <td class="px-5 py-3">{{ str_replace('_', ' ', ucfirst($expense->payment_type)) }}</td>
                  <td class="px-5 py-3">{{ $expense->director_name ?? '-' }}</td>
                  <td class="px-5 py-3 text-right font-semibold">LKR {{ number_format((float) $expense->amount, 2) }}</td>
                  <td class="px-5 py-3 text-center">
                    @if($expense->receipt_path)
                      <a class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-[#e2e7ff] text-[#003d9b] hover:bg-[#d6dcff]" href="{{ url('/storage/' . $expense->receipt_path) }}" target="_blank" rel="noopener noreferrer" title="Open receipt">
                        <span class="material-symbols-outlined text-base">description</span>
                      </a>
                    @else
                      <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-400" title="No receipt">
                        <span class="material-symbols-outlined text-base">description</span>
                      </span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td class="px-5 py-8 text-center text-slate-500" colspan="7">No costs saved yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>
  <nav class="fixed bottom-0 left-0 z-50 flex w-full justify-around border-t border-slate-100 bg-white px-2 py-3 md:hidden">
    <a class="flex flex-col items-center gap-1 text-[#003d9b]" href="{{ route('dashboard') }}">
      <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
      <span class="text-[10px] font-bold">Dashboard</span>
    </a>
    <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('expenses.create') }}">
      <span class="material-symbols-outlined">receipt_long</span>
      <span class="text-[10px]">Costs</span>
    </a>
    <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('projects') }}">
      <span class="material-symbols-outlined">architecture</span>
      <span class="text-[10px]">Sites</span>
    </a>
    <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('analytics') }}">
      <span class="material-symbols-outlined">bar_chart</span>
      <span class="text-[10px]">Insights</span>
    </a>
  </nav>
  <script>
    function renderCharts() {
      const axisColor = '#475569';
      const gridColor = 'rgba(71,85,105,0.15)';

      const monthlyLabels = @json($monthlyChartLabels);
      const monthlyValues = @json($monthlyChartValues);
      const categoryLabels = @json($categoryChartLabels);
      const categoryValues = @json($categoryChartValues);

      if (window.monthlyChartInstance) window.monthlyChartInstance.destroy();
      if (window.categoryChartInstance) window.categoryChartInstance.destroy();

      const monthlyCtx = document.getElementById('monthly-trend-chart');
      if (monthlyCtx) {
        window.monthlyChartInstance = new Chart(monthlyCtx, {
          type: 'line',
          data: {
            labels: monthlyLabels,
            datasets: [{
              label: 'Amount (LKR)',
              data: monthlyValues,
              borderColor: '#003d9b',
              backgroundColor: 'rgba(0, 61, 155, 0.18)',
              fill: true,
              tension: 0.35,
              pointRadius: 3,
              pointHoverRadius: 5,
            }],
          },
          options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
              x: { ticks: { color: axisColor }, grid: { color: gridColor } },
              y: { ticks: { color: axisColor }, grid: { color: gridColor } },
            },
          },
        });
      }

      const categoryCtx = document.getElementById('category-split-chart');
      if (categoryCtx) {
        window.categoryChartInstance = new Chart(categoryCtx, {
          type: 'doughnut',
          data: {
            labels: categoryLabels,
            datasets: [{
              data: categoryValues,
              backgroundColor: ['#003d9b', '#0052cc', '#2f74ff', '#5b95ff', '#8fb6ff'],
              borderWidth: 0,
            }],
          },
          options: {
            maintainAspectRatio: false,
            cutout: '64%',
            plugins: {
              legend: {
                position: 'bottom',
                labels: { color: axisColor, boxWidth: 10, boxHeight: 10 },
              },
            },
          },
        });
      }
    }

    renderCharts();
  </script>
</body>
</html>
