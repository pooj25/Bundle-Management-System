<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Pro ERP Apparel Manufacturing</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-950 text-slate-800">

    <div class="w-full max-w-md space-y-6">

        <!-- Brand Header Card -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-500/30 mb-2">
                <i data-lucide="layers" class="w-6 h-6"></i>
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight">Pro ERP Manufacturing</h1>
            <p class="text-xs text-slate-400 font-medium">Production Bundle Management & Quality Control Node</p>
        </div>

        <!-- Login Form Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 border border-slate-200/80 space-y-6">
            
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-base font-bold text-slate-900">Sign in to your account</h2>
                <p class="text-xs text-slate-400">Enter your credentials or use quick demo login below</p>
            </div>

            <!-- Error Notification Banner -->
            @if($errors->any())
                <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700 font-medium flex items-center space-x-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 text-rose-500"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Standard Login Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 transform -translate-y-1/2"></i>
                        <input type="email" name="email" value="{{ old('email', 'admin@apparel-erp.com') }}" required placeholder="operator@apparel-erp.com" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block font-bold text-slate-700 uppercase">Password</label>
                        <span class="text-[11px] text-slate-400">Default: <strong>password</strong></span>
                    </div>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 transform -translate-y-1/2"></i>
                        <input type="password" name="password" value="password" required placeholder="••••••••" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center space-x-2 cursor-pointer text-slate-600">
                        <input type="checkbox" name="remember" checked class="w-3.5 h-3.5 text-blue-600 rounded">
                        <span>Remember session</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md shadow-blue-500/20 transition active:scale-98 flex items-center justify-center space-x-2 text-xs">
                    <span>Sign In to ERP</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>

            <!-- 1-Click Quick Demo Login Suite -->
            <div class="pt-4 border-t border-slate-100 space-y-2.5">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">
                    ⚡ 1-Click Quick Demo Access
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <a href="{{ route('login.quick', 'admin') }}" class="p-2.5 bg-slate-50 hover:bg-blue-50 hover:border-blue-200 border border-slate-200 rounded-xl text-center text-slate-700 hover:text-blue-700 transition group no-underline flex flex-col items-center">
                        <i data-lucide="shield-check" class="w-4 h-4 text-blue-600 mb-1 group-hover:scale-110 transition"></i>
                        <span class="font-bold text-[11px]">Manager</span>
                        <span class="text-[9px] text-slate-400">Admin</span>
                    </a>

                    <a href="{{ route('login.quick', 'supervisor') }}" class="p-2.5 bg-slate-50 hover:bg-emerald-50 hover:border-emerald-200 border border-slate-200 rounded-xl text-center text-slate-700 hover:text-emerald-700 transition group no-underline flex flex-col items-center">
                        <i data-lucide="user-check" class="w-4 h-4 text-emerald-600 mb-1 group-hover:scale-110 transition"></i>
                        <span class="font-bold text-[11px]">Supervisor</span>
                        <span class="text-[9px] text-slate-400">Shift Line</span>
                    </a>

                    <a href="{{ route('login.quick', 'qc') }}" class="p-2.5 bg-slate-50 hover:bg-amber-50 hover:border-amber-200 border border-slate-200 rounded-xl text-center text-slate-700 hover:text-amber-700 transition group no-underline flex flex-col items-center">
                        <i data-lucide="search" class="w-4 h-4 text-amber-600 mb-1 group-hover:scale-110 transition"></i>
                        <span class="font-bold text-[11px]">QC Auditor</span>
                        <span class="text-[9px] text-slate-400">Inspector</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Footer Info -->
        <div class="text-center text-slate-500 text-[11px]">
            Pro ERP Apparel Manufacturing &bull; Version 2.4 Enterprise
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>
</body>
</html>