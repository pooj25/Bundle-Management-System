<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bundle Management') | Pro ERP Manufacturing</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .tab-active {
            color: #1d4ed8;
            border-bottom: 2px solid #1d4ed8;
            font-weight: 600;
        }
    </style>
</head>
<body class="h-full text-slate-800 antialiased flex flex-col">

    <div class="flex h-full w-full overflow-hidden bg-slate-100">

        <!-- Sidebar (Left) -->
        <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col flex-shrink-0 border-r border-slate-800 transition-all duration-200">
            <!-- Brand header -->
            <div class="h-16 px-5 flex items-center justify-between border-b border-slate-800">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                        <i data-lucide="layers" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-white tracking-wide">Pro ERP</div>
                        <div class="text-[10px] uppercase tracking-wider text-slate-400">Manufacturing</div>
                    </div>
                </div>
            </div>

            <!-- New Order Action Button -->
            <div class="px-4 py-4">
                <a href="{{ route('bundles.create') }}" class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 bg-black hover:bg-slate-800 text-white text-xs font-semibold rounded-lg border border-slate-700 shadow-sm transition">
                    <i data-lucide="plus" class="w-4 h-4 text-blue-400"></i>
                    <span>New Production Order</span>
                </a>
            </div>

            <!-- ERP Workflow Modules Navigation -->
            <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
                <div class="px-3 pt-2 pb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Modules</div>

                <a href="#" class="flex items-center px-3 py-2 text-xs font-medium rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition group">
                    <i data-lucide="package" class="w-4 h-4 mr-3 text-slate-400 group-hover:text-white"></i>
                    <span>Sourcing</span>
                </a>

                <a href="#" class="flex items-center px-3 py-2 text-xs font-medium rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition group">
                    <i data-lucide="scissors" class="w-4 h-4 mr-3 text-slate-400 group-hover:text-white"></i>
                    <span>Cutting</span>
                </a>

                <!-- Active Module: Sewing / Production Bundles -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-blue-600 text-white shadow-sm transition">
                    <i data-lucide="shirt" class="w-4 h-4 mr-3 text-white"></i>
                    <span>Sewing & Bundles</span>
                </a>

                <a href="#" class="flex items-center px-3 py-2 text-xs font-medium rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition group">
                    <i data-lucide="check-square" class="w-4 h-4 mr-3 text-slate-400 group-hover:text-white"></i>
                    <span>QC & Inspection</span>
                </a>

                <a href="#" class="flex items-center px-3 py-2 text-xs font-medium rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition group">
                    <i data-lucide="truck" class="w-4 h-4 mr-3 text-slate-400 group-hover:text-white"></i>
                    <span>Shipping</span>
                </a>

                <div class="pt-4 px-3 pb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Administration</div>

                <a href="{{ route('master.index') }}" class="flex items-center px-3 py-2 text-xs font-medium rounded-lg {{ request()->routeIs('master.*') ? 'bg-slate-800 text-blue-400' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition group">
                    <i data-lucide="database" class="w-4 h-4 mr-3 text-slate-400 group-hover:text-white"></i>
                    <span>Master Data</span>
                </a>
            </nav>

            <!-- Bottom Sidebar Footer -->
            <div class="p-3 border-t border-slate-800 space-y-1">
                <a href="#" class="flex items-center px-3 py-2 text-xs font-medium rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <i data-lucide="settings" class="w-4 h-4 mr-3"></i>
                    <span>Settings</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-xs font-medium rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <i data-lucide="help-circle" class="w-4 h-4 mr-3"></i>
                    <span>Support & Docs</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-100">

            <!-- Top Header Bar -->
            <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between flex-shrink-0 z-10 shadow-sm">
                
                <!-- Left Title & Navigation Tabs -->
                <div class="flex items-center space-x-8">
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center">
                        @yield('header_title', 'Bundle Management')
                    </h1>

                    <!-- Header Navigation Tabs -->
                    <div class="flex space-x-6 text-sm">
                        <a href="{{ route('dashboard') }}" class="py-5 px-1 border-b-2 font-medium {{ request()->routeIs('dashboard') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('bundles.create') }}" class="py-5 px-1 border-b-2 font-medium {{ request()->routeIs('bundles.create') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' }}">
                            Entry Form
                        </a>
                        <a href="{{ route('bundles.index') }}" class="py-5 px-1 border-b-2 font-medium {{ request()->routeIs('bundles.index') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' }}">
                            Listing
                        </a>
                        <a href="{{ route('master.index') }}" class="py-5 px-1 border-b-2 font-medium {{ request()->routeIs('master.index') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' }}">
                            Master Data
                        </a>
                    </div>
                </div>

                <!-- Right Header Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Global Search input -->
                    <div class="relative w-64 hidden md:block">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                        <input type="text" id="globalQuickSearch" placeholder="Search bundles, orders..." class="w-full pl-9 pr-4 py-1.5 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-slate-700 placeholder-slate-400 transition" onkeyup="if(event.key==='Enter') window.location.href='{{ route('bundles.index') }}?search='+encodeURIComponent(this.value)">
                    </div>

                    <!-- Notification Bell -->
                    <button class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg relative transition">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-blue-600 rounded-full ring-2 ring-white"></span>
                    </button>

                    <!-- History Log Button -->
                    <button onclick="openActivityHistoryModal()" title="View System Activity Log" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition">
                        <i data-lucide="history" class="w-5 h-5"></i>
                    </button>

                    <!-- User Profile Avatar -->
                    <div class="flex items-center space-x-2 pl-2 border-l border-slate-200">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-sm ring-1 ring-slate-200">
                            PE
                        </div>
                        <div class="hidden lg:block text-left">
                            <div class="text-xs font-semibold text-slate-800 leading-tight">Production Exec</div>
                            <div class="text-[10px] text-slate-400">Shift Manager</div>
                        </div>
                    </div>
                </div>

            </header>

            <!-- Page Dynamic Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>

        </div>

    </div>

    <!-- Toast Notification Container -->
    <div id="toastContainer" class="fixed bottom-5 right-5 z-50 flex flex-col space-y-3 pointer-events-none"></div>

    <!-- Global Activity Log Modal -->
    <div id="activityHistoryModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-200 transform transition-all">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                <div class="flex items-center space-x-2">
                    <i data-lucide="activity" class="w-5 h-5 text-blue-600"></i>
                    <h3 class="text-base font-bold text-slate-900">System Activity Audit Log</h3>
                </div>
                <button onclick="closeActivityHistoryModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-200">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="p-6 max-h-[60vh] overflow-y-auto space-y-4" id="activityLogsList">
                <div class="text-center py-6 text-slate-400 text-sm">
                    <i data-lucide="loader-2" class="w-6 h-6 animate-spin mx-auto mb-2 text-blue-500"></i>
                    Loading audit trail...
                </div>
            </div>
            <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex justify-end">
                <button onclick="closeActivityHistoryModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold rounded-lg">Close</button>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide Icons
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });

        // Toast Helper
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            
            const isSuccess = type === 'success';
            const isError = type === 'error';
            const bgColor = isSuccess ? 'bg-emerald-600' : (isError ? 'bg-rose-600' : 'bg-blue-600');
            const iconName = isSuccess ? 'check-circle' : (isError ? 'alert-circle' : 'info');

            toast.className = `${bgColor} text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-3 pointer-events-auto transition-all duration-300 transform translate-y-2 opacity-0 text-sm`;
            toast.innerHTML = `
                <i data-lucide="${iconName}" class="w-5 h-5 flex-shrink-0"></i>
                <div class="font-medium">${message}</div>
            `;
            
            container.appendChild(toast);
            lucide.createIcons();

            setTimeout(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
            }, 10);

            setTimeout(() => {
                toast.classList.add('translate-y-2', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        // Global Activity History Modal logic
        function openActivityHistoryModal() {
            const modal = document.getElementById('activityHistoryModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            fetchActivityLogs();
        }

        function closeActivityHistoryModal() {
            const modal = document.getElementById('activityHistoryModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function fetchActivityLogs() {
            const list = document.getElementById('activityLogsList');
            fetch('/api/dashboard')
                .then(r => r.json())
                .then(res => {
                    const bundles = res.data.recent_bundles || [];
                    if (bundles.length === 0) {
                        list.innerHTML = `<div class="text-center py-6 text-slate-400 text-sm">No recent activity logged yet.</div>`;
                        return;
                    }

                    list.innerHTML = bundles.map(b => `
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-between text-xs">
                            <div>
                                <div class="font-semibold text-slate-900">${b.bundle_no} (${b.buyer ? b.buyer.buyer_name : 'N/A'})</div>
                                <div class="text-slate-500">Qty: ${b.quantity} | Done: ${b.completed_qty} | Rej: ${b.rejected_qty} | Operator: ${b.operator_name || 'N/A'}</div>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold ${b.status_label === 'PASSED' ? 'bg-emerald-100 text-emerald-700' : (b.status_label === 'REJECTED' ? 'bg-rose-100 text-rose-700' : 'bg-blue-100 text-blue-700')}">${b.status_label}</span>
                                <div class="text-[10px] text-slate-400 mt-1">${new Date(b.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                            </div>
                        </div>
                    `).join('');
                    lucide.createIcons();
                })
                .catch(() => {
                    list.innerHTML = `<div class="text-center py-6 text-rose-500 text-sm">Failed to load audit logs.</div>`;
                });
        }
    </script>
    @yield('scripts')
</body>
</html>
