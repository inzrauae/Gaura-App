<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gaura Analytics</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
  <style>
    body { font-family: Inter, sans-serif; background: #faf8ff; color: #131b2e; }
    h1, h2, h3 { font-family: Manrope, sans-serif; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
  </style>
</head>
<body>
  <aside class="fixed left-0 top-0 z-40 hidden h-screen w-64 flex-col bg-[#faf8ff] shadow-[8px_0_24px_rgba(19,27,46,0.06)] md:flex">
    <div class="px-6 py-8">
      <div class="mb-8 text-lg font-bold text-[#003d9b]">ConstructSafe</div>
      <div class="mb-8 rounded-xl bg-[#f2f3ff] p-4">
        <div class="flex items-center gap-3">
          <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#0052cc] text-white">
            <span class="material-symbols-outlined">architecture</span>
          </div>
          <div>
            <div class="text-sm font-bold">Project Alpha</div>
            <div class="text-xs text-slate-500">Site 102 - London</div>
          </div>
        </div>
      </div>
      <nav class="space-y-1">
        <a class="flex items-center gap-3 rounded-lg px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('dashboard') }}">
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
        <a class="flex translate-x-1 items-center gap-3 rounded-lg border-r-4 border-[#003d9b] bg-[#e2e7ff] px-4 py-3 text-[#003d9b]" href="{{ route('analytics') }}">
          <span class="material-symbols-outlined">bar_chart</span>
          <span class="text-sm font-medium">Analytics</span>
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
        <a class="text-[#434654] hover:bg-[#e2e7ff] rounded px-2 py-1" href="{{ route('dashboard') }}">Dashboard</a>
        <a class="text-[#434654] hover:bg-[#e2e7ff] rounded px-2 py-1" href="{{ route('expenses.create') }}">Expenses</a>
        <a class="font-bold text-[#003d9b] border-b-2 border-[#003d9b] pb-1" href="{{ route('analytics') }}">Analytics</a>
      </nav>
      <a class="rounded-lg bg-[#003d9b] px-4 py-2 text-sm font-semibold text-white" href="{{ route('expenses.create') }}">Add Expense</a>
    </header>

    <main class="mx-auto w-full max-w-6xl flex-1 p-6 md:p-10">
      <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-[#003d9b]">Expense Analytics</h1>
        <p class="text-sm text-slate-600">Financial distribution across categories, payment types, and months.</p>
      </div>

      <section class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
          <p class="text-sm text-slate-500">Total Amount</p>
          <p class="mt-2 text-3xl font-extrabold">LKR {{ number_format($totalAmount, 2) }}</p>
        </div>
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
          <p class="text-sm text-slate-500">Company Paid</p>
          <p class="mt-2 text-3xl font-extrabold">LKR {{ number_format($companyPaidTotal, 2) }}</p>
        </div>
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
          <p class="text-sm text-slate-500">Director Paid</p>
          <p class="mt-2 text-3xl font-extrabold">LKR {{ number_format($directorPaidTotal, 2) }}</p>
        </div>
      </section>

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <section class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
          <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="text-lg font-bold">Category Breakdown</h2>
          </div>
          <div class="p-5 space-y-4">
            @forelse($categoryTotals as $row)
              @php($percent = $totalAmount > 0 ? round(((float) $row->total / $totalAmount) * 100, 1) : 0)
              <div>
                <div class="mb-1 flex items-center justify-between text-sm">
                  <span class="font-semibold">{{ $row->category }}</span>
                  <span>LKR {{ number_format((float) $row->total, 2) }} ({{ $percent }}%)</span>
                </div>
                <div class="h-2 rounded-full bg-slate-100">
                  <div class="h-2 rounded-full bg-[#003d9b]" style="width: {{ $percent }}%"></div>
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

      <section class="mt-6 overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
          <h2 class="text-lg font-bold">Director Reimbursement Breakdown</h2>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
              <tr>
                <th class="px-5 py-3 text-left">Director</th>
                <th class="px-5 py-3 text-right">Director-Paid Amount</th>
              </tr>
            </thead>
            <tbody>
              @forelse($directorTotals as $row)
                <tr class="border-t border-slate-100">
                  <td class="px-5 py-3 font-semibold">{{ $row->director_name }}</td>
                  <td class="px-5 py-3 text-right">LKR {{ number_format((float) $row->total, 2) }}</td>
                </tr>
              @empty
                <tr>
                  <td class="px-5 py-8 text-center text-slate-500" colspan="2">No director-paid entries yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
