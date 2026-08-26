@extends('layouts.app')

@section('title', 'Master Data Management')
@section('header_title', 'Master Data Management')

@section('content')
<div class="max-w-7xl mx-auto space-y-5">

    <!-- Sub Navigation Tabs (Matching Mockup 3: Buyers, Styles, Sewing Lines, Operators, Colors) -->
    <div class="border-b border-slate-200">
        <nav class="flex space-x-8 text-xs font-semibold">
            <button onclick="switchMasterTab('buyers')" id="mtab-buyers" class="py-3 px-1 border-b-2 border-blue-600 text-blue-600 font-bold">
                Buyers
            </button>
            <button onclick="switchMasterTab('styles')" id="mtab-styles" class="py-3 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-800">
                Styles
            </button>
            <button onclick="switchMasterTab('lines')" id="mtab-lines" class="py-3 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-800">
                Sewing Lines
            </button>
            <button onclick="switchMasterTab('operators')" id="mtab-operators" class="py-3 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-800">
                Operators
            </button>
            <button onclick="switchMasterTab('colors')" id="mtab-colors" class="py-3 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-800">
                Colors
            </button>
        </nav>
    </div>

    <!-- 1. Buyer Master View (Matching Mockup 3 Table) -->
    <div id="mview-buyers" class="space-y-4">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Buyer Master</h3>
                </div>
                <button onclick="openModal('newBuyerModal')" class="px-4 py-2 bg-slate-950 hover:bg-slate-800 text-white text-xs font-bold rounded-lg shadow-sm transition">
                    New Buyer
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-white text-slate-400 font-bold uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5">BUYER ID</th>
                            <th class="px-6 py-3.5">BUYER NAME</th>
                            <th class="px-6 py-3.5">CONTACT PERSON</th>
                            <th class="px-6 py-3.5">EMAIL</th>
                            <th class="px-6 py-3.5">STATUS</th>
                            <th class="px-6 py-3.5 text-right">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-mono text-xs">
                        @foreach($buyers as $buyer)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-3.5 font-bold text-slate-800 font-sans">B-{{ str_pad($buyer->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-3.5 font-medium text-slate-900 font-mono">{{ $buyer->buyer_name }}</td>
                                <td class="px-6 py-3.5 text-slate-700 font-mono">{{ $buyer->contact_person ?? 'John Doe' }}</td>
                                <td class="px-6 py-3.5 text-slate-600 font-mono">{{ $buyer->email ?? strtolower(str_replace(' ', '', $buyer->buyer_name)) . '@global.com' }}</td>
                                <td class="px-6 py-3.5 font-sans">
                                    @if($buyer->status === 'Active')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Active</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3.5 text-right font-sans">
                                    <button onclick="showToast('Editing buyer {{ $buyer->buyer_name }}', 'info')" class="text-blue-600 hover:text-blue-800 text-xs font-semibold mr-2">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-3 text-[11px] text-slate-400 border-t border-slate-100">
                Showing 1 to {{ $buyers->count() }} of {{ $buyers->count() }} entries
            </div>
        </div>
    </div>

    <!-- 2. Styles Master View -->
    <div id="mview-styles" class="space-y-4 hidden">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Style Master</h3>
                </div>
                <button onclick="openModal('newStyleModal')" class="px-4 py-2 bg-slate-950 hover:bg-slate-800 text-white text-xs font-bold rounded-lg shadow-sm">
                    New Style
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-white text-slate-400 font-bold uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5">STYLE NO</th>
                            <th class="px-6 py-3.5">BUYER</th>
                            <th class="px-6 py-3.5">DESCRIPTION</th>
                            <th class="px-6 py-3.5">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-mono text-xs">
                        @foreach($styles as $style)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-3.5 font-bold text-slate-900">{{ $style->style_no }}</td>
                                <td class="px-6 py-3.5 text-slate-700 font-sans">{{ $style->buyer->buyer_name ?? 'N/A' }}</td>
                                <td class="px-6 py-3.5 text-slate-500 font-sans">{{ $style->description ?? 'Standard apparel garment style' }}</td>
                                <td class="px-6 py-3.5 font-sans"><span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Active</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 3. Sewing Lines Master View -->
    <div id="mview-lines" class="space-y-4 hidden">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Sewing Lines Master</h3>
                </div>
                <button onclick="openModal('newLineModal')" class="px-4 py-2 bg-slate-950 hover:bg-slate-800 text-white text-xs font-bold rounded-lg shadow-sm">
                    New Line
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-white text-slate-400 font-bold uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5">LINE NAME</th>
                            <th class="px-6 py-3.5">FLOOR</th>
                            <th class="px-6 py-3.5">DAILY CAPACITY</th>
                            <th class="px-6 py-3.5">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-mono text-xs">
                        @foreach($lines as $line)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-3.5 font-bold text-slate-900">{{ $line->line_name }}</td>
                                <td class="px-6 py-3.5 text-slate-700 font-sans">{{ $line->floor ?? 'Floor 1' }}</td>
                                <td class="px-6 py-3.5 font-bold text-slate-800 font-sans">{{ number_format($line->capacity) }} units / shift</td>
                                <td class="px-6 py-3.5 font-sans"><span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Active</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 4. Operators View -->
    <div id="mview-operators" class="space-y-4 hidden">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-sm font-bold text-slate-900 mb-4">Certified Sewing Operators</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg"><strong>John Miller</strong> - Line A1 (Single Needle)</div>
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg"><strong>Robert Chen</strong> - Line A1 (Overlock)</div>
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg"><strong>Maria Gomez</strong> - Line B2 (Flatlock)</div>
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg"><strong>Alex Turner</strong> - Line A2 (Buttonhole)</div>
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg"><strong>Elena Fisher</strong> - Line A2 (Feed-off-arm)</div>
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg"><strong>Sam Wilson</strong> - Line B1 (Bar tack)</div>
            </div>
        </div>
    </div>

    <!-- 5. Colors View -->
    <div id="mview-colors" class="space-y-4 hidden">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-sm font-bold text-slate-900 mb-4">Master Color Shades & Pantones</h3>
            <div class="flex flex-wrap gap-2 text-xs">
                <span class="px-3 py-1.5 rounded-lg bg-slate-900 text-white font-medium">Navy (#1e293b)</span>
                <span class="px-3 py-1.5 rounded-lg bg-black text-white font-medium">Black (#000000)</span>
                <span class="px-3 py-1.5 rounded-lg bg-white border border-slate-300 text-slate-800 font-medium">White (#ffffff)</span>
                <span class="px-3 py-1.5 rounded-lg bg-emerald-800 text-white font-medium">Olive (#2e4a28)</span>
                <span class="px-3 py-1.5 rounded-lg bg-slate-600 text-white font-medium">Charcoal (#475569)</span>
                <span class="px-3 py-1.5 rounded-lg bg-sky-500 text-white font-medium">Sky Blue (#0ea5e9)</span>
                <span class="px-3 py-1.5 rounded-lg bg-rose-900 text-white font-medium">Burgundy (#881337)</span>
            </div>
        </div>
    </div>

</div>

<!-- Modal: New Buyer -->
<div id="newBuyerModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden border border-slate-200">
        <div class="px-5 py-3.5 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <h3 class="text-xs font-bold text-slate-900 uppercase">Add New Buyer</h3>
            <button onclick="closeModal('newBuyerModal')" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
        <form onsubmit="submitNewBuyer(event)" class="p-5 space-y-3 text-xs">
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Buyer Name *</label>
                <input type="text" name="buyer_name" required placeholder="e.g. Target Sourcing" class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Contact Person</label>
                <input type="text" name="contact_person" placeholder="e.g. Jane Foster" class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Email</label>
                <input type="email" name="email" placeholder="e.g. jane@target.com" class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <input type="hidden" name="status" value="Active">
            <div class="flex justify-end space-x-2 pt-3 border-t">
                <button type="button" onclick="closeModal('newBuyerModal')" class="px-3.5 py-1.5 bg-slate-200 text-slate-700 font-semibold rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-1.5 bg-slate-900 text-white font-bold rounded-lg">Save Buyer</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: New Style -->
<div id="newStyleModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden border border-slate-200">
        <div class="px-5 py-3.5 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <h3 class="text-xs font-bold text-slate-900 uppercase">Add New Style</h3>
            <button onclick="closeModal('newStyleModal')" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
        <form onsubmit="submitNewStyle(event)" class="p-5 space-y-3 text-xs">
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Buyer *</label>
                <select name="buyer_id" required class="w-full px-3 py-1.5 border rounded-lg">
                    @foreach($buyers as $b)
                        <option value="{{ $b->id }}">{{ $b->buyer_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Style Number *</label>
                <input type="text" name="style_no" required placeholder="e.g. ST-7700" class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Description</label>
                <input type="text" name="description" placeholder="e.g. Organic Cotton Tee" class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <input type="hidden" name="status" value="Active">
            <div class="flex justify-end space-x-2 pt-3 border-t">
                <button type="button" onclick="closeModal('newStyleModal')" class="px-3.5 py-1.5 bg-slate-200 text-slate-700 font-semibold rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-1.5 bg-slate-900 text-white font-bold rounded-lg">Save Style</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: New Line -->
<div id="newLineModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden border border-slate-200">
        <div class="px-5 py-3.5 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <h3 class="text-xs font-bold text-slate-900 uppercase">Add Sewing Line</h3>
            <button onclick="closeModal('newLineModal')" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
        <form onsubmit="submitNewLine(event)" class="p-5 space-y-3 text-xs">
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Line Name *</label>
                <input type="text" name="line_name" required placeholder="e.g. Line D1" class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Daily Capacity *</label>
                <input type="number" name="capacity" min="1" value="1200" required class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <input type="hidden" name="status" value="Active">
            <div class="flex justify-end space-x-2 pt-3 border-t">
                <button type="button" onclick="closeModal('newLineModal')" class="px-3.5 py-1.5 bg-slate-200 text-slate-700 font-semibold rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-1.5 bg-slate-900 text-white font-bold rounded-lg">Save Line</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchMasterTab(tabName) {
        ['buyers', 'styles', 'lines', 'operators', 'colors'].forEach(t => {
            const el = document.getElementById(`mview-${t}`);
            const btn = document.getElementById(`mtab-${t}`);
            if (el) el.classList.add('hidden');
            if (btn) btn.className = 'py-3 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-800';
        });

        const activeEl = document.getElementById(`mview-${tabName}`);
        const activeBtn = document.getElementById(`mtab-${tabName}`);
        if (activeEl) activeEl.classList.remove('hidden');
        if (activeBtn) activeBtn.className = 'py-3 px-1 border-b-2 border-blue-600 text-blue-600 font-bold';
    }

    function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.getElementById(id).classList.add('flex'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); document.getElementById(id).classList.remove('flex'); }

    function submitNewBuyer(e) {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(e.target).entries());
        fetch("{{ route('master.buyers.store') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: JSON.stringify(data)
        }).then(r => r.json()).then(res => {
            if(res.success) { showToast(res.message); setTimeout(() => location.reload(), 700); }
        });
    }

    function submitNewStyle(e) {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(e.target).entries());
        fetch("{{ route('master.styles.store') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: JSON.stringify(data)
        }).then(r => r.json()).then(res => {
            if(res.success) { showToast(res.message); setTimeout(() => location.reload(), 700); }
        });
    }

    function submitNewLine(e) {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(e.target).entries());
        fetch("{{ route('master.lines.store') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: JSON.stringify(data)
        }).then(r => r.json()).then(res => {
            if(res.success) { showToast(res.message); setTimeout(() => location.reload(), 700); }
        });
    }
</script>
@endsection