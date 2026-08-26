@extends('layouts.app')

@section('title', 'New Production Bundle')
@section('header_title', 'Bundle Management')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Page Header Title & Subtitle -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Production Bundle Entry Form</h2>
            <p class="text-xs text-slate-500 mt-0.5">Create and register a new apparel manufacturing bundle with real-time balance calculations</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('bundles.index') }}" class="px-3.5 py-2 bg-white border border-slate-300 text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-50 transition flex items-center space-x-1.5 shadow-sm">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Back to Listing</span>
            </a>
        </div>
    </div>

    <!-- Main Grid: Form (Left) & Real-Time Calculation HUD (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Form Card (2 Cols) -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <i data-lucide="edit-3" class="w-4 h-4 text-blue-600"></i>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Bundle Details</span>
                </div>
                <button type="button" onclick="generateRandomBundleNo()" class="text-blue-600 hover:text-blue-800 text-xs font-semibold flex items-center space-x-1">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    <span>Generate Bundle #</span>
                </button>
            </div>

            <form id="bundleEntryForm" class="p-6 space-y-5" onsubmit="submitBundleForm(event)">
                @csrf

                <!-- Row 1: Bundle Number & Production Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="bundle_no" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Bundle Number <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="bundle_no" name="bundle_no" value="{{ $nextBundleNo }}" required placeholder="e.g. BN-1042" class="w-full px-3.5 py-2 text-xs font-mono font-bold bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-slate-800 transition">
                            <span id="err_bundle_no" class="text-[11px] text-rose-500 mt-1 hidden"></span>
                        </div>
                    </div>

                    <div>
                        <label for="production_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Production Date <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" id="production_date" name="production_date" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-slate-800 transition">
                        <span id="err_production_date" class="text-[11px] text-rose-500 mt-1 hidden"></span>
                    </div>
                </div>

                <!-- Row 2: Buyer & Style (Dynamic Dependent Dropdown) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="buyer_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Buyer <span class="text-rose-500">*</span>
                        </label>
                        <select id="buyer_id" name="buyer_id" required onchange="onBuyerSelected(this.value)" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-slate-800 transition">
                            <option value="">-- Select Buyer --</option>
                            @foreach($buyers as $buyer)
                                <option value="{{ $buyer->id }}">{{ $buyer->buyer_name }}</option>
                            @endforeach
                        </select>
                        <span id="err_buyer_id" class="text-[11px] text-rose-500 mt-1 hidden"></span>
                    </div>

                    <div>
                        <label for="style_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Style / PO <span class="text-rose-500">*</span>
                        </label>
                        <select id="style_id" name="style_id" required disabled class="w-full px-3.5 py-2 text-xs bg-slate-100 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-slate-800 transition disabled:opacity-60 disabled:cursor-not-allowed">
                            <option value="">-- Select Buyer First --</option>
                        </select>
                        <span id="err_style_id" class="text-[11px] text-rose-500 mt-1 hidden"></span>
                    </div>
                </div>

                <!-- Row 3: Color, Size & Sewing Line -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="color" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Color <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="color" name="color" required placeholder="e.g. Navy" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-slate-800 transition">
                        <div class="flex flex-wrap gap-1 mt-1.5">
                            <button type="button" onclick="document.getElementById('color').value='Navy'" class="text-[10px] bg-slate-100 hover:bg-slate-200 px-1.5 py-0.5 rounded text-slate-600">Navy</button>
                            <button type="button" onclick="document.getElementById('color').value='Black'" class="text-[10px] bg-slate-100 hover:bg-slate-200 px-1.5 py-0.5 rounded text-slate-600">Black</button>
                            <button type="button" onclick="document.getElementById('color').value='White'" class="text-[10px] bg-slate-100 hover:bg-slate-200 px-1.5 py-0.5 rounded text-slate-600">White</button>
                            <button type="button" onclick="document.getElementById('color').value='Olive'" class="text-[10px] bg-slate-100 hover:bg-slate-200 px-1.5 py-0.5 rounded text-slate-600">Olive</button>
                        </div>
                        <span id="err_color" class="text-[11px] text-rose-500 mt-1 hidden"></span>
                    </div>

                    <div>
                        <label for="size" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Size <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="size" name="size" required placeholder="e.g. M" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-slate-800 transition">
                        <div class="flex flex-wrap gap-1 mt-1.5">
                            <button type="button" onclick="document.getElementById('size').value='S'" class="text-[10px] bg-slate-100 hover:bg-slate-200 px-1.5 py-0.5 rounded text-slate-600">S</button>
                            <button type="button" onclick="document.getElementById('size').value='M'" class="text-[10px] bg-slate-100 hover:bg-slate-200 px-1.5 py-0.5 rounded text-slate-600">M</button>
                            <button type="button" onclick="document.getElementById('size').value='L'" class="text-[10px] bg-slate-100 hover:bg-slate-200 px-1.5 py-0.5 rounded text-slate-600">L</button>
                            <button type="button" onclick="document.getElementById('size').value='XL'" class="text-[10px] bg-slate-100 hover:bg-slate-200 px-1.5 py-0.5 rounded text-slate-600">XL</button>
                        </div>
                        <span id="err_size" class="text-[11px] text-rose-500 mt-1 hidden"></span>
                    </div>

                    <div>
                        <label for="line_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Sewing Line <span class="text-rose-500">*</span>
                        </label>
                        <select id="line_id" name="line_id" required class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-slate-800 transition">
                            <option value="">-- Select Line --</option>
                            @foreach($lines as $line)
                                <option value="{{ $line->id }}">{{ $line->line_name }} ({{ $line->floor ?? 'Floor 1' }})</option>
                            @endforeach
                        </select>
                        <span id="err_line_id" class="text-[11px] text-rose-500 mt-1 hidden"></span>
                    </div>
                </div>

                <!-- Row 4: Quantities (Quantity, Completed, Rejected) -->
                <div class="p-4 bg-blue-50/50 rounded-xl border border-blue-100 space-y-3">
                    <div class="text-xs font-bold text-blue-900 uppercase tracking-wider flex items-center space-x-1.5">
                        <i data-lucide="calculator" class="w-4 h-4 text-blue-600"></i>
                        <span>Production Quantities & Audit</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="quantity" class="block text-xs font-bold text-slate-700 mb-1">
                                Total Quantity <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" id="quantity" name="quantity" min="1" value="500" required oninput="calculateRealTimeMetrics()" class="w-full px-3.5 py-2 text-sm font-bold bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-900 transition">
                            <span id="err_quantity" class="text-[11px] text-rose-500 mt-1 hidden"></span>
                        </div>

                        <div>
                            <label for="completed_qty" class="block text-xs font-bold text-slate-700 mb-1">
                                Completed Quantity
                            </label>
                            <input type="number" id="completed_qty" name="completed_qty" min="0" value="0" required oninput="calculateRealTimeMetrics()" class="w-full px-3.5 py-2 text-sm font-bold bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-emerald-700 transition">
                            <span id="err_completed_qty" class="text-[11px] text-rose-500 mt-1 hidden"></span>
                        </div>

                        <div>
                            <label for="rejected_qty" class="block text-xs font-bold text-slate-700 mb-1">
                                Rejected Quantity
                            </label>
                            <input type="number" id="rejected_qty" name="rejected_qty" min="0" value="0" required oninput="calculateRealTimeMetrics()" class="w-full px-3.5 py-2 text-sm font-bold bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-rose-700 transition">
                            <span id="err_rejected_qty" class="text-[11px] text-rose-500 mt-1 hidden"></span>
                        </div>
                    </div>

                    <!-- Client-Side Constraint Error Banner -->
                    <div id="quantityMathAlert" class="hidden p-2.5 bg-rose-100 text-rose-800 text-xs font-medium rounded-lg items-center space-x-2">
                        <i data-lucide="alert-triangle" class="w-4 h-4 flex-shrink-0 text-rose-600"></i>
                        <span id="quantityMathAlertText">Error: Completed + Rejected cannot exceed Total Quantity.</span>
                    </div>
                </div>

                <!-- Row 5: Operator & Remarks -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="operator_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Operator Name
                        </label>
                        <input type="text" id="operator_name" name="operator_name" placeholder="e.g. John Miller" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-slate-800 transition">
                        <span id="err_operator_name" class="text-[11px] text-rose-500 mt-1 hidden"></span>
                    </div>

                    <div>
                        <label for="remarks" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Remarks / Notes
                        </label>
                        <input type="text" id="remarks" name="remarks" placeholder="e.g. Critical rush order lot" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-slate-800 transition">
                        <span id="err_remarks" class="text-[11px] text-rose-500 mt-1 hidden"></span>
                    </div>
                </div>

                <!-- Action Buttons & Anti-Duplicate Protection -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <button type="button" onclick="resetEntryForm()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">
                        Reset Form
                    </button>
                    
                    <button type="submit" id="submitBtn" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm flex items-center space-x-2 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="submitSpinner" class="hidden"><i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i></span>
                        <i data-lucide="save" id="submitIcon" class="w-4 h-4"></i>
                        <span id="submitBtnText">Save Production Bundle</span>
                    </button>
                </div>

            </form>
        </div>

        <!-- Real-Time Calculations HUD Card (1 Col) -->
        <div class="space-y-6">

            <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-xl p-6 shadow-md border border-slate-800 space-y-6">
                
                <div class="flex items-center justify-between border-b border-slate-700 pb-4">
                    <div class="flex items-center space-x-2">
                        <div class="p-1.5 bg-blue-600 rounded-lg">
                            <i data-lucide="cpu" class="w-4 h-4 text-white"></i>
                        </div>
                        <h3 class="text-sm font-bold text-white tracking-wide">Live Calculation HUD</h3>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1 animate-ping"></span> Real-Time
                    </span>
                </div>

                <!-- 1. Balance Quantity Card -->
                <div class="bg-slate-800/80 rounded-xl p-4 border border-slate-700">
                    <div class="text-[11px] font-semibold uppercase text-slate-400 tracking-wider">Balance Quantity</div>
                    <div class="text-3xl font-black text-white mt-1" id="hudBalanceQty">500 <span class="text-xs font-normal text-slate-400">pcs</span></div>
                    <div class="text-[11px] text-slate-400 mt-1">Quantity – Completed – Rejected</div>
                    
                    <!-- Progress Bar -->
                    <div class="w-full bg-slate-700 h-2 rounded-full overflow-hidden mt-3 flex">
                        <div id="barCompleted" class="bg-emerald-500 h-full transition-all duration-300" style="width: 0%"></div>
                        <div id="barRejected" class="bg-rose-500 h-full transition-all duration-300" style="width: 0%"></div>
                        <div id="barBalance" class="bg-blue-500 h-full transition-all duration-300" style="width: 100%"></div>
                    </div>
                </div>

                <!-- 2. Efficiency % Card -->
                <div class="bg-slate-800/80 rounded-xl p-4 border border-slate-700 flex items-center justify-between">
                    <div>
                        <div class="text-[11px] font-semibold uppercase text-slate-400 tracking-wider">Efficiency %</div>
                        <div class="text-2xl font-black text-emerald-400 mt-1" id="hudEfficiency">0.0%</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">(Completed / Qty) × 100</div>
                    </div>
                    <div class="text-right">
                        <span id="hudEfficiencyBadge" class="px-2.5 py-1 rounded text-[11px] font-bold bg-slate-700 text-slate-300">
                            PENDING
                        </span>
                    </div>
                </div>

                <!-- 3. Rejection % Card -->
                <div class="bg-slate-800/80 rounded-xl p-4 border border-slate-700 flex items-center justify-between">
                    <div>
                        <div class="text-[11px] font-semibold uppercase text-slate-400 tracking-wider">Rejection %</div>
                        <div class="text-2xl font-black text-rose-400 mt-1" id="hudRejection">0.0%</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">(Rejected / Qty) × 100</div>
                    </div>
                    <div class="text-right">
                        <span id="hudRejectionBadge" class="px-2.5 py-1 rounded text-[11px] font-bold bg-emerald-900/50 text-emerald-400">
                            0.0% Defect
                        </span>
                    </div>
                </div>

                <!-- Business Rules Helper Checklist -->
                <div class="space-y-2 pt-2 border-t border-slate-700 text-xs text-slate-300">
                    <div class="font-bold text-slate-400 text-[11px] uppercase tracking-wider">Business Rules Verification</div>
                    <div class="flex items-center space-x-2" id="chkQty">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-400"></i>
                        <span>Quantity &gt; 0</span>
                    </div>
                    <div class="flex items-center space-x-2" id="chkMath">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-400"></i>
                        <span>Completed + Rejected &le; Quantity</span>
                    </div>
                    <div class="flex items-center space-x-2" id="chkDate">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-400"></i>
                        <span>Production Date &le; Today</span>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
    function generateRandomBundleNo() {
        const rand = Math.floor(1000 + Math.random() * 9000);
        document.getElementById('bundle_no').value = 'BN-' + rand;
        clearErrors();
    }

    function onBuyerSelected(buyerId) {
        const styleSelect = document.getElementById('style_id');
        styleSelect.innerHTML = '<option value="">Loading styles...</option>';
        styleSelect.disabled = true;

        if (!buyerId) {
            styleSelect.innerHTML = '<option value="">-- Select Buyer First --</option>';
            return;
        }

        fetch(`/master-data/styles-by-buyer/${buyerId}`)
            .then(res => res.json())
            .then(response => {
                if (response.success && response.data.length > 0) {
                    let options = '<option value="">-- Select Style --</option>';
                    response.data.forEach(style => {
                        options += `<option value="${style.id}">${style.style_no} (${style.description || 'N/A'})</option>`;
                    });
                    styleSelect.innerHTML = options;
                    styleSelect.disabled = false;
                } else {
                    styleSelect.innerHTML = '<option value="">No active styles found for this buyer</option>';
                    styleSelect.disabled = true;
                }
            })
            .catch(() => {
                styleSelect.innerHTML = '<option value="">Error loading styles</option>';
                styleSelect.disabled = true;
            });
    }

    function calculateRealTimeMetrics() {
        const qty = Math.max(0, parseInt(document.getElementById('quantity').value) || 0);
        const comp = Math.max(0, parseInt(document.getElementById('completed_qty').value) || 0);
        const rej = Math.max(0, parseInt(document.getElementById('rejected_qty').value) || 0);

        const balance = Math.max(0, qty - comp - rej);
        const efficiency = qty > 0 ? ((comp / qty) * 100).toFixed(1) : 0.0;
        const rejection = qty > 0 ? ((rej / qty) * 100).toFixed(1) : 0.0;

        // Update HUD
        document.getElementById('hudBalanceQty').innerHTML = `${balance} <span class="text-xs font-normal text-slate-400">pcs</span>`;
        document.getElementById('hudEfficiency').innerText = `${efficiency}%`;
        document.getElementById('hudRejection').innerText = `${rejection}%`;

        // Update progress bar
        const compPct = qty > 0 ? Math.min(100, (comp / qty) * 100) : 0;
        const rejPct = qty > 0 ? Math.min(100 - compPct, (rej / qty) * 100) : 0;
        const balPct = Math.max(0, 100 - compPct - rejPct);

        document.getElementById('barCompleted').style.width = `${compPct}%`;
        document.getElementById('barRejected').style.width = `${rejPct}%`;
        document.getElementById('barBalance').style.width = `${balPct}%`;

        // Efficiency Badge
        const effBadge = document.getElementById('hudEfficiencyBadge');
        if (efficiency >= 90) {
            effBadge.className = 'px-2.5 py-1 rounded text-[11px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30';
            effBadge.innerText = 'HIGH EFFICIENCY';
        } else if (efficiency >= 60) {
            effBadge.className = 'px-2.5 py-1 rounded text-[11px] font-bold bg-yellow-500/20 text-yellow-300 border border-yellow-500/30';
            effBadge.innerText = 'NORMAL';
        } else {
            effBadge.className = 'px-2.5 py-1 rounded text-[11px] font-bold bg-slate-700 text-slate-300';
            effBadge.innerText = 'PENDING';
        }

        // Rejection Badge
        const rejBadge = document.getElementById('hudRejectionBadge');
        if (rejection > 5) {
            rejBadge.className = 'px-2.5 py-1 rounded text-[11px] font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30';
            rejBadge.innerText = `${rejection}% High Defect`;
        } else {
            rejBadge.className = 'px-2.5 py-1 rounded text-[11px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30';
            rejBadge.innerText = `${rejection}% Normal`;
        }

        // Validation Math Check
        const alertBox = document.getElementById('quantityMathAlert');
        const submitBtn = document.getElementById('submitBtn');

        if ((comp + rej) > qty) {
            alertBox.classList.remove('hidden');
            alertBox.classList.add('flex');
            document.getElementById('quantityMathAlertText').innerText = `Error: Completed (${comp}) + Rejected (${rej}) = ${comp + rej}, which exceeds Total Quantity (${qty}).`;
            submitBtn.disabled = true;
        } else {
            alertBox.classList.add('hidden');
            alertBox.classList.remove('flex');
            submitBtn.disabled = false;
        }
    }

    function clearErrors() {
        document.querySelectorAll('[id^="err_"]').forEach(el => {
            el.classList.add('hidden');
            el.innerText = '';
        });
    }

    function resetEntryForm() {
        document.getElementById('bundleEntryForm').reset();
        generateRandomBundleNo();
        calculateRealTimeMetrics();
        clearErrors();
    }

    function submitBundleForm(event) {
        event.preventDefault();
        clearErrors();

        const form = document.getElementById('bundleEntryForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitSpinner = document.getElementById('submitSpinner');
        const submitIcon = document.getElementById('submitIcon');
        const submitText = document.getElementById('submitBtnText');

        // Prevent duplicate submission
        submitBtn.disabled = true;
        submitSpinner.classList.remove('hidden');
        submitIcon.classList.add('hidden');
        submitText.innerText = 'Saving Bundle...';

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        fetch("{{ route('bundles.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(async response => {
            const result = await response.json();
            if (!response.ok) {
                if (response.status === 422 && result.errors) {
                    Object.keys(result.errors).forEach(key => {
                        const errEl = document.getElementById(`err_${key}`);
                        if (errEl) {
                            errEl.innerText = result.errors[key][0];
                            errEl.classList.remove('hidden');
                        }
                    });
                    showToast('Please correct the validation errors.', 'error');
                } else {
                    showToast(result.message || 'An unexpected error occurred.', 'error');
                }
                return;
            }

            showToast(result.message, 'success');
            setTimeout(() => {
                window.location.href = "{{ route('bundles.index') }}";
            }, 1200);
        })
        .catch(err => {
            showToast('Network error while saving bundle.', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitSpinner.classList.add('hidden');
            submitIcon.classList.remove('hidden');
            submitText.innerText = 'Save Production Bundle';
            lucide.createIcons();
        });
    }

    // Initial calculation on load
    document.addEventListener('DOMContentLoaded', () => {
        calculateRealTimeMetrics();
    });
</script>
@endsection
