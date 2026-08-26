@extends('layouts.app')

@section('title', 'Bundle Listing')
@section('header_title', 'Bundle Management')

@section('content')
<div class="max-w-7xl mx-auto space-y-5">

    <!-- Listing Container Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col min-h-[680px]">

        <!-- Top Header & Action Row -->
        <div class="px-6 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-3 bg-white">
            <div>
                <h2 class="text-base font-bold text-slate-900 tracking-tight">Bundle Listing</h2>
            </div>
            <div class="flex items-center space-x-2.5">
                <a href="{{ route('bundles.export', request()->all()) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition flex items-center space-x-1.5 border border-slate-200">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    <span>Export CSV</span>
                </a>
                <button type="button" onclick="toggleAdvancedFilters()" class="px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition flex items-center space-x-1.5 border border-slate-300">
                    <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5"></i>
                    <span>Advanced Filters</span>
                </button>
                <a href="{{ route('bundles.create') }}" class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm transition flex items-center space-x-1.5">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    <span>New Bundle</span>
                </a>
            </div>
        </div>

        <!-- Filter Bar Row -->
        <form id="filterForm" method="GET" action="{{ route('bundles.index') }}" class="p-4 bg-slate-50/70 border-b border-slate-200">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- 1. Buyer Dropdown -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">BUYER</label>
                    <select name="buyer_id" onchange="this.form.submit()" class="w-full px-3 py-1.5 text-xs bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 text-slate-800">
                        <option value="">All Buyers</option>
                        @foreach($buyers as $buyer)
                            <option value="{{ $buyer->id }}" {{ request('buyer_id') == $buyer->id ? 'selected' : '' }}>
                                {{ $buyer->buyer_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 2. Style Input -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">STYLE</label>
                    <input type="text" name="style_no" value="{{ request('style_no') }}" placeholder="Enter Style No." class="w-full px-3 py-1.5 text-xs bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 text-slate-800" onkeyup="if(event.key==='Enter') this.form.submit()">
                </div>

                <!-- 3. Sewing Line Dropdown -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">SEWING LINE</label>
                    <select name="line_id" onchange="this.form.submit()" class="w-full px-3 py-1.5 text-xs bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 text-slate-800">
                        <option value="">All Lines</option>
                        @foreach($lines as $line)
                            <option value="{{ $line->id }}" {{ request('line_id') == $line->id ? 'selected' : '' }}>
                                {{ $line->line_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 4. Date Range -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">DATE RANGE</label>
                    <div class="flex items-center space-x-1">
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-1/2 px-2 py-1.5 text-xs bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 text-slate-800" onchange="this.form.submit()">
                        <span class="text-slate-400 text-xs">-</span>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-1/2 px-2 py-1.5 text-xs bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 text-slate-800" onchange="this.form.submit()">
                    </div>
                </div>
            </div>

            <!-- Advanced Filters Row -->
            <div id="advancedFilterRow" class="{{ request('search') || request('operator') || request('color') ? 'grid' : 'hidden' }} grid-cols-1 sm:grid-cols-3 gap-3 mt-3 pt-3 border-t border-slate-200">
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Search Keywords</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Bundle No, Operator..." class="w-full px-3 py-1.5 text-xs bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Color</label>
                    <input type="text" name="color" value="{{ request('color') }}" placeholder="e.g. Navy" class="w-full px-3 py-1.5 text-xs bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="px-4 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-lg hover:bg-blue-700">Apply Filters</button>
                    <a href="{{ route('bundles.index') }}" class="px-3 py-1.5 bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-300">Reset</a>
                </div>
            </div>

            <input type="hidden" name="sort_by" id="input_sort_by" value="{{ request('sort_by', 'created_at') }}">
            <input type="hidden" name="sort_dir" id="input_sort_dir" value="{{ request('sort_dir', 'desc') }}">
            <input type="hidden" name="per_page" id="input_per_page" value="{{ request('per_page', 20) }}">
        </form>

        <!-- Main Bundles Data Table -->
        <div class="flex-1 overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-white border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider select-none">
                    <tr>
                        <th onclick="sortByColumn('bundle_no')" class="px-4 py-3 cursor-pointer hover:bg-slate-50 transition">
                            <div class="flex items-center space-x-1">
                                <span>BUNDLE NO</span>
                                <i data-lucide="arrow-up-down" class="w-3 h-3 text-slate-400"></i>
                            </div>
                        </th>
                        <th onclick="sortByColumn('buyer')" class="px-4 py-3 cursor-pointer hover:bg-slate-50 transition">
                            <div class="flex items-center space-x-1">
                                <span>BUYER</span>
                                <i data-lucide="arrow-up-down" class="w-3 h-3 text-slate-400"></i>
                            </div>
                        </th>
                        <th onclick="sortByColumn('style')" class="px-4 py-3 cursor-pointer hover:bg-slate-50 transition">
                            <div class="flex items-center space-x-1">
                                <span>STYLE</span>
                                <i data-lucide="arrow-up-down" class="w-3 h-3 text-slate-400"></i>
                            </div>
                        </th>
                        <th class="px-4 py-3">COLOR / SIZE</th>
                        <th class="px-3 py-3">LINE</th>
                        <th onclick="sortByColumn('quantity')" class="px-3 py-3 cursor-pointer hover:bg-slate-50 transition text-right">
                            <div class="flex items-center justify-end space-x-1">
                                <span>QTY</span>
                                <i data-lucide="arrow-up-down" class="w-3 h-3 text-slate-400"></i>
                            </div>
                        </th>
                        <th class="px-3 py-3 text-right">DONE</th>
                        <th class="px-3 py-3 text-right">REJ</th>
                        <th class="px-3 py-3 text-right">BAL</th>
                        <th onclick="sortByColumn('efficiency')" class="px-3 py-3 cursor-pointer hover:bg-slate-50 transition text-center">
                            <div class="flex items-center justify-center space-x-1">
                                <span>EFF %</span>
                                <i data-lucide="arrow-up-down" class="w-3 h-3 text-slate-400"></i>
                            </div>
                        </th>
                        <th class="px-3 py-3 text-center">REJ %</th>
                        <th class="px-4 py-3 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($bundles as $bundle)
                        <tr class="hover:bg-slate-50/80 transition group" id="bundle_row_{{ $bundle->id }}">
                            <!-- Bundle No -->
                            <td class="px-4 py-3 font-mono font-bold text-slate-900">
                                <button onclick="viewBundleDetails({{ $bundle->id }})" class="hover:text-blue-600 transition">
                                    {{ $bundle->bundle_no }}
                                </button>
                            </td>

                            <!-- Buyer -->
                            <td class="px-4 py-3 text-slate-700 font-medium">
                                {{ $bundle->buyer->buyer_name ?? 'N/A' }}
                            </td>

                            <!-- Style -->
                            <td class="px-4 py-3 text-slate-600 font-medium">
                                {{ $bundle->style->style_no ?? 'N/A' }}
                            </td>

                            <!-- Color / Size -->
                            <td class="px-4 py-3 text-slate-600 font-medium">
                                {{ $bundle->color }} / {{ $bundle->size }}
                            </td>

                            <!-- Line -->
                            <td class="px-3 py-3">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-mono text-[11px] font-semibold">
                                    {{ $bundle->sewingLine->line_name ?? 'N/A' }}
                                </span>
                            </td>

                            <!-- QTY -->
                            <td class="px-3 py-3 text-right font-bold text-slate-900">
                                {{ $bundle->quantity }}
                            </td>

                            <!-- DONE -->
                            <td class="px-3 py-3 text-right font-semibold text-emerald-600">
                                {{ $bundle->completed_qty }}
                            </td>

                            <!-- REJ -->
                            <td class="px-3 py-3 text-right font-semibold text-rose-500">
                                {{ $bundle->rejected_qty }}
                            </td>

                            <!-- BAL -->
                            <td class="px-3 py-3 text-right font-bold text-slate-700">
                                {{ $bundle->balance_qty }}
                            </td>

                            <!-- EFF % -->
                            <td class="px-3 py-3 text-center">
                                @if($bundle->efficiency_percentage >= 90)
                                    <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        {{ $bundle->efficiency_percentage }}%
                                    </span>
                                @elseif($bundle->efficiency_percentage >= 50)
                                    <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-bold bg-amber-100 text-amber-800">
                                        {{ $bundle->efficiency_percentage }}%
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-600">
                                        {{ $bundle->efficiency_percentage }}%
                                    </span>
                                @endif
                            </td>

                            <!-- REJ % -->
                            <td class="px-3 py-3 text-center font-medium {{ $bundle->rejection_percentage > 5 ? 'text-rose-600 font-bold' : 'text-slate-600' }}">
                                {{ $bundle->rejection_percentage }}%
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end space-x-1.5">
                                    <!-- Print Slip -->
                                    <a href="{{ route('bundles.print', $bundle->id) }}" target="_blank" title="Print Bundle Slip" class="p-1 text-slate-400 hover:text-blue-600 hover:bg-slate-100 rounded transition">
                                        <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                                    </a>
                                    <!-- View Details -->
                                    <button onclick="viewBundleDetails({{ $bundle->id }})" title="View Details" class="p-1 text-slate-400 hover:text-blue-600 hover:bg-slate-100 rounded transition">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    </button>
                                    <!-- Edit Modal -->
                                    <button onclick="openEditModal({{ $bundle->id }})" title="Edit Bundle" class="p-1 text-slate-400 hover:text-emerald-600 hover:bg-slate-100 rounded transition">
                                        <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                    <!-- Soft Delete -->
                                    <button onclick="confirmDelete({{ $bundle->id }}, '{{ $bundle->bundle_no }}')" title="Delete Bundle" class="p-1 text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded transition">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="px-6 py-12 text-center text-slate-400">
                                <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-slate-300"></i>
                                <div class="font-semibold text-slate-600">No production bundles found</div>
                                <div class="text-xs text-slate-400 mt-1">Try adjusting your filters or create a new bundle.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Pagination Bar -->
        <div class="px-6 py-3.5 border-t border-slate-200 bg-white flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-600">
            <div class="flex items-center space-x-2">
                <span>Rows per page:</span>
                <select onchange="changePerPage(this.value)" class="px-2 py-1 bg-slate-50 border border-slate-300 rounded font-semibold text-slate-700">
                    <option value="20" {{ $bundles->perPage() == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $bundles->perPage() == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $bundles->perPage() == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>

            <div class="flex items-center space-x-4">
                <span>
                    @if($bundles->total() > 0)
                        {{ $bundles->firstItem() }}-{{ $bundles->lastItem() }} of {{ number_format($bundles->total()) }}
                    @else
                        0 of 0
                    @endif
                </span>

                <div class="flex items-center space-x-1">
                    <!-- Previous Page -->
                    <a href="{{ $bundles->previousPageUrl() ?: '#' }}" class="p-1 rounded border border-slate-300 {{ $bundles->onFirstPage() ? 'opacity-40 pointer-events-none' : 'hover:bg-slate-100 text-slate-700' }}">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </a>
                    <!-- Next Page -->
                    <a href="{{ $bundles->nextPageUrl() ?: '#' }}" class="p-1 rounded border border-slate-300 {{ !$bundles->hasMorePages() ? 'opacity-40 pointer-events-none' : 'hover:bg-slate-100 text-slate-700' }}">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- View Bundle Details Modal -->
<div id="viewDetailsModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-xl overflow-hidden border border-slate-200 transform transition-all">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <div class="flex items-center space-x-2">
                <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                <h3 class="text-base font-bold text-slate-900" id="modalBundleNo">Bundle Details</h3>
            </div>
            <button onclick="closeViewModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-200">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-6 space-y-4 text-xs" id="modalBundleContent">
            <!-- Dynamic Content -->
        </div>
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex justify-between">
            <a id="modalPrintSlipBtn" href="#" target="_blank" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg flex items-center space-x-1.5">
                <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                <span>Print Bundle Slip</span>
            </a>
            <button onclick="closeViewModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-lg">Close</button>
        </div>
    </div>
</div>

<!-- Edit Bundle Modal with Real-Time Calculations -->
<div id="editBundleModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-200 transform transition-all">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <div class="flex items-center space-x-2">
                <i data-lucide="edit" class="w-5 h-5 text-emerald-600"></i>
                <h3 class="text-base font-bold text-slate-900">Edit Production Bundle</h3>
            </div>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-200">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="editBundleForm" onsubmit="submitEditBundle(event)" class="p-6 space-y-4 text-xs">
            <input type="hidden" id="edit_id" name="id">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Bundle No</label>
                    <input type="text" id="edit_bundle_no" name="bundle_no" required class="w-full px-3 py-1.5 border rounded-lg font-mono font-bold bg-slate-50">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Production Date</label>
                    <input type="date" id="edit_production_date" name="production_date" required max="{{ date('Y-m-d') }}" class="w-full px-3 py-1.5 border rounded-lg">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Buyer</label>
                    <select id="edit_buyer_id" name="buyer_id" required class="w-full px-3 py-1.5 border rounded-lg">
                        @foreach($buyers as $buyer)
                            <option value="{{ $buyer->id }}">{{ $buyer->buyer_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Sewing Line</label>
                    <select id="edit_line_id" name="line_id" required class="w-full px-3 py-1.5 border rounded-lg">
                        @foreach($lines as $line)
                            <option value="{{ $line->id }}">{{ $line->line_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Color</label>
                    <input type="text" id="edit_color" name="color" required class="w-full px-3 py-1.5 border rounded-lg">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Size</label>
                    <input type="text" id="edit_size" name="size" required class="w-full px-3 py-1.5 border rounded-lg">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Operator</label>
                    <input type="text" id="edit_operator_name" name="operator_name" class="w-full px-3 py-1.5 border rounded-lg">
                </div>
            </div>

            <div class="p-3 bg-blue-50/60 rounded-lg border border-blue-100 space-y-2">
                <div class="font-bold text-blue-900 uppercase">Quantities & Real-Time Balance</div>
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700">Total Qty</label>
                        <input type="number" id="edit_quantity" name="quantity" min="1" required oninput="calcEditMetrics()" class="w-full px-2.5 py-1 font-bold border rounded">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700">Completed Qty</label>
                        <input type="number" id="edit_completed_qty" name="completed_qty" min="0" required oninput="calcEditMetrics()" class="w-full px-2.5 py-1 font-bold border rounded text-emerald-600">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700">Rejected Qty</label>
                        <input type="number" id="edit_rejected_qty" name="rejected_qty" min="0" required oninput="calcEditMetrics()" class="w-full px-2.5 py-1 font-bold border rounded text-rose-600">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1 border-t border-blue-200">
                    <div>Balance: <strong id="edit_calc_balance" class="text-blue-700">0</strong></div>
                    <div>Efficiency: <strong id="edit_calc_eff" class="text-emerald-700">0%</strong></div>
                    <div>Rejection: <strong id="edit_calc_rej" class="text-rose-700">0%</strong></div>
                </div>
            </div>

            <input type="hidden" id="edit_style_id" name="style_id">

            <div class="flex justify-end space-x-2 pt-2 border-t">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-lg">Cancel</button>
                <button type="submit" id="editSubmitBtn" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg shadow-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleAdvancedFilters() {
        const row = document.getElementById('advancedFilterRow');
        row.classList.toggle('hidden');
        row.classList.toggle('grid');
    }

    function sortByColumn(col) {
        const inputCol = document.getElementById('input_sort_by');
        const inputDir = document.getElementById('input_sort_dir');

        if (inputCol.value === col) {
            inputDir.value = inputDir.value === 'asc' ? 'desc' : 'asc';
        } else {
            inputCol.value = col;
            inputDir.value = 'asc';
        }
        document.getElementById('filterForm').submit();
    }

    function changePerPage(val) {
        document.getElementById('input_per_page').value = val;
        document.getElementById('filterForm').submit();
    }

    // View Details Modal
    function viewBundleDetails(id) {
        const modal = document.getElementById('viewDetailsModal');
        const content = document.getElementById('modalBundleContent');
        const printBtn = document.getElementById('modalPrintSlipBtn');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        content.innerHTML = `<div class="text-center py-6"><i data-lucide="loader-2" class="w-6 h-6 animate-spin mx-auto text-blue-600 mb-2"></i>Loading details...</div>`;
        lucide.createIcons();

        fetch(`/bundles/${id}`)
            .then(r => r.json())
            .then(res => {
                const b = res.data;
                document.getElementById('modalBundleNo').innerText = `Bundle: ${b.bundle_no}`;
                printBtn.href = `/bundles/${b.id}/print`;

                content.innerHTML = `
                    <div class="grid grid-cols-2 gap-3 bg-slate-50 p-3 rounded-lg border border-slate-200">
                        <div><span class="text-slate-400">Buyer:</span> <strong class="text-slate-800">${b.buyer ? b.buyer.buyer_name : 'N/A'}</strong></div>
                        <div><span class="text-slate-400">Style:</span> <strong class="text-slate-800">${b.style ? b.style.style_no : 'N/A'}</strong></div>
                        <div><span class="text-slate-400">Color / Size:</span> <strong class="text-slate-800">${b.color} / ${b.size}</strong></div>
                        <div><span class="text-slate-400">Line:</span> <strong class="text-slate-800">${b.sewing_line ? b.sewing_line.line_name : 'N/A'}</strong></div>
                        <div><span class="text-slate-400">Date:</span> <strong class="text-slate-800">${b.production_date}</strong></div>
                        <div><span class="text-slate-400">Operator:</span> <strong class="text-slate-800">${b.operator_name || 'N/A'}</strong></div>
                    </div>

                    <div class="grid grid-cols-4 gap-2 text-center p-3 bg-blue-50 rounded-lg border border-blue-100">
                        <div><div class="text-[10px] text-slate-500">TOTAL</div><div class="text-base font-bold text-slate-900">${b.quantity}</div></div>
                        <div><div class="text-[10px] text-slate-500">COMPLETED</div><div class="text-base font-bold text-emerald-600">${b.completed_qty}</div></div>
                        <div><div class="text-[10px] text-slate-500">REJECTED</div><div class="text-base font-bold text-rose-600">${b.rejected_qty}</div></div>
                        <div><div class="text-[10px] text-slate-500">BALANCE</div><div class="text-base font-bold text-blue-600">${b.balance_qty}</div></div>
                    </div>

                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-lg border border-slate-200">
                        <div>Efficiency: <strong class="text-emerald-700">${b.efficiency_percentage}%</strong></div>
                        <div>Rejection Rate: <strong class="text-rose-700">${b.rejection_percentage}%</strong></div>
                        <div>Status: <span class="px-2 py-0.5 rounded font-bold text-[10px] ${b.status_label === 'PASSED' ? 'bg-emerald-100 text-emerald-800' : (b.status_label === 'REJECTED' ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800')}">${b.status_label}</span></div>
                    </div>

                    ${b.remarks ? `<div class="p-2.5 bg-yellow-50 text-yellow-900 rounded border border-yellow-200"><strong>Remarks:</strong> ${b.remarks}</div>` : ''}
                `;
                lucide.createIcons();
            });
    }

    function closeViewModal() {
        const modal = document.getElementById('viewDetailsModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Edit Modal
    function openEditModal(id) {
        const modal = document.getElementById('editBundleModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        fetch(`/bundles/${id}/edit`)
            .then(r => r.json())
            .then(res => {
                const b = res.data;
                document.getElementById('edit_id').value = b.id;
                document.getElementById('edit_bundle_no').value = b.bundle_no;
                document.getElementById('edit_production_date').value = b.production_date;
                document.getElementById('edit_buyer_id').value = b.buyer_id;
                document.getElementById('edit_style_id').value = b.style_id;
                document.getElementById('edit_line_id').value = b.line_id;
                document.getElementById('edit_color').value = b.color;
                document.getElementById('edit_size').value = b.size;
                document.getElementById('edit_operator_name').value = b.operator_name || '';
                document.getElementById('edit_quantity').value = b.quantity;
                document.getElementById('edit_completed_qty').value = b.completed_qty;
                document.getElementById('edit_rejected_qty').value = b.rejected_qty;

                calcEditMetrics();
            });
    }

    function closeEditModal() {
        const modal = document.getElementById('editBundleModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function calcEditMetrics() {
        const qty = Math.max(0, parseInt(document.getElementById('edit_quantity').value) || 0);
        const comp = Math.max(0, parseInt(document.getElementById('edit_completed_qty').value) || 0);
        const rej = Math.max(0, parseInt(document.getElementById('edit_rejected_qty').value) || 0);

        const bal = Math.max(0, qty - comp - rej);
        const eff = qty > 0 ? ((comp / qty) * 100).toFixed(1) : 0.0;
        const rejPct = qty > 0 ? ((rej / qty) * 100).toFixed(1) : 0.0;

        document.getElementById('edit_calc_balance').innerText = bal;
        document.getElementById('edit_calc_eff').innerText = `${eff}%`;
        document.getElementById('edit_calc_rej').innerText = `${rejPct}%`;
    }

    function submitEditBundle(event) {
        event.preventDefault();
        const id = document.getElementById('edit_id').value;
        const form = document.getElementById('editBundleForm');
        const data = Object.fromEntries(new FormData(form).entries());

        fetch(`/bundles/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(async r => {
            const res = await r.json();
            if (!r.ok) {
                showToast(res.message || 'Validation error while updating.', 'error');
                return;
            }
            showToast(res.message, 'success');
            closeEditModal();
            setTimeout(() => window.location.reload(), 800);
        })
        .catch(() => showToast('Failed to update bundle', 'error'));
    }

    // Soft Delete
    function confirmDelete(id, bundleNo) {
        if (!confirm(`Are you sure you want to delete bundle ${bundleNo}? You can restore it anytime.`)) {
            return;
        }

        fetch(`/bundles/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                showToast(res.message, 'success');
                const row = document.getElementById(`bundle_row_${id}`);
                if (row) {
                    row.classList.add('bg-rose-50', 'opacity-40');
                    setTimeout(() => row.remove(), 600);
                }
            } else {
                showToast('Failed to delete bundle', 'error');
            }
        });
    }
</script>
@endsection