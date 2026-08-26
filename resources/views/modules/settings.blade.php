@extends('layouts.app')

@section('title', 'System Settings & Factory Setup')
@section('header_title', 'System Settings & Setup')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Top Sub-Header Tabs -->
    <div class="border-b border-slate-200 bg-white px-6 rounded-t-2xl shadow-sm">
        <nav class="flex space-x-8 text-xs font-semibold overflow-x-auto">
            <button onclick="switchSettingsTab('general')" id="set-tab-general" class="py-4 px-1 border-b-2 border-blue-600 text-blue-600 font-bold flex items-center space-x-2">
                <i data-lucide="building-2" class="w-4 h-4"></i>
                <span>Factory Profile</span>
            </button>
            <button onclick="switchSettingsTab('shifts')" id="set-tab-shifts" class="py-4 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center space-x-2">
                <i data-lucide="clock" class="w-4 h-4"></i>
                <span>Shifts & Working Hours</span>
            </button>
            <button onclick="switchSettingsTab('quality')" id="set-tab-quality" class="py-4 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center space-x-2">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                <span>AQL & Quality Rules</span>
            </button>
            <button onclick="switchSettingsTab('barcode')" id="set-tab-barcode" class="py-4 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center space-x-2">
                <i data-lucide="qr-code" class="w-4 h-4"></i>
                <span>Bundle & Barcode Rules</span>
            </button>
            <button onclick="switchSettingsTab('users')" id="set-tab-users" class="py-4 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center space-x-2">
                <i data-lucide="users" class="w-4 h-4"></i>
                <span>Roles & Permissions</span>
            </button>
            <button onclick="switchSettingsTab('backup')" id="set-tab-backup" class="py-4 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center space-x-2">
                <i data-lucide="database" class="w-4 h-4"></i>
                <span>Database & Backup</span>
            </button>
        </nav>
    </div>

    <!-- 1. Factory Profile Tab -->
    <div id="set-view-general" class="space-y-6 animate-slide-up">
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.03)] p-6 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Apparel Factory Profile & Plant Credentials</h3>
                    <p class="text-xs text-slate-400">Basic enterprise details printed on bundle travelers, invoices, and QC slips</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Licensed ERP Node</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">Manufacturing Company Name</label>
                    <input type="text" value="Apex Global Apparel Manufacturing Complex Ltd." class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">Plant / Unit Code</label>
                    <input type="text" value="UNIT-01 (Export Garment Division)" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">Factory Physical Address</label>
                    <input type="text" value="Plot 42-48, Apparel Industrial Export Park, Zone B" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 transition">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase mb-1.5">Base Currency</label>
                        <input type="text" value="USD ($)" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 font-bold transition">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase mb-1.5">Default Timezone</label>
                        <input type="text" value="Asia/Kolkata (IST +5:30)" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 transition">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button onclick="showToast('Factory profile saved successfully!', 'success')" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-sm transition active:scale-95">
                    Save Profile
                </button>
            </div>
        </div>
    </div>

    <!-- 2. Shifts & Working Hours Tab -->
    <div id="set-view-shifts" class="space-y-6 hidden animate-slide-up">
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.03)] p-6 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Sewing Line Shift Rosters & Daily Capacity</h3>
                    <p class="text-xs text-slate-400">Shift schedules used for target tracking and hourly efficiency graphs</p>
                </div>
                <button onclick="showToast('Add Shift Modal triggered', 'info')" class="px-3.5 py-1.5 bg-blue-600 text-white text-xs font-bold rounded-lg shadow-sm">
                    + Add Custom Shift
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="px-5 py-3">SHIFT NAME</th>
                            <th class="px-5 py-3">TIMINGS</th>
                            <th class="px-5 py-3">BREAK DURATION</th>
                            <th class="px-5 py-3">TARGET EFFICIENCY</th>
                            <th class="px-5 py-3">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5 font-bold text-slate-900">Shift A (Morning)</td>
                            <td class="px-5 py-3.5 font-mono text-slate-600">06:00 AM - 02:00 PM (8 hrs)</td>
                            <td class="px-5 py-3.5 text-slate-500">45 mins (Lunch & Tea)</td>
                            <td class="px-5 py-3.5 font-bold text-emerald-600">88.0%</td>
                            <td class="px-5 py-3.5"><span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">ACTIVE</span></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5 font-bold text-slate-900">Shift B (Evening)</td>
                            <td class="px-5 py-3.5 font-mono text-slate-600">02:00 PM - 10:00 PM (8 hrs)</td>
                            <td class="px-5 py-3.5 text-slate-500">45 mins (Dinner & Tea)</td>
                            <td class="px-5 py-3.5 font-bold text-emerald-600">85.0%</td>
                            <td class="px-5 py-3.5"><span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">ACTIVE</span></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5 font-bold text-slate-900">General Shift</td>
                            <td class="px-5 py-3.5 font-mono text-slate-600">08:30 AM - 05:30 PM (9 hrs)</td>
                            <td class="px-5 py-3.5 text-slate-500">60 mins (Lunch & 2 Teas)</td>
                            <td class="px-5 py-3.5 font-bold text-blue-600">90.0%</td>
                            <td class="px-5 py-3.5"><span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">OPTIONAL</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 3. AQL & Quality Rules Tab -->
    <div id="set-view-quality" class="space-y-6 hidden animate-slide-up">
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.03)] p-6 space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-sm font-bold text-slate-900">AQL Quality Inspection & Auto-Hold Safeguards</h3>
                <p class="text-xs text-slate-400">Set statistical acceptance quality limits and automatic quarantine rules</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">Primary AQL Standard</label>
                    <select class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition">
                        <option selected>AQL 2.5 - Standard Commercial Export</option>
                        <option>AQL 1.5 - High-End / Luxury Garment Strict Audit</option>
                        <option>AQL 4.0 - Basic Utility Garments</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">Defect Rate Warning Threshold (%)</label>
                    <input type="number" value="5.0" step="0.1" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 font-bold">
                    <p class="text-[10px] text-slate-400 mt-1">Bundles exceeding this defect % will trigger supervisor audit alert.</p>
                </div>

                <div class="md:col-span-2 p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-3">
                    <div class="font-bold text-slate-800 uppercase">Automatic Shop Floor Safeguards</div>
                    <div class="space-y-2">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded">
                            <span class="font-medium text-slate-700">Auto-quarantine bundle if Rejected Quantity exceeds 10% of total lot</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded">
                            <span class="font-medium text-slate-700">Require supervisor pin sign-off before closing bundle with non-zero balance</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button onclick="showToast('Quality rules updated successfully!', 'success')" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-sm transition">
                    Save QA Rules
                </button>
            </div>
        </div>
    </div>

    <!-- 4. Bundle & Barcode Rules Tab -->
    <div id="set-view-barcode" class="space-y-6 hidden animate-slide-up">
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.03)] p-6 space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-sm font-bold text-slate-900">Bundle Identification & Barcode Slip Printer Defaults</h3>
                <p class="text-xs text-slate-400">Format bundle numbering tags, barcodes, and print slip layouts</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">Bundle Numbering Prefix</label>
                    <input type="text" value="BN-" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 font-mono font-bold">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">Barcode Symbology Standard</label>
                    <select class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 font-semibold">
                        <option selected>Code 128 (High Density Alphanumeric)</option>
                        <option>QR Code (2D Data Matrix)</option>
                        <option>EAN-13 / UPC-A</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">Print Slip Paper Format</label>
                    <select class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 font-semibold">
                        <option selected>Thermal 4" x 6" Adhesive Routing Ticket</option>
                        <option>A4 Sheet (4 Bundles per Page)</option>
                        <option>Continuous Roll 80mm</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1.5">Auto-Generate Bundle Sequence</label>
                    <input type="text" value="Enabled (Automatic sequential counter)" readonly class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl bg-emerald-50 text-emerald-800 font-bold">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button onclick="showToast('Barcode preferences saved!', 'success')" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-sm transition">
                    Save Barcode Config
                </button>
            </div>
        </div>
    </div>

    <!-- 5. Roles & Permissions Tab -->
    <div id="set-view-users" class="space-y-6 hidden animate-slide-up">
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.03)] p-6 space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-sm font-bold text-slate-900">ERP User Roles & Shop Floor Permissions</h3>
                <p class="text-xs text-slate-400">Role-based authorization for Supervisors, QC Auditors, and Operators</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    <div class="font-bold text-slate-900 flex items-center justify-between">
                        <span>Production Manager</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">ALL PERMS</span>
                    </div>
                    <p class="text-slate-500 text-[11px]">Full access to create, edit, delete, export, and manage master configurations.</p>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    <div class="font-bold text-slate-900 flex items-center justify-between">
                        <span>Shift Supervisor</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">OPERATIONAL</span>
                    </div>
                    <p class="text-slate-500 text-[11px]">Can create and update production bundles, enter outputs, and print routing slips.</p>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    <div class="font-bold text-slate-900 flex items-center justify-between">
                        <span>QC Inspector</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">INSPECTION</span>
                    </div>
                    <p class="text-slate-500 text-[11px]">Can log defect reasons, update rejected counts, and issue QA pass verdicts.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. Database & Backup Tab -->
    <div id="set-view-backup" class="space-y-6 hidden animate-slide-up">
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.03)] p-6 space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-sm font-bold text-slate-900">Database Administration & SQL Dump Backup</h3>
                <p class="text-xs text-slate-400">Database health, cache management, and instant SQL export downloads</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs">
                <div class="p-5 bg-blue-50/50 border border-blue-100 rounded-2xl space-y-3">
                    <div class="font-bold text-blue-900 flex items-center space-x-2">
                        <i data-lucide="download-cloud" class="w-5 h-5 text-blue-600"></i>
                        <span class="text-sm">MySQL Database Dump (.sql)</span>
                    </div>
                    <p class="text-slate-600 text-xs">Full schema DDL with composite performance indexes and complete table data.</p>
                    <div class="font-mono text-[11px] bg-white p-2 rounded border border-blue-200 text-slate-700">
                        File: database/bundle_management_system.sql
                    </div>
                    <button onclick="showToast('Database dump downloaded successfully!', 'success')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                        Download Full SQL Dump
                    </button>
                </div>

                <div class="p-5 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                    <div class="font-bold text-slate-900 flex items-center space-x-2">
                        <i data-lucide="zap" class="w-5 h-5 text-amber-500"></i>
                        <span class="text-sm">System Cache & Maintenance</span>
                    </div>
                    <p class="text-slate-500 text-xs">Purge compiled blade templates, route cache, and query caches.</p>
                    <div class="flex space-x-2 pt-2">
                        <button onclick="showToast('View and route caches purged!', 'success')" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-sm transition">
                            Clear System Cache
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function switchSettingsTab(tabName) {
        ['general', 'shifts', 'quality', 'barcode', 'users', 'backup'].forEach(t => {
            const el = document.getElementById(`set-view-${t}`);
            const btn = document.getElementById(`set-tab-${t}`);
            if (el) el.classList.add('hidden');
            if (btn) {
                btn.className = 'py-4 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center space-x-2';
            }
        });

        const activeEl = document.getElementById(`set-view-${tabName}`);
        const activeBtn = document.getElementById(`set-tab-${tabName}`);
        if (activeEl) activeEl.classList.remove('hidden');
        if (activeBtn) {
            activeBtn.className = 'py-4 px-1 border-b-2 border-blue-600 text-blue-600 font-bold flex items-center space-x-2';
        }
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }
</script>
@endsection