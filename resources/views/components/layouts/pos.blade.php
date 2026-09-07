<!DOCTYPE html>
<html lang="id" class="h-full bg-stone-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS Kasir - Kopi Senja</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans text-stone-800 antialiased flex flex-col overflow-hidden select-none">
    <header class="h-16 bg-stone-900 text-white px-6 flex items-center justify-between shrink-0 border-b border-stone-800 z-20">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-600 flex items-center justify-center font-bold text-white shadow-sm">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                    <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                    <line x1="6" y1="1" x2="6" y2="4"></line>
                    <line x1="10" y1="1" x2="10" y2="4"></line>
                    <line x1="14" y1="1" x2="14" y2="4"></line>
                </svg>
            </div>
            <div>
                <h1 class="font-bold text-base tracking-tight text-white leading-tight">Kopi Senja POS</h1>
                <p class="text-xs text-amber-400 font-mono">Kasir Mode &middot; Shift Pagi</p>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <div class="hidden md:flex flex-col text-right font-mono text-xs text-stone-300">
                <span id="pos-clock-time" class="font-bold text-white text-sm">--:--:--</span>
                <span id="pos-clock-date" class="text-stone-400">---, -- --- ----</span>
            </div>

            <nav class="flex items-center gap-2">
                <a href="{{ route('pos.history') }}" class="px-3.5 py-2 rounded-lg bg-stone-800 hover:bg-stone-700 text-stone-200 text-xs font-semibold inline-flex items-center gap-2 transition">
                    <svg class="w-4 h-4 text-stone-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span>Riwayat Transaksi</span>
                </a>

                <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-lg bg-stone-800 hover:bg-stone-700 text-stone-200 text-xs font-semibold inline-flex items-center gap-2 transition">
                    <svg class="w-4 h-4 text-stone-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Panel Admin</span>
                </a>

                <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg bg-red-950/40 text-red-300 hover:bg-red-900/60 text-xs font-semibold inline-flex items-center gap-1.5 transition">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span>Keluar</span>
                </a>
            </nav>
        </div>
    </header>

    <main class="flex-1 overflow-hidden flex">
        {{ $slot }}
    </main>

    <script>
        function updatePosClock() {
            const now = new Date();
            const timeElem = document.getElementById('pos-clock-time');
            const dateElem = document.getElementById('pos-clock-date');
            if (timeElem && dateElem) {
                timeElem.textContent = now.toLocaleTimeString('id-ID', { hour12: false });
                dateElem.textContent = now.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' });
            }
        }
        setInterval(updatePosClock, 1000);
        updatePosClock();
    </script>
</body>
</html>
