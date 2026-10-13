<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pro Livewire 3 Real-Time E-Commerce Filter</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS with CDN Dark Mode plugin enabled -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50: '#EEF2FF',
                            100: '#E0E7FF',
                            500: '#6366F1',
                            600: '#4F46E5',
                            700: '#4338CA',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

    <!-- noUiSlider for Dual Price Range -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.css">
    <script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        [x-cloak] { display: none !important; }
        .noUi-connect { background: #4F46E5 !important; }
        .noUi-handle { border-radius: 50% !important; box-shadow: 0 2px 6px rgba(0,0,0,0.2) !important; cursor: pointer !important; }
        .dark .noUi-target { background: #1F2937 !important; border-color: #374151 !important; }
    </style>

    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-800 dark:bg-slate-950 dark:text-slate-100 min-h-screen flex flex-col font-sans transition-colors duration-200">

    <!-- Modern Header & Navbar -->
    <header class="sticky top-0 z-40 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="container mx-auto px-4 lg:px-8 py-3.5 flex justify-between items-center">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-3 group">
                <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-cyan-500 text-white flex items-center justify-center text-lg font-black shadow-md shadow-brand-500/20 group-hover:scale-105 transition">
                    <i class="fas fa-filter"></i>
                </span>
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900 dark:text-white flex items-center gap-1.5">
                        FilterHub <span class="text-xs px-2 py-0.5 rounded-full font-bold bg-brand-100 text-brand-700 dark:bg-brand-900/50 dark:text-brand-300">Livewire 3</span>
                    </span>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Instant Multi-Filter E-Commerce Engine</p>
                </div>
            </a>

            <!-- Right Controls: Links & Theme Switcher -->
            <div class="flex items-center gap-3">
                <a href="/" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-brand-600 dark:hover:text-brand-400 transition hidden sm:inline-block">
                    Home
                </a>
                <a href="/products" class="text-sm font-semibold text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-950/60 px-3.5 py-1.5 rounded-lg border border-brand-200 dark:border-brand-800">
                    Live Catalog
                </a>

                <!-- Dark / Light Mode Switcher -->
                <button type="button" id="themeToggleBtn" 
                        class="w-10 h-10 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 flex items-center justify-center hover:bg-slate-200 dark:hover:bg-slate-700 transition"
                        title="Toggle Dark / Light Mode">
                    <i class="fas fa-moon text-slate-600 dark:hidden"></i>
                    <i class="fas fa-sun text-amber-400 hidden dark:inline"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 py-8 mt-12 transition-colors">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Laravel 12 + Livewire 3 Multi-Selection E-Commerce Engine
            </p>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">
                Real-Time Filtering · Dual Range Slider · Category Tree · Star Ratings · Swatches · Quick View
            </p>
        </div>
    </footer>

    <!-- Theme Mode JavaScript -->
    <script>
        (function() {
            const html = document.documentElement;
            const themeBtn = document.getElementById('themeToggleBtn');

            const stored = localStorage.getItem('filterhub_theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const current = stored ? stored : (prefersDark ? 'dark' : 'light');

            if (current === 'dark') {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }

            if (themeBtn) {
                themeBtn.addEventListener('click', function() {
                    const isDark = html.classList.toggle('dark');
                    localStorage.setItem('filterhub_theme', isDark ? 'dark' : 'light');
                });
            }
        })();
    </script>

    @livewireScripts
</body>
</html>