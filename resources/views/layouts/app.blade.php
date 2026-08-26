<!DOCTYPE html>
<html lang="en" class="h-full bg-[#f8fafc]">
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        [x-cloak] { display: none !important; }
        
        /* Matching Sidebar Styling from Mockups */
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 0.65rem 1rem;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #334155;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: all 0.15s ease;
            margin-bottom: 0.25rem;
        }
        .sidebar-item:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }
        .sidebar-item.active {
            background-color: #2563eb !important;
            color: #ffffff !important;
            font-weight: 600;
            box-shadow: 0 1px 2px rgba(37, 99, 235, 0.2);
        }
        .sidebar-item.active svg {
            color: #ffffff !important;
        }
    </style>
</head>
<body class="h-full text-slate-800 antialiased flex flex-col">

    <div class="flex h-screen w-full overflow-hidden bg-[#f8fafc]">

        <!-- Left Sidebar (Clean White Background Matching Mockup) -->
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col flex-shrink-0 z-20 select-none">
            
            <!-- Brand Logo Header -->
            <div class="h-16 px-6 flex items-center justify-between border-b border-slate-100">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-slate-900 no-underline">
                    <div class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center text-white font-bold text-base shadow-sm">
                        <i data-lucide="layers" class="w-4 h-4 text-blue-400"></i>
                    </div>
                    <div>
                        <div class="text-sm font-black text-slate-900 tracking-tight leading-none">Pro ERP</div>
                        <div class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mt-0.5">MANUFACTURING</div>
                    </div>
                </a>
            </div>

            <!-- New Production Order Button -->
            <div class="px-4 py-4">
                <a href="{{ route('bundles.create') }}" class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 bg-[#0f172a] hover:bg-slate-800 text-white text-xs font-bold rounded-lg shadow-sm transition no-underline">
                    <i data-lucide="plus" class="w-4 h-4 text-slate-300"></i>
                    <span>New Production Order</span>
                </a>
            </div>

            <!-- ERP Modules Navigation List -->
            <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
                <!-- Sourcing -->
                <a href="{{ route('modules.sourcing') }}" class="sidebar-item {{ request()->routeIs('modules.sourcing') ? 'active' : '' }}">
                    <i data-lucide="box" class="w-4 h-4 mr-3 text-slate-500"></i>
                    <span>Sourcing</span>
                </a>

                <!-- Cutting -->
                <a href="{{ route('modules.cutting') }}" class="sidebar-item {{ request()->routeIs('modules.cutting') ? 'active' : '' }}">
                    <i data-lucide="scissors" class="w-4 h-4 mr-3 text-slate-500"></i>
                    <span>Cutting</span>
                </a>

                <!-- Sewing (Bundle Management) -->
                <a href="{{ route('dashboard') }}" class="sidebar-item {{ (request()->routeIs('dashboard') || request()->routeIs('bundles.*')) ? 'active' : '' }}">
                    <i data-lucide="shirt" class="w-4 h-4 mr-3 {{ (request()->routeIs('dashboard') || request()->routeIs('bundles.*')) ? 'text-white' : 'text-slate-500' }}"></i>
                    <span>Sewing</span>
                </a>

                <!-- QC -->
                <a href="{{ route('modules.qc') }}" class="sidebar-item {{ request()->routeIs('modules.qc') ? 'active' : '' }}">
                    <i data-lucide="check-square" class="w-4 h-4 mr-3 text-slate-500"></i>
                    <span>QC</span>
                </a>

                <!-- Shipping -->
                <a href="{{ route('modules.shipping') }}" class="sidebar-item {{ request()->routeIs('modules.shipping') ? 'active' : '' }}">
                    <i data-lucide="truck" class="w-4 h-4 mr-3 text-slate-500"></i>
                    <span>Shipping</span>
                </a>
            </nav>

            <!-- Bottom Sidebar Menu (Settings & Support) -->
            <div class="p-3 border-t border-slate-100 space-y-1 bg-white">
                <a href="{{ route('modules.settings') }}" class="sidebar-item {{ request()->routeIs('modules.settings') ? 'active' : '' }}">
                    <i data-lucide="settings" class="w-4 h-4 mr-3 text-slate-500"></i>
                    <span>Settings</span>
                </a>
                <a href="{{ route('modules.support') }}" class="sidebar-item {{ request()->routeIs('modules.support') ? 'active' : '' }}">
                    <i data-lucide="help-circle" class="w-4 h-4 mr-3 text-slate-500"></i>
                    <span>Support</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#f8fafc]">

            <!-- Top Header Bar (Matching Mockup 1 & 2) -->
            <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between flex-shrink-0 z-10">
                
                <!-- Left Title & Navigation Tabs -->
                <div class="flex items-center space-x-8">
                    <h1 class="text-lg font-bold text-slate-900 tracking-tight">
                        @yield('header_title', 'Bundle Management')
                    </h1>

                    <!-- Header Navigation Tabs -->
                    <div class="flex space-x-6 text-xs font-semibold">
                        <a href="{{ route('dashboard') }}" class="py-5 px-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-900' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('bundles.create') }}" class="py-5 px-1 border-b-2 {{ request()->routeIs('bundles.create') ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-900' }}">
                            Entry Form
                        </a>
                        <a href="{{ route('bundles.index') }}" class="py-5 px-1 border-b-2 {{ request()->routeIs('bundles.index') ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-900' }}">
                            Listing
                        </a>
                        <a href="{{ route('master.index') }}" class="py-5 px-1 border-b-2 {{ request()->routeIs('master.*') ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-900' }}">
                            Master Data
                        </a>
                    </div>
                </div>

                <!-- Right Header Tools -->
                <div class="flex items-center space-x-4">
                    <!-- Search Input -->
                    <div class="relative w-64 hidden md:block">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                        <input type="text" placeholder="Search bundles, orders..." class="w-full pl-9 pr-4 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 focus:bg-white text-slate-700 placeholder-slate-400 transition" onkeyup="if(event.key==='Enter') window.location.href='{{ route('bundles.index') }}?search='+encodeURIComponent(this.value)">
                    </div>

                    <!-- Notification Bell -->
                    <button onclick="showToast('No new factory alerts', 'info')" class="p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition relative">
                        <i data-lucide="bell" class="w-4 h-4"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-blue-600 rounded-full"></span>
                    </button>

                    <!-- History Audit Icon -->
                    <button onclick="openActivityHistoryModal()" title="View System Audit Trail" class="p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition">
                        <i data-lucide="history" class="w-4 h-4"></i>
                    </button>

                    <!-- Profile Avatar -->
                    <div class="w-7 h-7 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-[11px] ring-2 ring-slate-100 cursor-pointer">
                        JD
                    </div>
                </div>

            </header>

            <!-- Main Dynamic Page Body -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>

        </div>

    </div>

    <!-- Toast Notification Container -->
    <div id="toastContainer" class="fixed bottom-5 right-5 z-50 flex flex-col space-y-2 pointer-events-none"></div>

    <!-- Global Activity Audit Log Modal -->
    <div id="activityHistoryModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-xl overflow-hidden border border-slate-200">
            <div class="px-5 py-3.5 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                <div class="flex items-center space-x-2">
                    <i data-lucide="history" class="w-4 h-4 text-blue-600"></i>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">System Activity Audit Trail</h3>
                </div>
                <button onclick="closeActivityHistoryModal()" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            <div class="p-5 max-h-[55vh] overflow-y-auto space-y-3" id="activityLogsList">
                <div class="text-center py-6 text-slate-400 text-xs">Loading audit logs...</div>
            </div>
            <div class="px-5 py-2.5 bg-slate-50 border-t border-slate-200 flex justify-end">
                <button onclick="closeActivityHistoryModal()" class="px-3.5 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-lg">Close</button>
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
            const bgColor = isSuccess ? 'bg-emerald-600' : (isError ? 'bg-rose-600' : 'bg-slate-800');
            const iconName = isSuccess ? 'check-circle' : (isError ? 'alert-circle' : 'info');

            toast.className = `${bgColor} text-white px-4 py-2.5 rounded-lg shadow-lg flex items-center space-x-2 pointer-events-auto transition-all duration-200 text-xs font-medium`;
            toast.innerHTML = `<i data-lucide="${iconName}" class="w-4 h-4 flex-shrink-0"></i><span>${message}</span>`;
            
            container.appendChild(toast);
            if (typeof lucide !== 'undefined') lucide.createIcons();

            setTimeout(() => toast.remove(), 3500);
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
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-between text-xs">
                            <div>
                                <div class="font-bold text-slate-800">${b.bundle_no} (${b.buyer ? b.buyer.buyer_name : 'N/A'})</div>
                                <div class="text-slate-500 text-[11px]">Qty: ${b.quantity} | Done: ${b.completed_qty} | Rej: ${b.rejected_qty}</div>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold ${b.status_label === 'PASSED' ? 'bg-emerald-100 text-emerald-800' : (b.status_label === 'REJECTED' ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800')}">${b.status_label}</span>
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