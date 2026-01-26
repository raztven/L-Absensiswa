<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>E-PEGAWAI</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="bg-slate-50 min-h-screen flex flex-col items-center justify-center relative overflow-hidden">
        
        <!-- Background Elements -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <div class="absolute -top-[30%] -left-[10%] w-[70%] h-[70%] bg-indigo-100/40 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute top-[40%] -right-[10%] w-[60%] h-[60%] bg-blue-100/40 rounded-full blur-3xl opacity-50"></div>
        </div>

        <div class="relative z-10 max-w-4xl px-6 text-center">
            
            <div class="inline-flex items-center justify-center bg-white p-6 rounded-3xl shadow-xl shadow-indigo-100/50 mb-8 animate-bounce delay-1000 duration-1000">
                <div class="text-indigo-600">
                    <i data-lucide="fingerprint" class="w-12 h-12"></i>
                </div>
            </div>

            <h1 class="text-4xl md:text-6xl font-bold text-slate-900 tracking-tight mb-6">
                Sistem Informasi <br>
                <span class="text-indigo-600">E-PEGAWAI</span> Digital
            </h1>

            <p class="text-lg text-slate-500 mb-10 max-w-2xl mx-auto leading-relaxed">
                Kelola kehadiran, perizinan, dan data pegawai dengan lebih mudah, efisien, dan terintegrasi dalam satu platform modern.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-xl shadow-indigo-200 transition-all hover:-translate-y-1 active:scale-95 flex items-center gap-2">
                            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-xl shadow-indigo-200 transition-all hover:-translate-y-1 active:scale-95 flex items-center gap-2">
                            <i data-lucide="log-in" class="w-5 h-5"></i>
                            Masuk ke Sistem
                        </a>
                    @endauth
                @endif
            </div>

            <div class="mt-16 pt-8 border-t border-slate-200/60">
                <p class="text-slate-400 text-sm font-medium">
                    &copy; 2026 E-PEGAWAI System. All rights reserved.
                </p>
            </div>
        </div>

        <script>
            lucide.createIcons();
        </script>
    </body>
</html>