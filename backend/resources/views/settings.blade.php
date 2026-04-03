<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#003d9b" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default" />
  <title>GAURA Settings</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
  <style>
    body { font-family: Inter, sans-serif; background: #faf8ff; color: #131b2e; }
    h1, h2, h3 { font-family: Manrope, sans-serif; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    body.dark { background: #0b1220; color: #e5e7eb; }
    body.dark aside, body.dark header { background: #111827 !important; color: #e5e7eb; }
    body.dark .bg-white, body.dark .bg-slate-50 { background: #1f2937 !important; }
    body.dark .border-slate-100, body.dark .border-slate-200 { border-color: #374151 !important; }
    body.dark .text-slate-500, body.dark .text-slate-600 { color: #9ca3af !important; }
    body.dark .text-[#434654] { color: #d1d5db !important; }
    body.dark .bg-[#f2f3ff] { background: #1f2937 !important; }
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
        <form action="{{ route('settings') }}" method="GET" class="mt-3">
          <select name="active_project" onchange="this.form.submit()" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 focus:border-[#003d9b] focus:ring-[#003d9b]">
            <option value="">All Projects</option>
            @foreach($availableProjects as $projectName)
              <option value="{{ $projectName }}" {{ $selectedProjectName === $projectName ? 'selected' : '' }}>{{ $projectName }}</option>
            @endforeach
          </select>
        </form>
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
        <a class="flex items-center gap-3 rounded-lg px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('analytics') }}">
          <span class="material-symbols-outlined">bar_chart</span>
          <span class="text-sm font-medium">Analytics</span>
        </a>
        <a class="flex translate-x-1 items-center gap-3 rounded-lg border-r-4 border-[#003d9b] bg-[#e2e7ff] px-4 py-3 text-[#003d9b]" href="{{ route('settings') }}">
          <span class="material-symbols-outlined">settings</span>
          <span class="text-sm font-medium">Settings</span>
        </a>
      </nav>
    </div>
  </aside>

  <div class="flex min-h-screen flex-col md:ml-64">
    <header class="sticky top-0 z-30 flex w-full items-center justify-between bg-[#faf8ff] px-6 py-3">
      <div class="text-xl font-black text-[#003d9b] md:hidden">GA</div>
      <nav class="hidden items-center gap-6 md:flex">
        <a class="text-[#434654] hover:bg-[#e2e7ff] rounded px-2 py-1" href="{{ route('dashboard') }}">Dashboard</a>
        <a class="font-bold text-[#003d9b] border-b-2 border-[#003d9b] pb-1" href="{{ route('settings') }}">Settings</a>
      </nav>
      <button id="theme-toggle" class="theme-toggle rounded-lg px-3 py-2 text-sm font-semibold" type="button">Dark</button>
    </header>

    <main class="mx-auto w-full max-w-6xl flex-1 p-6 pb-24 md:p-10 md:pb-10">
      <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-[#003d9b]">Settings</h1>
        <p class="text-sm text-slate-600">Manage application preferences.</p>
      </div>

      <section class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
          <h2 class="text-lg font-bold">Appearance</h2>
          <p class="mt-2 text-sm text-slate-500">Use the theme toggle in the header to switch dark and light modes.</p>
        </div>
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
          <h2 class="text-lg font-bold">Active Project</h2>
          <p class="mt-2 text-sm text-slate-500">Current selection: {{ $selectedProjectName ?: 'All Projects' }}</p>
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
      <span class="text-[10px]">Expenses</span>
    </a>
    <a class="flex flex-col items-center gap-1 text-slate-400" href="{{ route('projects') }}">
      <span class="material-symbols-outlined">architecture</span>
      <span class="text-[10px]">Projects</span>
    </a>
    <a class="flex flex-col items-center gap-1 text-[#003d9b]" href="{{ route('settings') }}">
      <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">settings</span>
      <span class="text-[10px] font-bold">Settings</span>
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
      });
    })();
  </script>
</body>
</html>
