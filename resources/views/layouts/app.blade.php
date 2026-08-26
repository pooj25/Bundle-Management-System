<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bundle Management') | Pro ERP Manufacturing</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#2563eb',
                            600: '#1d4ed8',
                            700: '#1e40af',
                            800: '#1e3a8a',
                            900: '#0f172a'
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.25s ease-out forwards',
                        'slide-up': 'slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(8px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        
        .sidebar-nav-item {
            display: flex;
            align-items: center;
            padding: 0.65rem 0.875rem;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #475569;
            border-radius: 0.625rem;
            text-decoration: none;
            transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 0.25rem;
        }
        .sidebar-nav-item:hover {
            background-color: #f1f5f9;
            color: #0f172a;
            transform: translateX(2px);
        }
        .sidebar-nav-item.active {
            background-color: #2563eb !important;
            color: #ffffff !important;
            font-weight: 600;
            box-shadow: 0 4px 12px -2px rgba(37, 99, 235, 0.35);
        }
        .sidebar-nav-item.active svg {
            color: #ffffff !important;
        }

        /* Glassmorphism utility */
        .glass-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="h-full text-slate-800 antialiased flex flex-col bg-[#f8fafc] selection:bg-blue-600 selection:text-white">

    <div class="flex h-screen w-full overflow-hidden bg-[#f8fafc]">

        <!-- Left Sidebar (Clean White with Micro-interactions) -->
        <aside class="w-64 bg-white border-r border-slate-200/80 flex flex-col flex-shrink-0 z-20 select-none shadow-[1px_0_10px_rgba(0,0,0,0.02)]">
            
            <!-- Brand Logo Header -->
            <div class="h-16 px-5 flex items-center justify-between border-b border-slate-100">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-slate-900 no-underline group">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-slate-900 to-slate-800 flex items-center justify-center text-white font-bold text-base shadow-sm group-hover:scale-105 transition duration-200">
                        <i data-lucide="layers" class="w-4 h-4 text-blue-400"></i>
                    </div>
                    <div>
                        <div class="text-sm font-black text-slate-900 tracking-tight leading-none">Pro ERP</div>
                        <div class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mt-1">MANUFACTURING</div>
                    </div>
                </a>
            </div>

            <!-- New Production Order Button -->
            <div class="px-4 py-3.5">
                <a href="{{ route('bundles.create') }}" class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 bg-slate-900 hover:bg-slate-800 active:scale-98 text-white text-xs font-bold rounded-xl shadow-sm hover:shadow-md transition duration-200 no-underline">
                    <i data-lucide="plus" class="w-4 h-4 text-blue-400"></i>
                    <span>New Production Order</span>
                </a>
            </div>

            <!-- ERP Modules Navigation List -->
            <nav class="flex-1 px-3 space-y-0.5 overflow-y-auto pt-1">
                <!-- Sourcing -->
                <a href="{{ route('modules.sourcing') }}" class="sidebar-nav-item {{ request()->routeIs('modules.sourcing') ? 'active' : '' }}">
                    <i data-lucide="package" class="w-4 h-4 mr-3 text-slate-400"></i>
                    <span>Sourcing</span>
                </a>

                <!-- Cutting -->
                <a href="{{ route('modules.cutting') }}" class="sidebar-nav-item {{ request()->routeIs('modules.cutting') ? 'active' : '' }}">
                    <i data-lucide="scissors" class="w-4 h-4 mr-3 text-slate-400"></i>
                    <span>Cutting</span>
                </a>

                <!-- Sewing (Bundle Management) -->
                <a href="{{ route('dashboard') }}" class="sidebar-nav-item {{ (request()->routeIs('dashboard') || request()->routeIs('bundles.*')) ? 'active' : '' }}">
                    <i data-lucide="shirt" class="w-4 h-4 mr-3 {{ (request()->routeIs('dashboard') || request()->routeIs('bundles.*')) ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>Sewing</span>
                </a>

                <!-- QC -->
                <a href="{{ route('modules.qc') }}" class="sidebar-nav-item {{ request()->routeIs('modules.qc') ? 'active' : '' }}">
                    <i data-lucide="check-square" class="w-4 h-4 mr-3 text-slate-400"></i>
                    <span>QC</span>
                </a>

                <!-- Shipping -->
                <a href="{{ route('modules.shipping') }}" class="sidebar-nav-item {{ request()->routeIs('modules.shipping') ? 'active' : '' }}">
                    <i data-lucide="truck" class="w-4 h-4 mr-3 text-slate-400"></i>
                    <span>Shipping</span>
                </a>
            </nav>

            <!-- Bottom Sidebar Menu (Settings & Support) -->
            <div class="p-3 border-t border-slate-100 space-y-0.5 bg-white">
                <a href="{{ route('modules.settings') }}" class="sidebar-nav-item {{ request()->routeIs('modules.settings') ? 'active' : '' }}">
                    <i data-lucide="settings" class="w-4 h-4 mr-3 text-slate-400"></i>
                    <span>Settings</span>
                </a>
                <a href="{{ route('modules.support') }}" class="sidebar-nav-item {{ request()->routeIs('modules.support') ? 'active' : '' }}">
                    <i data-lucide="help-circle" class="w-4 h-4 mr-3 text-slate-400"></i>
                    <span>Support</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#f8fafc]">

            <!-- Top Header Bar -->
            <header class="h-16 bg-white border-b border-slate-200/80 px-6 flex items-center justify-between flex-shrink-0 z-10 shadow-[0_1px_4px_rgba(0,0,0,0.02)]">
                
                <!-- Left Title & Navigation Tabs -->
                <div class="flex items-center space-x-8">
                    <h1 class="text-base font-bold text-slate-900 tracking-tight flex items-center space-x-2">
                        <span>@yield('header_title', 'Bundle Management')</span>
                    </h1>

                    <!-- Header Navigation Tabs with Smooth Line Indicator -->
                    <div class="flex space-x-6 text-xs font-semibold">
                        <a href="{{ route('dashboard') }}" class="py-5 px-1 border-b-2 transition duration-150 {{ request()->routeIs('dashboard') ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-slate-500 hover:text-slate-900 hover:border-slate-300' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('bundles.create') }}" class="py-5 px-1 border-b-2 transition duration-150 {{ request()->routeIs('bundles.create') ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-slate-500 hover:text-slate-900 hover:border-slate-300' }}">
                            Entry Form
                        </a>
                        <a href="{{ route('bundles.index') }}" class="py-5 px-1 border-b-2 transition duration-150 {{ request()->routeIs('bundles.index') ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-slate-500 hover:text-slate-900 hover:border-slate-300' }}">
                            Listing
                        </a>
                        <a href="{{ route('master.index') }}" class="py-5 px-1 border-b-2 transition duration-150 {{ request()->routeIs('master.*') ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-slate-500 hover:text-slate-900 hover:border-slate-300' }}">
                            Master Data
                        </a>
                    </div>
                </div>

                <!-- Right Header Tools -->
                <div class="flex items-center space-x-3">
                    <!-- Search Input with Glow Focus -->
                    <div class="relative w-64 hidden md:block">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                        <input type="text" placeholder="Search bundles, orders..." class="w-full pl-9 pr-4 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white text-slate-700 placeholder-slate-400 transition" onkeyup="if(event.key==='Enter') window.location.href='{{ route('bundles.index') }}?search='+encodeURIComponent(this.value)">
                    </div>

                    <!-- Notification Bell -->
                    <button onclick="showToast('Factory operations normal. 3 shifts active.', 'info')" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition relative group">
                        <i data-lucide="bell" class="w-4 h-4 group-hover:rotate-12 transition transform"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-blue-600 rounded-full ring-2 ring-white"></span>
                    </button>

                    <!-- History Audit Icon -->
                    <button onclick="openActivityHistoryModal()" title="View System Audit Trail" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition">
                        <i data-lucide="history" class="w-4 h-4 hover:rotate-45 transition transform"></i>
                    </button>

                    <!-- User Profile & Dropdown -->
                    <div class="relative flex items-center space-x-3 pl-3 border-l border-slate-200" id="userProfileDropdownContainer">
                        <button onclick="toggleUserDropdown()" class="flex items-center space-x-2.5 focus:outline-none group">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-slate-900 to-blue-600 text-white flex items-center justify-center font-bold text-xs shadow-sm ring-2 ring-white group-hover:scale-105 transition">
                                {{ strtoupper(substr(auth()->user()->name ?? 'PE', 0, 2)) }}
                            </div>
                            <div class="hidden lg:block text-left">
                                <div class="text-xs font-bold text-slate-900 leading-tight">
                                    {{ auth()->user()->name ?? 'John Miller' }}
                                </div>
                                <div class="text-[10px] text-slate-400 font-medium">
                                    {{ auth()->check() ? 'Active Session' : 'Production Manager' }}
                                </div>
                            </div>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-700 transition"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="userDropdownMenu" class="absolute right-0 top-12 w-48 bg-white rounded-xl shadow-xl border border-slate-200/80 py-1.5 hidden z-50 animate-slide-up text-xs font-medium text-slate-700">
                            <div class="px-3.5 py-2 border-b border-slate-100">
                                <div class="font-bold text-slate-900">{{ auth()->user()->name ?? 'John Miller' }}</div>
                                <div class="text-[11px] text-slate-400">{{ auth()->user()->email ?? 'admin@apparel-erp.com' }}</div>
                            </div>
                            <a href="{{ route('modules.settings') }}" class="flex items-center px-3.5 py-2 hover:bg-slate-50 text-slate-700 no-underline">
                                <i data-lucide="settings" class="w-4 h-4 mr-2.5 text-slate-400"></i>
                                <span>Settings</span>
                            </a>
                            <a href="{{ route('login') }}" class="flex items-center px-3.5 py-2 hover:bg-slate-50 text-slate-700 no-underline">
                                <i data-lucide="user" class="w-4 h-4 mr-2.5 text-slate-400"></i>
                                <span>Switch User</span>
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="{{ route('logout') }}" class="flex items-center px-3.5 py-2 hover:bg-rose-50 text-rose-600 no-underline font-semibold">
                                <i data-lucide="log-out" class="w-4 h-4 mr-2.5 text-rose-500"></i>
                                <span>Sign Out</span>
                            </a>
                        </div>
                    </div>
                </div>

            </header>

            <!-- Main Dynamic Page Body with Animation -->
            <main class="flex-1 overflow-y-auto p-6 animate-slide-up">
                @yield('content')
            </main>

        </div>

    </div>

    <!-- Toast Notification Container (Glassmorphism & Slide Animation) -->
    <div id="toastContainer" class="fixed bottom-5 right-5 z-50 flex flex-col space-y-2 pointer-events-none"></div>

    <!-- Global Activity Audit Log Modal -->
    <div id="activityHistoryModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl overflow-hidden border border-slate-200 animate-slide-up">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center space-x-2">
                    <div class="p-1.5 bg-blue-50 text-blue-600 rounded-lg">
                        <i data-lucide="history" class="w-4 h-4"></i>
                    </div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">System Activity Audit Trail</h3>
                </div>
                <button onclick="closeActivityHistoryModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            <div class="p-6 max-h-[55vh] overflow-y-auto space-y-3" id="activityLogsList">
                <div class="text-center py-6 text-slate-400 text-xs flex flex-col items-center">
                    <i data-lucide="loader-2" class="w-5 h-5 animate-spin text-blue-500 mb-2"></i>
                    Loading audit trail...
                </div>
            </div>
            <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button onclick="closeActivityHistoryModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-lg transition">Close</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });

        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            
            const isSuccess = type === 'success';
            const isError = type === 'error';
            const bgColor = isSuccess ? 'bg-emerald-600' : (isError ? 'bg-rose-600' : 'bg-slate-900');
            const iconName = isSuccess ? 'check-circle' : (isError ? 'alert-circle' : 'info');

            toast.className = `${bgColor} text-white px-4 py-3 rounded-xl shadow-xl flex items-center space-x-3 pointer-events-auto transition-all duration-300 transform translate-y-3 opacity-0 text-xs font-medium border border-white/10`;
            toast.innerHTML = `<i data-lucide="${iconName}" class="w-4 h-4 flex-shrink-0"></i><span>${message}</span>`;
            
            container.appendChild(toast);
            if (typeof lucide !== 'undefined') lucide.createIcons();

            setTimeout(() => {
                toast.classList.remove('translate-y-3', 'opacity-0');
            }, 10);

            setTimeout(() => {
                toast.classList.add('translate-y-3', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }

        function openActivityHistoryModal() {
            document.getElementById('activityHistoryModal').classList.remove('hidden');
            document.getElementById('activityHistoryModal').classList.add('flex');
            fetch('/api/dashboard')
                .then(r => r.json())
                .then(res => {
                    const bundles = res.data.recent_bundles || [];
                    const list = document.getElementById('activityLogsList');
                    if (bundles.length === 0) {
                        list.innerHTML = `<div class="text-center py-4 text-slate-400">No activity logged yet.</div>`;
                        return;
                    }
                    list.innerHTML = bundles.map(b => `
                        <div class="p-3 bg-slate-50 border border-slate-200/80 rounded-xl flex items-center justify-between text-xs hover:bg-slate-100 transition">
                            <div>
                                <div class="font-bold text-slate-900">${b.bundle_no} <span class="font-normal text-slate-500">(${b.buyer ? b.buyer.buyer_name : 'N/A'})</span></div>
                                <div class="text-slate-500 text-[11px] mt-0.5">Qty: <strong class="text-slate-700">${b.quantity}</strong> | Done: <strong class="text-emerald-600">${b.completed_qty}</strong> | Rej: <strong class="text-rose-600">${b.rejected_qty}</strong></div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold ${b.status_label === 'PASSED' ? 'bg-emerald-100 text-emerald-800' : (b.status_label === 'REJECTED' ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800')}">${b.status_label}</span>
                        </div>
                    `).join('');
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                });
        }

        function closeActivityHistoryModal() {
            document.getElementById('activityHistoryModal').classList.add('hidden');
            document.getElementById('activityHistoryModal').classList.remove('flex');
        }
    </script>
    @yield('scripts')
</body>
</html>