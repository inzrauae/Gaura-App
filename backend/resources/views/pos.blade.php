<!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>GAURA - Add Expense</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "on-secondary-fixed": "#251a00",
            "surface-variant": "#dae2fd",
            "on-tertiary-container": "#c8d3eb",
            "on-error": "#ffffff",
            "surface": "#faf8ff",
            "on-primary-container": "#c4d2ff",
            "surface-bright": "#faf8ff",
            "inverse-surface": "#283044",
            "secondary-container": "#fdc425",
            "secondary": "#785a00",
            "primary-container": "#0052cc",
            "on-tertiary-fixed": "#111c2d",
            "primary-fixed": "#dae2ff",
            "surface-container-highest": "#dae2fd",
            "on-primary-fixed-variant": "#0040a2",
            "tertiary": "#394457",
            "inverse-primary": "#b2c5ff",
            "on-secondary-fixed-variant": "#5a4300",
            "secondary-fixed": "#ffdf9a",
            "on-tertiary-fixed-variant": "#3c475a",
            "tertiary-fixed-dim": "#bcc7de",
            "outline-variant": "#c3c6d6",
            "on-primary": "#ffffff",
            "on-error-container": "#93000a",
            "secondary-fixed-dim": "#f7be1d",
            "surface-container": "#eaedff",
            "surface-container-lowest": "#ffffff",
            "tertiary-fixed": "#d8e3fb",
            "on-tertiary": "#ffffff",
            "tertiary-container": "#505b6f",
            "error-container": "#ffdad6",
            "on-secondary-container": "#6d5200",
            "outline": "#737685",
            "on-surface-variant": "#434654",
            "surface-container-low": "#f2f3ff",
            "surface-container-high": "#e2e7ff",
            "surface-dim": "#d2d9f4",
            "on-background": "#131b2e",
            "primary": "#003d9b",
            "inverse-on-surface": "#eef0ff",
            "on-secondary": "#ffffff",
            "on-surface": "#131b2e",
            "primary-fixed-dim": "#b2c5ff",
            "surface-tint": "#0c56d0",
            "error": "#ba1a1a",
            "background": "#faf8ff",
            "on-primary-fixed": "#001848"
          },
          fontFamily: {
            "headline": ["Manrope"],
            "body": ["Inter"],
            "label": ["Inter"]
          },
          borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"},
        },
      },
    }
  </script>
