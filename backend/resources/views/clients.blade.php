<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#003d9b" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default" />
  <title>Gaura Clients</title>
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
        <form action="{{ route('clients') }}" method="GET" class="mt-3">
          @if(!empty($search))
            <input type="hidden" name="q" value="{{ $search }}" />
          @endif
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
        <a class="flex items-center gap-3 rounded-lg border-r-4 border-[#003d9b] bg-[#e2e7ff] px-4 py-3 text-[#003d9b]" href="{{ route('clients') }}">
          <span class="material-symbols-outlined">groups</span>
          <span class="text-sm font-medium">Clients</span>
        </a>
        <a class="flex items-center gap-3 rounded-lg border-r-4 border-transparent px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('analytics') }}">
          <span class="material-symbols-outlined">bar_chart</span>
          <span class="text-sm font-medium">Cost Insights</span>
        </a>
        <a class="flex items-center gap-3 rounded-lg border-r-4 border-transparent px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('reports') }}">
          <span class="material-symbols-outlined">assessment</span>
          <span class="text-sm font-medium">Reports</span>
        </a>
        <a class="flex items-center gap-3 rounded-lg border-r-4 border-transparent px-4 py-3 text-[#434654] hover:bg-[#f2f3ff]" href="{{ route('settings') }}">
          <span class="material-symbols-outlined">settings</span>
          <span class="text-sm font-medium">Settings</span>
        </a>
      </nav>
    </div>
  </aside>

  <div class="flex min-h-screen flex-col md:ml-64">
    <header class="sticky top-0 z-30 flex w-full items-center justify-between bg-[#faf8ff] px-4 py-3 md:px-6">
      <div class="text-xl font-black text-[#003d9b] md:hidden">GA</div>
      <nav class="hidden items-center gap-6 md:flex">
        <a class="text-[#434654] hover:bg-[#e2e7ff] rounded px-2 py-1" href="{{ route('dashboard') }}">Dashboard</a>
        <a class="font-bold text-[#003d9b] border-b-2 border-[#003d9b] pb-1" href="{{ route('clients') }}">Clients</a>
      </nav>
      <a class="rounded-lg bg-[#003d9b] px-3 py-2 text-sm font-semibold text-white md:px-4" href="{{ route('expenses.create') }}">Add Cost</a>
    </header>

    <main class="mx-auto w-full max-w-6xl flex-1 p-4 pb-28 md:p-10 md:pb-10">
      <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-[#003d9b] md:text-3xl">Clients CMS</h1>
        <p class="text-sm text-slate-600">Save and manage client/person records for your construction operations.</p>
      </div>

      @if(session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-700">
          <span class="material-symbols-outlined text-base">check_circle</span>
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div class="mb-6 flex items-center gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
          <span class="material-symbols-outlined text-base">error</span>
          {{ $errors->first() }}
        </div>
      @endif

      <section class="mb-8 rounded-xl border border-slate-100 bg-white p-4 shadow-sm md:p-6">
        <h2 class="mb-4 text-lg font-bold">Add Client / Person</h2>
        <form method="POST" action="{{ route('clients.store') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
          @csrf
          <div>
            <label class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-500">Name</label>
            <input name="name" required maxlength="150" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-[#003d9b] focus:ring-[#003d9b]" />
          </div>
          <div>
            <label class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-500">Type</label>
            <select name="entity_type" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-[#003d9b] focus:ring-[#003d9b]">
              <option value="client">Client</option>
              <option value="person">Person</option>
            </select>
          </div>
          <div>
            <label class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-500">Company</label>
            <input name="company" maxlength="150" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-[#003d9b] focus:ring-[#003d9b]" />
          </div>
          <div>
            <label class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-500">Phone</label>
            <input name="phone" maxlength="50" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-[#003d9b] focus:ring-[#003d9b]" />
          </div>
          <div>
            <label class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-500">Email</label>
            <input name="email" type="email" maxlength="150" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-[#003d9b] focus:ring-[#003d9b]" />
          </div>
          <div>
            <label class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-500">Address</label>
            <input name="address" maxlength="255" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-[#003d9b] focus:ring-[#003d9b]" />
          </div>
          <div class="md:col-span-2">
            <label class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-500">Notes</label>
            <textarea name="notes" rows="3" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-[#003d9b] focus:ring-[#003d9b]"></textarea>
          </div>
          <div class="md:col-span-2">
            <button type="submit" class="rounded-lg bg-[#003d9b] px-4 py-2 text-sm font-bold text-white hover:bg-[#0040a2]">Save Record</button>
          </div>
        </form>
      </section>

      <section class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-lg font-bold">Saved Clients / Persons</h2>
            <form method="GET" action="{{ route('clients') }}" class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:items-center">
              <input type="hidden" name="active_project" value="{{ $selectedProjectName ?? '' }}" />
              <input
                type="text"
                name="q"
                value="{{ $search ?? '' }}"
                placeholder="Search name, type, company, phone..."
                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-[#003d9b] focus:ring-[#003d9b] sm:w-64"
              />
              <button type="submit" class="rounded-lg bg-[#003d9b] px-3 py-2 text-sm font-semibold text-white">Search</button>
              @if(!empty($search))
                <a href="{{ route('clients', ['active_project' => $selectedProjectName]) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Clear</a>
              @endif
            </form>
          </div>
        </div>
        <div class="space-y-3 p-4 md:hidden">
          @forelse($clients as $client)
            @php
              $phoneRaw = $client->phone ?? '';
              $phoneDigits = preg_replace('/\D+/', '', $phoneRaw);
              $waText = rawurlencode("Hello {$client->name}, this is GAURA Construction.");
            @endphp
            <article class="rounded-xl border border-slate-100 bg-slate-50 p-4 shadow-sm">
              <div class="flex items-start justify-between gap-3">
                <div>
                  <h3 class="font-bold text-slate-900">{{ $client->name }}</h3>
                  <p class="mt-1 text-xs uppercase tracking-wide text-slate-500">{{ $client->entity_type }}</p>
                </div>
                <div class="flex items-center gap-2">
                  @if($phoneDigits)
                    <a class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-green-100 text-green-700" href="https://wa.me/{{ $phoneDigits }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer">
                      <span class="material-symbols-outlined text-base">chat</span>
                    </a>
                    <a class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100 text-blue-700" href="tel:{{ $phoneRaw }}">
                      <span class="material-symbols-outlined text-base">call</span>
                    </a>
                  @endif
                </div>
              </div>
              <div class="mt-3 grid grid-cols-1 gap-2 text-sm text-slate-600">
                <p><span class="font-semibold text-slate-700">Company:</span> {{ $client->company ?: '—' }}</p>
                <p><span class="font-semibold text-slate-700">Phone:</span> {{ $client->phone ?: '—' }}</p>
                <p><span class="font-semibold text-slate-700">Email:</span> {{ $client->email ?: '—' }}</p>
                <p><span class="font-semibold text-slate-700">Address:</span> {{ $client->address ?: '—' }}</p>
              </div>
            </article>
          @empty
            <p class="rounded-xl bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">No client/person data saved yet.</p>
          @endforelse
        </div>
        <div class="hidden overflow-x-auto md:block">
          <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
              <tr>
                <th class="px-5 py-3 text-left">Name</th>
                <th class="px-5 py-3 text-left">Type</th>
                <th class="px-5 py-3 text-left">Company</th>
                <th class="px-5 py-3 text-left">Phone</th>
                <th class="px-5 py-3 text-left">Email</th>
                <th class="px-5 py-3 text-left">Address</th>
                <th class="px-5 py-3 text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($clients as $client)
                @php
                  $phoneRaw = $client->phone ?? '';
                  $phoneDigits = preg_replace('/\D+/', '', $phoneRaw);
                  $waText = rawurlencode("Hello {$client->name}, this is GAURA Construction.");
                @endphp
                <tr class="border-t border-slate-100">
                  <td class="px-5 py-3 font-semibold">{{ $client->name }}</td>
                  <td class="px-5 py-3 capitalize">{{ $client->entity_type }}</td>
                  <td class="px-5 py-3">{{ $client->company ?: '—' }}</td>
                  <td class="px-5 py-3">{{ $client->phone ?: '—' }}</td>
                  <td class="px-5 py-3">{{ $client->email ?: '—' }}</td>
                  <td class="px-5 py-3">{{ $client->address ?: '—' }}</td>
                  <td class="px-5 py-3">
                    <div class="flex items-center justify-center gap-2">
                      @if($phoneDigits)
                        <a class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-green-100 text-green-700 hover:bg-green-200" href="https://wa.me/{{ $phoneDigits }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer" title="Send WhatsApp message">
                          <span class="material-symbols-outlined text-base">chat</span>
                        </a>
                        <a class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200" href="tel:{{ $phoneRaw }}" title="Call now">
                          <span class="material-symbols-outlined text-base">call</span>
                        </a>
                      @else
                        <span class="text-xs text-slate-400">No phone</span>
                      @endif
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td class="px-5 py-8 text-center text-slate-500" colspan="7">No client/person data saved yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
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
    <a class="flex flex-col items-center gap-1 text-[#003d9b]" href="{{ route('clients') }}">
      <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">groups</span>
      <span class="text-[10px] font-bold">Clients</span>
    </a>
  </nav>
</body>
</html>
