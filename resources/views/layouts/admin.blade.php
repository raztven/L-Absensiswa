<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-center gap-3">
                <div class="bg-blue-600 p-2 rounded-lg text-white">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <span class="text-xl font-bold text-slate-800">Admin Panel</span>
            </div>
            
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} transition-colors">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.siswa.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} transition-colors">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    Data Siswa
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} transition-colors">
                    <i data-lucide="file-bar-chart" class="w-5 h-5"></i>
                    Laporan
                </a>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 w-full rounded-xl text-rose-500 hover:bg-rose-50 transition-colors font-medium">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Header Mobile -->
            <header class="bg-white border-b border-slate-200 p-4 flex md:hidden justify-between items-center">
                <div class="font-bold text-slate-800">Admin Panel</div>
                <button class="text-slate-600">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-6 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