<style>
    body { font-family: 'Inter', sans-serif; background-color: #faf8ff; color: #131b2e; }
    h1, h2, h3 { font-family: 'Manrope', sans-serif; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    body.dark { background: #0b1220; color: #e5e7eb; }
    body.dark aside, body.dark header { background: #111827 !important; color: #e5e7eb; }
    body.dark .bg-white, body.dark .bg-surface-container-lowest { background: #1f2937 !important; }
    body.dark .bg-surface-container, body.dark .bg-surface-container-low, body.dark .bg-surface-dim { background: #111827 !important; }
    body.dark .border-surface-container-high, body.dark .border-outline-variant { border-color: #374151 !important; }
    body.dark .text-on-surface-variant { color: #9ca3af !important; }
    body.dark .text-[#434654] { color: #d1d5db !important; }
    body.dark .bg-[#f2f3ff] { background: #1f2937 !important; }
    .theme-toggle { border: 1px solid #d1d5db; }
    body.dark .theme-toggle { border-color: #374151; color: #e5e7eb; background: #111827; }
  </style>
</head>
<body class="bg-surface text-on-surface font-body">
<!-- SideNavBar -->
<meta name="theme-color" content="#003d9b"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="default"/>
<aside class="fixed left-0 top-0 flex flex-col h-full z-40 bg-[#faf8ff] dark:bg-slate-950 h-screen w-64 border-r-0 shadow-[8px_0_24px_rgba(19,27,46,0.06)] hidden md:flex">
<div class="px-6 py-8">
<div class="text-lg font-bold text-[#003d9b] font-headline mb-8">GAURA</div>
<div class="mb-8 p-4 bg-[#f2f3ff] dark:bg-slate-900 rounded-xl">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center text-on-primary">
<span class="material-symbols-outlined" data-icon="architecture">architecture</span>
</div>
<div>
<div class="text-sm font-bold font-headline leading-tight">{{ $sidebarProjectName }}</div>
<div class="text-xs text-on-surface-variant">{{ $sidebarProjectSubtitle }}</div>
</div>
</div>
<form action="{{ route('expenses.create') }}" method="GET" class="mt-3">
<select name="active_project" onchange="this.form.submit()" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 focus:border-[#003d9b] focus:ring-[#003d9b]">
<option value="">All Projects</option>
@foreach($availableProjects as $projectName)
<option value="{{ $projectName }}" {{ $selectedProjectName === $projectName ? 'selected' : '' }}>{{ $projectName }}</option>
@endforeach
</select>
</form>
</div>
<nav class="space-y-1">
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#434654] dark:text-slate-400 hover:bg-[#f2f3ff] dark:hover:bg-slate-800 transition-colors" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="text-sm font-medium">Dashboard</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg bg-[#e2e7ff] dark:bg-blue-900/30 text-[#003d9b] dark:text-blue-200 border-r-4 border-[#003d9b] translate-x-1 transition-transform" href="{{ route('expenses.create') }}">
<span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
<span class="text-sm font-medium">Expenses</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#434654] dark:text-slate-400 hover:bg-[#f2f3ff] dark:hover:bg-slate-800 transition-colors" href="{{ route('analytics') }}">
<span class="material-symbols-outlined" data-icon="bar_chart">bar_chart</span>
<span class="text-sm font-medium">Analytics</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#434654] dark:text-slate-400 hover:bg-[#f2f3ff] dark:hover:bg-slate-800 transition-colors" href="{{ route('projects') }}">
<span class="material-symbols-outlined" data-icon="architecture">architecture</span>
<span class="text-sm font-medium">Projects</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#434654] dark:text-slate-400 hover:bg-[#f2f3ff] dark:hover:bg-slate-800 transition-colors" href="{{ route('settings') }}">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
<span class="text-sm font-medium">Settings</span>
</a>
</nav>
</div>
<div class="mt-auto px-6 py-6">
<a class="w-full bg-gradient-to-br from-primary to-primary-container text-on-primary py-3 px-4 rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg active:scale-95 duration-150" href="{{ route('expenses.create') }}">
<span class="material-symbols-outlined" data-icon="add">add</span>
        New Expense
  </a>
</div>
</aside>
<!-- Main Content Wrapper -->
<div class="md:ml-64 flex flex-col min-h-screen">
<!-- TopNavBar -->
<header class="sticky top-0 z-30 flex w-full items-center justify-between bg-[#faf8ff] px-6 py-3">
<div class="flex items-center gap-8">
<div class="md:hidden text-xl font-black text-[#003d9b] font-headline">CS</div>
<nav class="hidden md:flex items-center gap-6">
<a class="text-[#434654] dark:text-slate-400 hover:bg-[#e2e7ff] dark:hover:bg-slate-700 transition-colors px-2 py-1 rounded" href="{{ route('projects') }}">Projects</a>
<a class="text-[#003d9b] dark:text-blue-400 font-bold border-b-2 border-[#003d9b] pb-1" href="{{ route('expenses.create') }}">Expenses</a>
<a class="text-[#434654] dark:text-slate-400 hover:bg-[#e2e7ff] dark:hover:bg-slate-700 transition-colors px-2 py-1 rounded" href="{{ route('analytics') }}">Reports</a>
</nav>
</div>
<div class="flex items-center gap-4">
<button id="theme-toggle" class="theme-toggle rounded-lg px-3 py-2 text-sm font-semibold" type="button">Dark</button>
<div class="relative hidden sm:block">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm" data-icon="search">search</span>
<input class="pl-10 pr-4 py-2 bg-[#f2f3ff] dark:bg-slate-800/50 border-none rounded-full text-sm focus:ring-2 focus:ring-primary w-64" placeholder="Search records..." type="text"/>
</div>
<button class="w-10 h-10 flex items-center justify-center text-[#434654] hover:bg-[#e2e7ff] rounded-full transition-colors">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<a class="w-10 h-10 flex items-center justify-center text-[#434654] hover:bg-[#e2e7ff] rounded-full transition-colors" href="{{ route('settings') }}">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
</a>
<div class="w-10 h-10 rounded-full bg-surface-container overflow-hidden border-2 border-white shadow-sm">
<img alt="User profile avatar" class="w-full h-full object-cover" data-alt="portrait of a male construction engineer in a professional environment with warm lighting and soft background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCzA__68tNZLgNy3c9OW141FuFVRyv1mPkS7y2uvTBeJb2_YwH848y2BF8GW33gYpVDFqFYi8mlzvariIm395IkUPRZmm-OUySDk-2NUvcDEs4vXWHKemMnSmizN5lNPq64Kwc5thyCoUMpZxbLidbfZnqvJhFqkd28VNQeHJhnNMVZvGn6uKg8Q8ilzudGwCzWHbgDVpB-cbW6nrUSG6LG-hAzO4Bl9sS3CZIfUXuh9-x6JlpUUkwZxHL9hzvif149HnKLfeJptDwH"/>
</div>
</div>
</header>
<!-- Content Canvas -->
<main class="mx-auto w-full max-w-6xl flex-1 p-6 pb-24 md:p-10 md:pb-10">
<!-- Page Header -->
<div class="mb-10">
<h1 class="text-3xl font-extrabold text-on-background tracking-tight mb-2">Add New Expense</h1>
<p class="text-on-surface-variant">Log a new project expenditure with precise tracking.</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
<!-- Main Form Panel -->
<div class="lg:col-span-8 bg-surface-container-lowest rounded-xl p-8 shadow-sm">
<form class="space-y-8" id="expense-form">
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<!-- Date Field -->
<div class="space-y-2">
<label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant flex items-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="calendar_today">calendar_today</span>
                  Date
                </label>
<input class="w-full bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 px-4 py-3 rounded-lg text-sm transition-all" id="expense-date" type="date" required/>
</div>
<!-- Category Field -->
<div class="space-y-2">
<label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant flex items-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="category">category</span>
                  Category
                </label>
<select class="w-full bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 px-4 py-3 rounded-lg text-sm transition-all appearance-none" id="expense-category">
<option>Labor</option>
<option>Materials</option>
<option>Transport</option>
<option>Equipment</option>
<option>Other</option>
</select>
</div>
</div>
<!-- Project Field -->
<div class="space-y-2">
<label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant flex items-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="architecture">architecture</span>
                Project
              </label>
<select class="w-full bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 px-4 py-3 rounded-lg text-sm transition-all appearance-none" id="project-name">
<option value="">— No Project —</option>
@foreach($availableProjects as $proj)
<option value="{{ $proj }}" {{ $selectedProjectName === $proj ? 'selected' : '' }}>{{ $proj }}</option>
@endforeach
</select>
</div>
<!-- Title Field -->
<div class="space-y-2">
<label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant flex items-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="description">description</span>
                Expense Title
              </label>
<input class="w-full bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 px-4 py-3 rounded-lg text-sm transition-all" id="expense-title" placeholder="e.g., Bulk Timber Delivery - Site 102" type="text"/>
</div>
<!-- Amount Field -->
<div class="space-y-2">
<label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant flex items-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="payments">payments</span>
                Amount
              </label>
<div class="relative">
<span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-primary text-sm">LKR</span>
<input class="w-full bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 pl-14 pr-4 py-3 rounded-lg font-bold text-lg transition-all" id="expense-amount" placeholder="0.00" step="0.01" type="number"/>
</div>
</div>
<!-- Payment Type Toggle (The Segmented Control) -->
<div class="space-y-3">
<label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Payment Type</label>
<div class="grid grid-cols-2 gap-2 p-1 bg-surface-container-low rounded-xl">
<button class="flex items-center justify-center gap-2 py-3 px-4 rounded-lg bg-white shadow-sm text-primary font-bold transition-all border border-primary/10" id="payment-company" type="button">
<span class="material-symbols-outlined text-sm" data-icon="account_balance" data-weight="fill" style="font-variation-settings: 'FILL' 1;">account_balance</span>
                  Company Paid
                </button>
<button class="flex flex-col items-center justify-center py-3 px-4 rounded-lg text-on-surface-variant hover:bg-surface-container transition-all" id="payment-director" type="button">
<div class="flex items-center gap-2 font-medium">
<span class="material-symbols-outlined text-sm" data-icon="person">person</span>
                    Director Paid
                  </div>
</button>
</div>
<input id="payment-type" type="hidden" value="company_paid"/>
<!-- Conditional Note (Mocked as visible for context) -->
<div class="hidden items-center gap-2 px-4 py-2 bg-secondary-container/20 rounded-lg text-secondary text-xs font-bold italic" id="reimbursement-note">
<span class="material-symbols-outlined text-xs" data-icon="info">info</span>
                Marked for reimbursement
              </div>

<div class="hidden space-y-2" id="director-field">
<label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant flex items-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="person">person</span>
                  Director Name
                </label>
<select class="w-full bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 px-4 py-3 rounded-lg text-sm transition-all appearance-none" id="director-name">
<option value="">Select Director</option>
<option value="Buddhika">Buddhika</option>
<option value="Nilitha">Nilitha</option>
<option value="Vihaga">Vihaga</option>
</select>

<label class="pt-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant flex items-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="wallet">wallet</span>
                  Paid From
                </label>
<select class="w-full bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 px-4 py-3 rounded-lg text-sm transition-all appearance-none" id="director-fund-source">
<option value="">Select Source</option>
<option value="cash_in_hand">Cash in Hand</option>
<option value="bank_balance">Bank Balance</option>
</select>
</div>
</div>
<!-- Notes Field -->
<div class="space-y-2">
<label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant flex items-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="notes">notes</span>
                Notes
              </label>
<textarea class="w-full bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 px-4 py-3 rounded-lg text-sm transition-all resize-none" id="expense-notes" placeholder="Add specific details about the expense location or justification..." rows="4"></textarea>
</div>
</form>
</div>
<!-- Receipt Panel (The Asymmetric Bento Style) -->
<div class="lg:col-span-4 space-y-6">
<div class="bg-surface-container rounded-xl p-6 border-2 border-dashed border-outline-variant group hover:border-primary transition-colors cursor-pointer text-center" id="receipt-dropzone">
<div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-primary text-3xl" data-icon="upload_file">upload_file</span>
</div>
<h3 class="font-bold text-lg mb-1">Upload Receipt</h3>
<p class="text-xs text-on-surface-variant mb-4">PNG, JPG or PDF up to 10MB</p>
<div class="text-xs font-bold text-primary py-2 px-4 bg-primary/10 rounded-full inline-block">Browse Files</div>
<input accept=".png,.jpg,.jpeg,.pdf" class="hidden" id="receipt-file" type="file"/>
<p class="mt-3 text-xs text-on-surface-variant" id="receipt-file-name">No file selected</p>
</div>
<!-- Helpful Context Card -->
<div class="bg-surface-dim p-6 rounded-xl relative overflow-hidden">
<div class="relative z-10">
<h4 class="font-bold text-sm mb-2 flex items-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="lightbulb">lightbulb</span>
                Pro Tip
              </h4>
<p class="text-xs text-on-surface-variant leading-relaxed">
                Categorizing expenses by <strong>Equipment</strong> helps you track maintenance-related costs for {{ $sidebarProjectName }}.
              </p>
</div>
<span class="material-symbols-outlined absolute -bottom-4 -right-4 text-8xl text-surface-container opacity-20 rotate-12" data-icon="receipt">receipt</span>
</div>
</div>
</div>
<!-- Action Buttons (Fixed or Docked Style) -->
<div class="mt-12 flex items-center justify-end gap-4 border-t border-surface-container-high pt-8">
<button class="px-8 py-3 text-sm font-bold text-on-surface-variant hover:bg-surface-container-high transition-all rounded-lg" form="expense-form" type="reset">
          Cancel
        </button>
<button class="bg-gradient-to-br from-primary to-primary-container text-white px-10 py-3 rounded-lg font-extrabold text-sm shadow-xl hover:shadow-primary/20 active:scale-95 transition-all" form="expense-form" id="save-expense-btn" type="submit">
          Save Expense
        </button>
</div>
<p class="mt-4 text-sm font-semibold" id="form-status"></p>
</main>
</div>
<!-- Mobile Navigation Shell -->
<nav class="md:hidden fixed bottom-0 left-0 w-full bg-white flex justify-around py-3 px-2 border-t border-surface-container z-50">
<a class="flex flex-col items-center gap-1 text-on-surface-variant" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="text-[10px] font-medium">Home</span>
</a>
<a class="flex flex-col items-center gap-1 text-[#003d9b]" href="{{ route('expenses.create') }}">
<span class="material-symbols-outlined" data-icon="receipt_long" data-weight="fill" style="font-variation-settings: 'FILL' 1;">receipt_long</span>
<span class="text-[10px] font-bold">Expenses</span>
</a>
<div class="relative -top-6">
<a class="w-14 h-14 bg-primary text-white rounded-full flex items-center justify-center shadow-lg" href="{{ route('expenses.create') }}">
<span class="material-symbols-outlined text-3xl" data-icon="add">add</span>
</a>
</div>
<a class="flex flex-col items-center gap-1 text-on-surface-variant" href="{{ route('analytics') }}">
<span class="material-symbols-outlined" data-icon="bar_chart">bar_chart</span>
<span class="text-[10px] font-medium">Reports</span>
</a>
<a class="flex flex-col items-center gap-1 text-on-surface-variant" href="{{ route('settings') }}">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
<span class="text-[10px] font-medium">Settings</span>
</a>
</nav>
<script>
  const apiBaseUrl = `${window.location.origin}/api`;

  const expenseForm = document.getElementById("expense-form");
  const companyBtn = document.getElementById("payment-company");
  const directorBtn = document.getElementById("payment-director");
  const paymentTypeInput = document.getElementById("payment-type");
  const reimbursementNote = document.getElementById("reimbursement-note");
  const directorField = document.getElementById("director-field");
  const directorNameInput = document.getElementById("director-name");
  const directorFundSourceInput = document.getElementById("director-fund-source");
  const receiptDropzone = document.getElementById("receipt-dropzone");
  const receiptInput = document.getElementById("receipt-file");
  const receiptFileName = document.getElementById("receipt-file-name");
  const saveBtn = document.getElementById("save-expense-btn");
  const statusText = document.getElementById("form-status");

  function setPaymentType(type) {
    const isCompany = type === "company_paid";
    paymentTypeInput.value = type;
    reimbursementNote.classList.toggle("hidden", isCompany);
    reimbursementNote.classList.toggle("flex", !isCompany);
    directorField.classList.toggle("hidden", isCompany);

    if (isCompany) {
      directorNameInput.value = "";
      directorNameInput.removeAttribute("required");
      directorFundSourceInput.value = "";
      directorFundSourceInput.removeAttribute("required");
    } else {
      directorNameInput.setAttribute("required", "required");
      directorFundSourceInput.setAttribute("required", "required");
    }

    companyBtn.className = isCompany
      ? "flex items-center justify-center gap-2 py-3 px-4 rounded-lg bg-white shadow-sm text-primary font-bold transition-all border border-primary/10"
      : "flex items-center justify-center gap-2 py-3 px-4 rounded-lg text-on-surface-variant hover:bg-surface-container transition-all";

    directorBtn.className = !isCompany
      ? "flex flex-col items-center justify-center py-3 px-4 rounded-lg bg-white shadow-sm text-primary font-bold transition-all border border-primary/10"
      : "flex flex-col items-center justify-center py-3 px-4 rounded-lg text-on-surface-variant hover:bg-surface-container transition-all";
  }

  companyBtn.addEventListener("click", () => setPaymentType("company_paid"));
  directorBtn.addEventListener("click", () => setPaymentType("director_paid"));

  receiptDropzone.addEventListener("click", () => receiptInput.click());
  receiptInput.addEventListener("change", () => {
    receiptFileName.textContent = receiptInput.files.length
      ? receiptInput.files[0].name
      : "No file selected";
  });

  expenseForm.addEventListener("submit", async (event) => {
    event.preventDefault();
    statusText.textContent = "Saving expense...";
    statusText.className = "mt-4 text-sm font-semibold text-primary";
    saveBtn.disabled = true;

    const expenseDate = document.getElementById("expense-date").value;
    const category = document.getElementById("expense-category").value;
    const title = document.getElementById("expense-title").value;
    const amount = document.getElementById("expense-amount").value;
    const notes = document.getElementById("expense-notes").value;
    const directorName = directorNameInput.value;
    const directorFundSource = directorFundSourceInput.value;

    if (!expenseDate || !category || !title || !amount) {
      statusText.textContent = "Please fill in all required fields (Date, Category, Title, Amount)";
      statusText.className = "mt-4 text-sm font-semibold text-red-700";
      saveBtn.disabled = false;
      return;
    }

    if (paymentTypeInput.value === "director_paid" && !directorName) {
      statusText.textContent = "Please select Director Name for director-paid expenses.";
      statusText.className = "mt-4 text-sm font-semibold text-red-700";
      saveBtn.disabled = false;
      return;
    }

    if (paymentTypeInput.value === "director_paid" && !directorFundSource) {
      statusText.textContent = "Please select paid source for director-paid expenses.";
      statusText.className = "mt-4 text-sm font-semibold text-red-700";
      saveBtn.disabled = false;
      return;
    }

    const payload = new FormData();
    payload.append("project_name", document.getElementById("project-name").value);
    payload.append("expense_date", expenseDate);
    payload.append("category", category);
    payload.append("title", title);
    payload.append("amount", amount);
    payload.append("payment_type", paymentTypeInput.value);
    payload.append("director_name", directorName);
    payload.append("director_fund_source", directorFundSource);
    payload.append("notes", notes);

    if (receiptInput.files.length > 0) {
      payload.append("receipt", receiptInput.files[0]);
    }

    try {
      console.log("Submitting to:", `${apiBaseUrl}/expenses`);
      const response = await fetch(`${apiBaseUrl}/expenses`, {
        method: "POST",
        headers: {
          "Accept": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
        body: payload,
      });

      const contentType = response.headers.get("content-type") || "";
      const result = contentType.includes("application/json")
        ? await response.json()
        : { message: await response.text() };
      console.log("Response:", result, "Status:", response.status);

      if (!response.ok) {
        const errorMsg = result.message || result.errors || `Request failed (${response.status}).`;
        throw new Error(typeof errorMsg === 'string' ? errorMsg : JSON.stringify(errorMsg));
      }

      expenseForm.reset();
      document.getElementById("expense-date").value = new Date().toISOString().split('T')[0];
      receiptInput.value = "";
      receiptFileName.textContent = "No file selected";
      setPaymentType("company_paid");
      statusText.textContent = "✓ Expense saved successfully!";
      statusText.className = "mt-4 text-sm font-semibold text-green-600";
    } catch (error) {
      console.error("Error:", error);
      statusText.textContent = "Error: " + error.message;
      statusText.className = "mt-4 text-sm font-semibold text-red-700";
    } finally {
      saveBtn.disabled = false;
    }
  });

  // Set today's date as default
  document.getElementById("expense-date").value = new Date().toISOString().split('T')[0];

  setPaymentType("company_paid");

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
</body></html>