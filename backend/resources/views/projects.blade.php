<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#003d9b" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default" />
  <title>Gaura Projects</title>
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
        <form action="{{ route('projects') }}" method="GET" class="mt-3">
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
        <a class="flex items-center gap-3 rounded-lg border-r-4 border-[#003d9b] bg-[#e2e7ff] px-4 py-3 text-[#003d9b]" href="{{ route('projects') }}">
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
        <a class="font-bold text-[#003d9b] border-b-2 border-[#003d9b] pb-1" href="{{ route('projects') }}">Sites</a>
        <a class="text-[#434654] hover:bg-[#e2e7ff] rounded px-2 py-1" href="{{ route('expenses.create') }}">Site Costs</a>
        <a class="text-[#434654] hover:bg-[#e2e7ff] rounded px-2 py-1" href="{{ route('analytics') }}">Cost Insights</a>
      </nav>
      <div class="flex items-center gap-2">
        <a class="rounded-lg bg-[#003d9b] px-3 py-2 text-sm font-semibold text-white md:px-4" href="{{ route('expenses.create') }}">Add Cost</a>
      </div>
    </header>

    <main class="mx-auto w-full max-w-6xl flex-1 p-4 pb-28 md:p-10 md:pb-10">
      <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-start sm:justify-between">
        <div>
          <h1 class="text-2xl font-extrabold text-[#003d9b] md:text-3xl">Sites</h1>
          <p class="text-sm text-slate-600">Cost breakdown by construction site.</p>
        </div>
        <button onclick="document.getElementById('new-project-modal').classList.remove('hidden')"
                class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#003d9b] px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-[#0040a2] sm:w-auto">
          <span class="material-symbols-outlined text-base">add</span>
          New Site
        </button>
      </div>

      {{-- Flash messages --}}
      @if(session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700 font-semibold">
          <span class="material-symbols-outlined text-base">check_circle</span>
          {{ session('success') }}
        </div>
      @endif
      @if($errors->any())
        <div class="mb-6 flex items-center gap-3 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700 font-semibold">
          <span class="material-symbols-outlined text-base">error</span>
          {{ $errors->first() }}
        </div>
      @endif

      {{-- Summary Cards --}}
      <section class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
          <p class="text-sm text-slate-500">Active Sites</p>
          <p class="mt-2 text-3xl font-extrabold">{{ $projects->count() }}</p>
        </div>
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
          <p class="text-sm text-slate-500">Total Across Sites</p>
          <p class="mt-2 text-3xl font-extrabold">LKR {{ number_format((float) $projects->sum('total'), 2) }}</p>
        </div>
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
          <p class="text-sm text-slate-500">Unassigned Costs</p>
          <p class="mt-2 text-3xl font-extrabold">{{ $unassignedCount }}</p>
        </div>
      </section>

      {{-- Project Cards --}}
      @if($projects->isEmpty())
        <div class="rounded-xl border border-dashed border-slate-300 bg-white p-12 text-center">
          <span class="material-symbols-outlined text-5xl text-slate-300 mb-3 block">architecture</span>
          <p class="text-lg font-bold text-slate-500">No sites yet</p>
          <p class="text-sm text-slate-400 mt-1">Create a site first, then assign costs to it.</p>
          <button onclick="document.getElementById('new-project-modal').classList.remove('hidden')"
                  class="mt-6 inline-block rounded-lg bg-[#003d9b] px-6 py-2 text-sm font-semibold text-white">
            Create First Site
          </button>
        </div>
      @else
        <section class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
          @foreach($projects as $project)
            @php($grandTotal = (float) $projects->sum('total'))
            @php($pct = $grandTotal > 0 ? round(((float) $project->total / $grandTotal) * 100, 1) : 0)
            <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm flex flex-col gap-3">
              <div class="flex items-start justify-between">
                <div class="flex items-center gap-2">
                  <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#e2e7ff] text-[#003d9b]">
                    <span class="material-symbols-outlined text-lg">architecture</span>
                  </div>
                  <div>
                    <div class="font-bold text-sm">{{ $project->project_name }}</div>
                    <div class="text-xs text-slate-500">{{ $project->expense_count }} expense{{ $project->expense_count == 1 ? '' : 's' }}</div>
                  </div>
                </div>
                <span class="text-xs font-bold text-[#003d9b] bg-[#e2e7ff] px-2 py-1 rounded-full">{{ $pct }}%</span>
              </div>
              <div class="text-2xl font-extrabold">LKR {{ number_format((float) $project->total, 2) }}</div>
              <div class="h-1.5 rounded-full bg-slate-100">
                <div class="h-1.5 rounded-full bg-[#003d9b]" style="width: {{ $pct }}%"></div>
              </div>
            </div>
          @endforeach
        </section>

        {{-- Recent Site Costs Table --}}
        <section class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
          <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="text-lg font-bold">Site Costs</h2>
          </div>
          <div class="space-y-3 p-4 md:hidden">
            @forelse($recentExpenses as $expense)
              <article class="rounded-xl border border-slate-100 bg-slate-50 p-4 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                  <div>
                    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">{{ optional($expense->expense_date)->format('Y-m-d') }}</p>
                    <h3 class="mt-1 font-bold text-slate-900">{{ $expense->title }}</h3>
                    <p class="mt-1 text-sm text-slate-600">{{ $expense->project_name }}</p>
                  </div>
                  <p class="text-right text-sm font-extrabold text-[#003d9b]">LKR {{ number_format((float) $expense->amount, 2) }}</p>
                </div>
                <div class="mt-3 flex flex-wrap items-center gap-2 text-xs">
                  <span class="rounded-full bg-[#e2e7ff] px-2 py-1 font-semibold text-[#003d9b]">{{ $expense->category }}</span>
                  <span class="text-slate-500">Director: {{ $expense->director_name ?? '—' }}</span>
                </div>
              </article>
            @empty
              <p class="rounded-xl bg-slate-50 px-4 py-6 text-center text-sm text-slate-400">No site costs yet.</p>
            @endforelse
          </div>
          <div class="hidden overflow-x-auto md:block">
            <table class="w-full text-sm">
              <thead class="bg-slate-50 text-slate-600">
                <tr>
                  <th class="px-5 py-3 text-left">Date</th>
                  <th class="px-5 py-3 text-left">Project</th>
                  <th class="px-5 py-3 text-left">Title</th>
                  <th class="px-5 py-3 text-left">Category</th>
                  <th class="px-5 py-3 text-left">Director</th>
                  <th class="px-5 py-3 text-right">Amount</th>
                  <th class="px-5 py-3 text-center">Receipt</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentExpenses as $expense)
                  <tr class="border-t border-slate-100 hover:bg-slate-50">
                    <td class="px-5 py-3 text-slate-500">{{ optional($expense->expense_date)->format('Y-m-d') }}</td>
                    <td class="px-5 py-3 font-medium">{{ $expense->project_name }}</td>
                    <td class="px-5 py-3">{{ $expense->title }}</td>
                    <td class="px-5 py-3">
                      <span class="rounded-full bg-[#e2e7ff] px-2 py-0.5 text-xs font-semibold text-[#003d9b]">{{ $expense->category }}</span>
                    </td>
                    <td class="px-5 py-3 text-slate-500">{{ $expense->director_name ?? '—' }}</td>
                    <td class="px-5 py-3 text-right font-bold">LKR {{ number_format((float) $expense->amount, 2) }}</td>
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
                  <tr><td colspan="7" class="px-5 py-8 text-center text-slate-400">No site costs yet.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </section>
      @endif
    </main>
  </div>

  {{-- New Project Modal --}}
  <div id="new-project-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
    <div class="w-full max-w-md rounded-2xl bg-white p-5 shadow-2xl md:p-8">
      <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-extrabold text-[#003d9b]">New Project</h2>
        <button onclick="document.getElementById('new-project-modal').classList.add('hidden')"
                class="flex h-8 w-8 items-center justify-center rounded-full text-slate-400 hover:bg-slate-100 transition-colors">
          <span class="material-symbols-outlined text-lg">close</span>
        </button>
      </div>
      <form method="POST" action="{{ route('projects.store') }}">
        @csrf
        <div class="mb-5">
          <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Project Name</label>
          <input name="name" type="text" required maxlength="100"
                 placeholder="e.g., Galle Road Site 102"
                 class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-[#003d9b] focus:ring-1 focus:ring-[#003d9b] outline-none" />
        </div>
        <div class="flex flex-col gap-3 sm:flex-row">
          <button type="submit"
                  class="flex-1 rounded-lg bg-[#003d9b] py-3 text-sm font-bold text-white hover:bg-[#0040a2] transition-colors">
            Create Project
          </button>
          <button type="button"
                  onclick="document.getElementById('new-project-modal').classList.add('hidden')"
                  class="flex-1 rounded-lg border border-slate-200 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>

  <nav class="md:hidden fixed bottom-0 left-0 w-full bg-white flex justify-around py-3 px-2 border-t border-slate-100 z-50">
    <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('dashboard') }}">
      <span class="material-symbols-outlined">dashboard</span>
      <span class="text-[10px]">Home</span>
    </a>
    <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('expenses.create') }}">
      <span class="material-symbols-outlined">receipt_long</span>
      <span class="text-[10px]">Costs</span>
    </a>
    <a class="flex flex-col items-center gap-1 text-[#003d9b]" href="{{ route('projects') }}">
      <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">architecture</span>
      <span class="text-[10px] font-bold">Sites</span>
    </a>
    <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('analytics') }}">
      <span class="material-symbols-outlined">bar_chart</span>
      <span class="text-[10px]">Insights</span>
    </a>
  </nav>
  <script>
  </script>
</body>
</html>
