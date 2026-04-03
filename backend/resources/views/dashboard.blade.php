<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#003d9b" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default" />
  <title>Gaura Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
  <style>
    body { font-family: Inter, sans-serif; background: #faf8ff; color: #131b2e; }
    h1, h2, h3 { font-family: Manrope, sans-serif; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    body.dark { background: #0b1220; color: #e5e7eb; }
    body.dark aside, body.dark header { background: #111827 !important; color: #e5e7eb; }
    body.dark .bg-white { background: #1f2937 !important; }
    body.dark .bg-slate-50 { background: #111827 !important; }
    body.dark .border-slate-100, body.dark .border-slate-200 { border-color: #374151 !important; }
    body.dark .text-slate-500, body.dark .text-slate-600 { color: #9ca3af !important; }
    body.dark .text-[#434654] { color: #d1d5db !important; }
    body.dark .bg-[#f2f3ff] { background: #1f2937 !important; }
    body.dark a:hover { background: #1f2937 !important; }
    .theme-toggle { border: 1px solid #d1d5db; }
    body.dark .theme-toggle { border-color: #374151; color: #e5e7eb; background: #111827; }
  </style>
</head>
<body>
  <aside class="fixed left-0 top-0 z-40 hidden h-screen w-64 flex-col bg-[#faf8ff] shadow-[8px_0_24px_rgba(19,27,46,0.06)] md:flex">
    <div class="px-6 py-8">
      <div class="mb-8 text-lg font-bold text-[#003d9b]">GAURA</div>
      <div class="mb-8 rounded-xl bg-[#f2f3ff] p-4">
        <div class="flex items-center gap-3">
          <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#0052cc] text-white">
            <span class="material-symbols-outlined">architecture</span>
          </div>
          <div>
            <div class="text-sm font-bold">{{ $sidebarProjectName }}</div>
            <div class="text-xs text-slate-500">{{ $sidebarProjectSubtitle }}</div>
          </div>
        </div>
        <form action="{{ route('dashboard') }}" method="GET" class="mt-3">
          <select name="active_project" onchange="this.form.submit()" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 focus:border-[#003d9b] focus:ring-[#003d9b]">
            <option value="">All Projects</option>
            @foreach($availableProjects as $projectName)
              <option value="{{ $projectName }}" {{ $selectedProjectName === $projectName ? 'selected' : '' }}>{{ $projectName }}</option>
            @endforeach
          </select>
        </form>
      </div>
      <nav class="space-y-1">
        <a class="flex translate-x-1 items-center gap-3 rounded-lg border-r-4 border-[#003d9b] bg-[#e2e7ff] px-4 py-3 text-[#003d9b]" href="{{ route('dashboard') }}">
          <span class="material-symbols-outlined">dashboard</span>
          <span class="text-sm font-medium">Dashboard</span>
        </a>
        <a class="flex items-center gap-3 rounded-lg px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('expenses.create') }}">
          <span class="material-symbols-outlined">receipt_long</span>
          <span class="text-sm font-medium">Expenses</span>
        </a>
        <a class="flex items-center gap-3 rounded-lg px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('projects') }}">
          <span class="material-symbols-outlined">architecture</span>
          <span class="text-sm font-medium">Projects</span>
        </a>
        <a class="flex items-center gap-3 rounded-lg px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('analytics') }}">
          <span class="material-symbols-outlined">bar_chart</span>
          <span class="text-sm font-medium">Analytics</span>
        </a>
        <a class="flex items-center gap-3 rounded-lg px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('settings') }}">
          <span class="material-symbols-outlined">settings</span>
          <span class="text-sm font-medium">Settings</span>
        </a>
      </nav>
    </div>
    <div class="mt-auto px-6 py-6">
      <a class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-br from-[#003d9b] to-[#0052cc] px-4 py-3 font-bold text-white" href="{{ route('expenses.create') }}">
        <span class="material-symbols-outlined">add</span>
        New Expense
      </a>
    </div>
  </aside>

  <div class="flex min-h-screen flex-col md:ml-64">
    <header class="sticky top-0 z-30 flex w-full items-center justify-between bg-[#faf8ff] px-6 py-3">
      <div class="text-xl font-black text-[#003d9b] md:hidden">CS</div>
      <nav class="hidden items-center gap-6 md:flex">
        <a class="font-bold text-[#003d9b] border-b-2 border-[#003d9b] pb-1" href="{{ route('dashboard') }}">Dashboard</a>
        <a class="text-[#434654] hover:bg-[#e2e7ff] rounded px-2 py-1" href="{{ route('expenses.create') }}">Expenses</a>
      </nav>
      <div class="flex items-center gap-2">
        <button id="theme-toggle" class="theme-toggle rounded-lg px-3 py-2 text-sm font-semibold" type="button">Dark</button>
        <a class="rounded-lg bg-[#003d9b] px-4 py-2 text-sm font-semibold text-white" href="{{ route('expenses.create') }}">Add Expense</a>
      </div>
    </header>

    <main class="mx-auto w-full max-w-6xl flex-1 p-6 pb-24 md:p-10 md:pb-10">
      <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-[#003d9b]">Gaura Expense Dashboard</h1>
        <p class="text-sm text-slate-600">Overview of construction expense activity.</p>
      </div>

      <section class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
          <p class="text-sm text-slate-500">Total Records</p>
          <p class="mt-2 text-3xl font-extrabold">{{ $totalExpenses }}</p>
        </div>
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
          <p class="text-sm text-slate-500">Total Amount</p>
          <p class="mt-2 text-3xl font-extrabold">LKR {{ number_format((float) $totalAmount, 2) }}</p>
        </div>
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
          <p class="text-sm text-slate-500">This Month</p>
          <p class="mt-2 text-3xl font-extrabold">LKR {{ number_format((float) $thisMonthAmount, 2) }}</p>
        </div>
      </section>

      <section class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="overflow-hidden rounded-xl border border-slate-100 bg-white p-5 shadow-sm lg:col-span-2">
          <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold">Monthly Expense Trend</h2>
            <span class="rounded-full bg-[#e2e7ff] px-3 py-1 text-xs font-semibold text-[#003d9b]">Live Data</span>
          </div>
          <div class="h-72">
            <canvas id="monthly-trend-chart"></canvas>
          </div>
        </div>
        <div class="overflow-hidden rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
          <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold">Category Split</h2>
            <span class="rounded-full bg-[#e2e7ff] px-3 py-1 text-xs font-semibold text-[#003d9b]">Top Categories</span>
          </div>
          <div class="h-72">
            <canvas id="category-split-chart"></canvas>
          </div>
        </div>
      </section>

      <section class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
          <h2 class="text-lg font-bold">Recent Expenses</h2>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
              <tr>
                <th class="px-5 py-3 text-left">Date</th>
                <th class="px-5 py-3 text-left">Title</th>
                <th class="px-5 py-3 text-left">Category</th>
                <th class="px-5 py-3 text-left">Payment Type</th>
                <th class="px-5 py-3 text-left">Director</th>
                <th class="px-5 py-3 text-right">Amount</th>
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
                </tr>
              @empty
                <tr>
                  <td class="px-5 py-8 text-center text-slate-500" colspan="6">No expenses saved yet.</td>
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
      <span class="text-[10px]">Expenses</span>
    </a>
    <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('projects') }}">
      <span class="material-symbols-outlined">architecture</span>
      <span class="text-[10px]">Projects</span>
    </a>
    <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('analytics') }}">
      <span class="material-symbols-outlined">bar_chart</span>
      <span class="text-[10px]">Reports</span>
    </a>
  </nav>
  <script>
    (function () {
      const key = 'gaura_theme';
      const saved = localStorage.getItem(key);
      if (saved === 'dark') document.body.classList.add('dark');
      const btn = document.getElementById('theme-toggle');
      const sync = () => { btn.textContent = document.body.classList.contains('dark') ? 'Light' : 'Dark'; };
      sync();
      btn.addEventListener('click', function () {
        document.body.classList.toggle('dark');
        localStorage.setItem(key, document.body.classList.contains('dark') ? 'dark' : 'light');
        sync();
        renderCharts();
      });
    })();

    function renderCharts() {
      const isDark = document.body.classList.contains('dark');
      const axisColor = isDark ? '#9ca3af' : '#475569';
      const gridColor = isDark ? 'rgba(156,163,175,0.15)' : 'rgba(71,85,105,0.15)';

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
