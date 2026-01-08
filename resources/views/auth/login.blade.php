<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center bg-blue-600 p-3 rounded-2xl text-white shadow-lg shadow-blue-100 mb-4">
                <i data-lucide="calendar-check" class="w-8 h-8"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">E-Absensi Digital</h1>
            <p class="text-slate-500 text-sm mt-2">Silakan masuk untuk mengelola absensi Anda</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/60 border border-slate-100">
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-400 uppercase mb-2 ml-1">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <input type="email" name="email" id="email" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 pl-12 pr-4 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all placeholder:text-slate-300"
                            placeholder="nama@sekolah.com" value="{{ old('email') }}">
                    </div>
                    @error('email')
                    <p class="text-rose-500 text-xs mt-2 ml-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label for="password" class="block text-xs font-bold text-slate-400 uppercase">Kata Sandi</label>
                        <a href="#" class="text-xs font-bold text-blue-600 hover:underline">Lupa Sandi?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 pl-12 pr-4 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all placeholder:text-slate-300"
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center ml-1">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500">
                    <label for="remember" class="ml-2 text-sm font-medium text-slate-500">Ingat saya di perangkat ini</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-5 rounded-2xl shadow-xl shadow-blue-100 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                    Masuk Sekarang
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </button>
            </form>
        </div>

        <!-- Footer Info -->
        <p class="text-center text-slate-400 text-xs mt-8">
            &copy; 2026 E-Absensi Digital. Hak Cipta Dilindungi.
        </p>
    </div>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
</body>

</html>