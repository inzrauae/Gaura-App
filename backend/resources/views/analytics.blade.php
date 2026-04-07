<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#003d9b" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default" />
  <title>Gaura Analytics</title>
  <link rel="icon" type="image/png" href="{{ asset('img/gaura-logo.png') }}" />
  <link rel="apple-touch-icon" href="{{ asset('img/gaura-logo.png') }}" />
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
      <div class="mb-8 rounded-xl bg-[#f2f3ff] p-4 border border-amber-100">
        <div class="flex items-center gap-3">
          <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white border border-slate-200 shadow-sm">
            <img src="{{ asset('img/gaura-logo.png') }}" alt="GAURA mark" class="h-7 w-7 object-contain" />
          </div>
          <div>
            <div class="inline-block rounded-md bg-white px-2 py-0.5 text-sm font-bold text-[#003d9b]">{{ $sidebarProjectName }}</div>
            <div class="text-xs text-slate-500">Construction Operations</div>
          </div>
        </div>
        <form action="{{ route('analytics') }}" method="GET" class="mt-3">
          <select name="active_project" onchange="this.form.submit()" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 focus:border-[#003d9b] focus:ring-[#003d9b]">
            <option value="">All Sites</option>
            @foreach($availableProjects as $projectName)
              <option value="{{ $projectName }}" {{ $selectedProjectName === $projectName ? 'selected' : '' }}>{{ $projectName }}</option>
            @endforeach
          </select>
        </form>
      </div>
      <nav class="space-y-1">
        <a class="flex items-center gap-3 rounded-lg border-r-4 border-transparent px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('dashboard') }}">
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
        <a class="flex items-center gap-3 rounded-lg border-r-4 border-[#003d9b] bg-[#e2e7ff] px-4 py-3 text-[#003d9b]" href="{{ route('analytics') }}">
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
        <a class="text-[#434654] hover:bg-[#e2e7ff] rounded px-2 py-1" href="{{ route('dashboard') }}">Dashboard</a>
        <a class="text-[#434654] hover:bg-[#e2e7ff] rounded px-2 py-1" href="{{ route('expenses.create') }}">Site Costs</a>
        <a class="font-bold text-[#003d9b] border-b-2 border-[#003d9b] pb-1" href="{{ route('analytics') }}">Cost Insights</a>
      </nav>
      <div class="flex items-center gap-2">
        <a class="rounded-lg bg-[#003d9b] px-3 py-2 text-sm font-semibold text-white md:px-4" href="{{ route('expenses.create') }}">Add Cost</a>
      </div>
    </header>

    <main class="mx-auto w-full max-w-6xl flex-1 p-4 pb-28 md:p-10 md:pb-10">
      <div class="mb-8 flex flex-col gap-4 md:flex-row md:flex-wrap md:items-end md:justify-between">
        <div>
          <h1 class="text-2xl font-extrabold text-[#003d9b] md:text-3xl">Construction Cost Analytics</h1>
          <p class="text-sm text-slate-600">Cost distribution across categories, payment types, directors, and monthly trends.</p>
        </div>
        <form action="{{ route('analytics') }}" method="GET" class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:items-end">
          <div>
            <label for="project_name" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Site</label>
            <select id="project_name" name="active_project" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-[#003d9b] focus:ring-[#003d9b] sm:min-w-[220px]">
              <option value="">All Sites</option>
              @foreach($availableProjects as $projectName)
                <option value="{{ $projectName }}" {{ $selectedProjectName === $projectName ? 'selected' : '' }}>{{ $projectName }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="rounded-lg bg-[#003d9b] px-4 py-2 text-sm font-semibold text-white">Apply</button>
        </form>
      </div>

      <section class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm md:p-5">
          <p class="text-sm text-slate-500">Total Amount</p>
          <p class="mt-2 text-3xl font-extrabold text-[#003d9b]">LKR {{ number_format($totalAmount, 2) }}</p>
        </div>
        <div class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm md:p-5">
          <p class="text-sm text-slate-500">Company Paid</p>
          <p class="mt-2 text-3xl font-extrabold text-[#003d9b]">LKR {{ number_format($companyPaidTotal, 2) }}</p>
        </div>
        <div class="rounded-xl border-2 border-[#fdc425] bg-gradient-to-br from-[#fffbeb] to-[#fef3c7] p-4 shadow-sm md:p-5">
          <p class="text-sm font-semibold text-[#785a00]">Director Paid</p>
          <p class="mt-2 text-3xl font-extrabold text-[#785a00]">LKR {{ number_format($directorPaidTotal, 2) }}</p>
        </div>
      </section>

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <section class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
          <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="text-lg font-bold">Category Breakdown</h2>
          </div>
          <div class="space-y-4 p-4 md:p-5">
            @forelse($categoryTotals as $row)
              @php($percent = $totalAmount > 0 ? round(((float) $row->total / $totalAmount) * 100, 1) : 0)
              <div>
                <div class="mb-1 flex items-center justify-between text-sm">
                  <span class="font-semibold">{{ $row->category }}</span>
                  <span>LKR {{ number_format((float) $row->total, 2) }} ({{ $percent }}%)</span>
                </div>
                <div class="h-2 rounded-full bg-slate-100">
                  <div class="h-2 rounded-full bg-gradient-to-r from-[#003d9b] to-[#0052cc]" style="width: {{ $percent }}%"></div>
                </div>
              </div>
            @empty
              <p class="text-sm text-slate-500">No category data yet.</p>
            @endforelse
          </div>
        </section>

        <section class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
          <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="text-lg font-bold">Monthly Trend</h2>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="bg-slate-50 text-slate-600">
                <tr>
                  <th class="px-5 py-3 text-left">Month</th>
                  <th class="px-5 py-3 text-right">Total Amount</th>
                </tr>
              </thead>
              <tbody>
                @forelse($monthlyTotals as $row)
                  <tr class="border-t border-slate-100">
                    <td class="px-5 py-3">{{ $row->month }}</td>
                    <td class="px-5 py-3 text-right font-semibold">LKR {{ number_format((float) $row->total, 2) }}</td>
                  </tr>
                @empty
                  <tr>
                    <td class="px-5 py-8 text-center text-slate-500" colspan="2">No monthly data yet.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </section>
      </div>

      <section class="mt-6">
        <div class="mb-4">
          <h2 class="text-lg font-bold text-[#785a00]">Director Hand Expenses (For Company Reimbursement)</h2>
        </div>
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
          @foreach($directorHandExpenseTables as $table)
            <div class="overflow-hidden rounded-xl border-2 border-[#fdc425] bg-gradient-to-br from-[#fffbeb] to-[#fef3c7] shadow-sm">
              <div class="border-b border-[#fdc425] px-5 py-4">
                <h3 class="font-bold text-[#785a00]">{{ $table['director_name'] }}</h3>
                <p class="text-sm text-[#8b6914]">Hand Total: LKR {{ number_format((float) $table['total'], 2) }}</p>
              </div>
              <div class="space-y-3 p-4 md:hidden">
                @forelse($table['rows'] as $row)
                  <article class="rounded-xl border border-[#fdc425]/40 bg-white/60 p-3">
                    <div class="flex items-start justify-between gap-3">
                      <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-[#8b6914]">{{ optional($row->expense_date)->format('Y-m-d') }}</p>
                        <p class="mt-1 font-semibold text-[#785a00]">{{ $row->title }}</p>
                        <p class="mt-1 text-xs text-[#8b6914]">{{ $row->project_name ?: 'No Project' }}</p>
                      </div>
                      <p class="text-right text-sm font-bold text-[#785a00]">LKR {{ number_format((float) $row->amount, 2) }}</p>
                    </div>
                  </article>
                @empty
                  <p class="rounded-xl bg-white/60 px-4 py-6 text-center text-sm text-[#8b6914]">No cash-in-hand expenses.</p>
                @endforelse
              </div>
              <div class="hidden overflow-x-auto md:block">
                <table class="w-full text-sm">
                  <thead class="bg-[#fef3c7] text-[#785a00]">
                    <tr>
                      <th class="px-4 py-3 text-left">Date</th>
                      <th class="px-4 py-3 text-left">Expense</th>
                      <th class="px-4 py-3 text-right">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($table['rows'] as $row)
                      <tr class="border-t border-[#fdc425]/30">
                        <td class="px-4 py-3 text-xs text-[#8b6914]">{{ optional($row->expense_date)->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">
                          <div class="font-medium text-[#785a00]">{{ $row->title }}</div>
                          <div class="text-xs text-[#8b6914]">{{ $row->project_name ?: 'No Project' }}</div>
                        </td>
                        <td class="px-4 py-3 text-right font-semibold text-[#785a00]">LKR {{ number_format((float) $row->amount, 2) }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td class="px-4 py-6 text-center text-[#8b6914]" colspan="3">No cash-in-hand expenses.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          @endforeach
        </div>
      </section>
    </main>
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
    <a class="flex flex-col items-center gap-1 text-[#003d9b]" href="{{ route('analytics') }}">
      <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">bar_chart</span>
      <span class="text-[10px] font-bold">Insights</span>
    </a>
  </nav>
  <script>
  </script>
</body>
</html>
