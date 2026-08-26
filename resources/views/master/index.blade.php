@extends('layouts.app')

@section('title', 'Master Data Management')
@section('header_title', 'Master Data Management')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Sub-navigation Tabs matching Mockup 3 -->
    <div class="border-b border-slate-200">
        <nav class="flex space-x-8 text-sm font-medium">
            <button onclick="switchTab('buyers')" id="tab-btn-buyers" class="py-3 px-1 border-b-2 border-blue-600 text-blue-600 font-bold">
                Buyers ({{ $buyers->count() }})
            </button>
            <button onclick="switchTab('styles')" id="tab-btn-styles" class="py-3 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-700">
                Styles ({{ $styles->count() }})
            </button>
            <button onclick="switchTab('lines')" id="tab-btn-lines" class="py-3 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-700">
                Sewing Lines ({{ $lines->count() }})
            </button>
        </nav>
    </div>

    <!-- 1. Buyer Master Tab -->
    <div id="tab-buyers" class="space-y-4">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Buyer Master</h3>
                    <p class="text-xs text-slate-400">Manage apparel buyers, sourcing brands, and points of contact</p>
                </div>
                <button onclick="openNewBuyerModal()" class="px-4 py-2 bg-black hover:bg-slate-800 text-white text-xs font-semibold rounded-lg shadow-sm">
                    New Buyer
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5">BUYER ID</th>
                            <th class="px-6 py-3.5">BUYER NAME</th>
                            <th class="px-6 py-3.5">CONTACT PERSON</th>
                            <th class="px-6 py-3.5">EMAIL</th>
                            <th class="px-6 py-3.5">TOTAL STYLES</th>
                            <th class="px-6 py-3.5">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($buyers as $buyer)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-3.5 font-mono font-bold text-slate-800">B-{{ str_pad($buyer->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-3.5 font-bold text-slate-900">{{ $buyer->buyer_name }}</td>
                                <td class="px-6 py-3.5 text-slate-600">{{ $buyer->contact_person ?? 'N/A' }}</td>
                                <td class="px-6 py-3.5 text-slate-500 font-mono">{{ $buyer->email ?? 'N/A' }}</td>
                                <td class="px-6 py-3.5 font-semibold text-slate-700">{{ $buyer->styles_count ?? 0 }} styles</td>
                                <td class="px-6 py-3.5">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $buyer->status === 'Active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $buyer->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 2. Styles Tab -->
    <div id="tab-styles" class="space-y-4 hidden">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Style Master</h3>
                    <p class="text-xs text-slate-400">Garment style numbers, descriptions, and assigned buyers</p>
                </div>
                <button onclick="openNewStyleModal()" class="px-4 py-2 bg-black hover:bg-slate-800 text-white text-xs font-semibold rounded-lg shadow-sm">
                    New Style
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5">STYLE NO</th>
                            <th class="px-6 py-3.5">BUYER</th>
                            <th class="px-6 py-3.5">DESCRIPTION</th>
                            <th class="px-6 py-3.5">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($styles as $style)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-3.5 font-mono font-bold text-slate-900">{{ $style->style_no }}</td>
                                <td class="px-6 py-3.5 text-slate-700 font-medium">{{ $style->buyer->buyer_name ?? 'N/A' }}</td>
                                <td class="px-6 py-3.5 text-slate-500">{{ $style->description ?? 'N/A' }}</td>
                                <td class="px-6 py-3.5">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        {{ $style->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 3. Sewing Lines Tab -->
    <div id="tab-lines" class="space-y-4 hidden">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Sewing Lines Master</h3>
                    <p class="text-xs text-slate-400">Production lines, floor locations, and daily output capacities</p>
                </div>
                <button onclick="openNewLineModal()" class="px-4 py-2 bg-black hover:bg-slate-800 text-white text-xs font-semibold rounded-lg shadow-sm">
                    New Sewing Line
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5">LINE NAME</th>
                            <th class="px-6 py-3.5">FLOOR</th>
                            <th class="px-6 py-3.5">CAPACITY / DAY</th>
                            <th class="px-6 py-3.5">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($lines as $line)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-3.5 font-mono font-bold text-slate-900">{{ $line->line_name }}</td>
                                <td class="px-6 py-3.5 text-slate-700">{{ $line->floor ?? 'Floor 1' }}</td>
                                <td class="px-6 py-3.5 font-bold text-slate-800">{{ number_format($line->capacity) }} units</td>
                                <td class="px-6 py-3.5">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        {{ $line->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal: New Buyer -->
<div id="newBuyerModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <h3 class="text-sm font-bold text-slate-900">Add New Buyer</h3>
            <button onclick="closeModal('newBuyerModal')" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
        <form onsubmit="submitNewBuyer(event)" class="p-6 space-y-3 text-xs">
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Buyer Name *</label>
                <input type="text" name="buyer_name" required class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Contact Person</label>
                <input type="text" name="contact_person" class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Email</label>
                <input type="email" name="email" class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Status</label>
                <select name="status" class="w-full px-3 py-1.5 border rounded-lg">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <div class="flex justify-end space-x-2 pt-3 border-t">
                <button type="button" onclick="closeModal('newBuyerModal')" class="px-4 py-1.5 bg-slate-200 text-slate-700 font-semibold rounded-lg">Cancel</button>
                <button type="submit" class="px-5 py-1.5 bg-blue-600 text-white font-bold rounded-lg">Save Buyer</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: New Style -->
<div id="newStyleModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <h3 class="text-sm font-bold text-slate-900">Add New Style</h3>
            <button onclick="closeModal('newStyleModal')" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
        <form onsubmit="submitNewStyle(event)" class="p-6 space-y-3 text-xs">
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Buyer *</label>
                <select name="buyer_id" required class="w-full px-3 py-1.5 border rounded-lg">
                    @foreach($buyers as $buyer)
                        <option value="{{ $buyer->id }}">{{ $buyer->buyer_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Style Number *</label>
                <input type="text" name="style_no" required placeholder="e.g. ST-9900" class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Description</label>
                <input type="text" name="description" placeholder="e.g. Vintage Denim Jacket" class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <input type="hidden" name="status" value="Active">
            <div class="flex justify-end space-x-2 pt-3 border-t">
                <button type="button" onclick="closeModal('newStyleModal')" class="px-4 py-1.5 bg-slate-200 text-slate-700 font-semibold rounded-lg">Cancel</button>
                <button type="submit" class="px-5 py-1.5 bg-blue-600 text-white font-bold rounded-lg">Save Style</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: New Line -->
<div id="newLineModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <h3 class="text-sm font-bold text-slate-900">Add New Sewing Line</h3>
            <button onclick="closeModal('newLineModal')" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
        <form onsubmit="submitNewLine(event)" class="p-6 space-y-3 text-xs">
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Line Name *</label>
                <input type="text" name="line_name" required placeholder="e.g. Line-D1" class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Floor Location</label>
                <input type="text" name="floor" placeholder="e.g. Floor 2" class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Daily Capacity (Units) *</label>
                <input type="number" name="capacity" min="1" value="1000" required class="w-full px-3 py-1.5 border rounded-lg">
            </div>
            <input type="hidden" name="status" value="Active">
            <div class="flex justify-end space-x-2 pt-3 border-t">
                <button type="button" onclick="closeModal('newLineModal')" class="px-4 py-1.5 bg-slate-200 text-slate-700 font-semibold rounded-lg">Cancel</button>
                <button type="submit" class="px-5 py-1.5 bg-blue-600 text-white font-bold rounded-lg">Save Line</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchTab(tabName) {
        ['buyers', 'styles', 'lines'].forEach(t => {
            document.getElementById(`tab-${t}`).classList.add('hidden');
            const btn = document.getElementById(`tab-btn-${t}`);
            btn.className = 'py-3 px-1 border-b-2 border-transparent text-slate-500 hover:text-slate-700';
        });

        document.getElementById(`tab-${tabName}`).classList.remove('hidden');
        const activeBtn = document.getElementById(`tab-btn-${tabName}`);
        activeBtn.className = 'py-3 px-1 border-b-2 border-blue-600 text-blue-600 font-bold';
    }

    function openNewBuyerModal() { document.getElementById('newBuyerModal').classList.remove('hidden'); document.getElementById('newBuyerModal').classList.add('flex'); }
    function openNewStyleModal() { document.getElementById('newStyleModal').classList.remove('hidden'); document.getElementById('newStyleModal').classList.add('flex'); }
    function openNewLineModal() { document.getElementById('newLineModal').classList.remove('hidden'); document.getElementById('newLineModal').classList.add('flex'); }
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