<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Pro ERP Apparel Manufacturing</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-slate-800">

    <div class="w-full max-w-md space-y-6">

        <!-- Brand Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-blue-600 text-white shadow-xl shadow-blue-500/20 mb-2">
                <i data-lucide="layers" class="w-6 h-6"></i>
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight">Pro ERP Manufacturing</h1>
            <p class="text-xs text-slate-400 font-medium">Create your official user account</p>
        </div>

        <!-- Register Form Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 border border-slate-200/80 space-y-6">
            
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-base font-bold text-slate-900">Create New Account</h2>
                <p class="text-xs text-slate-400">Enter your name and details to register</p>
            </div>

            <!-- Error Banner -->
            @if($errors->any())
                <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700 font-semibold flex items-center space-x-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 text-rose-500"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Registration Form -->
            <form action="{{ route('register.post') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">Full Name *</label>
                    <div class="relative">
                        <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 transform -translate-y-1/2"></i>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="e.g. Pooja / John Doe" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">Email Address *</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 transform -translate-y-1/2"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="your.name@company.com" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">Password *</label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 transform -translate-y-1/2"></i>
                        <input type="password" name="password" required placeholder="Minimum 6 characters" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">Confirm Password *</label>
                    <div class="relative">
                        <i data-lucide="check" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 transform -translate-y-1/2"></i>
                        <input type="password" name="password_confirmation" required placeholder="Re-type password" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 active:scale-98 text-white font-bold rounded-xl shadow-md shadow-blue-500/20 transition duration-150 flex items-center justify-center space-x-2 text-xs">
                    <span>Register & Access Dashboard</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>

            <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 ml-1 no-underline">
                    Sign In &rarr;
                </a>
            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>
</body>
</html>