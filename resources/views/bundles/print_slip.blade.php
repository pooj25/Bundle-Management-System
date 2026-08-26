<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Bundle Slip - {{ $bundle->bundle_no }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background: white; -webkit-print-color-adjust: exact; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-slate-100 p-6 flex flex-col items-center justify-center min-h-screen text-slate-900">

    <!-- Action Bar -->
    <div class="w-full max-w-lg mb-4 flex items-center justify-between no-print">
        <button onclick="window.close()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-xs font-bold rounded-lg">Close</button>
        <button onclick="window.print()" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow flex items-center space-x-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Print Slip</span>
        </button>
    </div>

    <!-- Production Bundle Slip Ticket -->
    <div class="w-full max-w-lg bg-white border-2 border-dashed border-slate-400 p-6 rounded-xl shadow-lg relative">
        
        <!-- Header -->
        <div class="text-center border-b-2 border-slate-900 pb-3 mb-4">
            <div class="text-lg font-black tracking-wider uppercase">ApparelERP Manufacturing</div>
            <div class="text-xs font-semibold text-slate-500 uppercase tracking-widest">Garment Production Bundle Traveler</div>
        </div>

        <!-- Barcode / QR Box -->
        <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 text-center mb-4">
            <div class="font-mono text-2xl font-black tracking-widest text-slate-900">{{ $bundle->bundle_no }}</div>
            <div class="flex justify-center my-1.5">
                <!-- Barcode visual simulation -->
                <div class="h-10 flex items-center space-x-0.5 px-4 bg-white border border-slate-300 rounded">
                    <span class="w-1 h-8 bg-black inline-block"></span>
                    <span class="w-0.5 h-8 bg-black inline-block"></span>
                    <span class="w-2 h-8 bg-black inline-block"></span>
                    <span class="w-1.5 h-8 bg-black inline-block"></span>
                    <span class="w-0.5 h-8 bg-black inline-block"></span>
                    <span class="w-2 h-8 bg-black inline-block"></span>
                    <span class="w-1 h-8 bg-black inline-block"></span>
                    <span class="w-0.5 h-8 bg-black inline-block"></span>
                    <span class="w-1.5 h-8 bg-black inline-block"></span>
                    <span class="w-2.5 h-8 bg-black inline-block"></span>
                    <span class="w-0.5 h-8 bg-black inline-block"></span>
                    <span class="w-1.5 h-8 bg-black inline-block"></span>
                    <span class="w-2 h-8 bg-black inline-block"></span>
                    <span class="w-1 h-8 bg-black inline-block"></span>
                    <span class="w-0.5 h-8 bg-black inline-block"></span>
                    <span class="w-2 h-8 bg-black inline-block"></span>
                </div>
            </div>
            <div class="text-[10px] text-slate-400 font-mono">ID: {{ str_pad($bundle->id, 8, '0', STR_PAD_LEFT) }} | ROUTING TICKET</div>
        </div>

        <!-- Grid Attributes -->
        <div class="grid grid-cols-2 gap-3 text-xs mb-4">
            <div class="border-b border-slate-200 pb-1">
                <span class="text-slate-500 font-medium">Buyer:</span>
                <div class="font-bold text-slate-900 text-sm">{{ $bundle->buyer->buyer_name ?? 'N/A' }}</div>
            </div>
            <div class="border-b border-slate-200 pb-1">
                <span class="text-slate-500 font-medium">Style No:</span>
                <div class="font-bold text-slate-900 text-sm">{{ $bundle->style->style_no ?? 'N/A' }}</div>
            </div>
            <div class="border-b border-slate-200 pb-1">
                <span class="text-slate-500 font-medium">Color:</span>
                <div class="font-bold text-slate-900">{{ $bundle->color }}</div>
            </div>
            <div class="border-b border-slate-200 pb-1">
                <span class="text-slate-500 font-medium">Size:</span>
                <div class="font-bold text-slate-900">{{ $bundle->size }}</div>
            </div>
            <div class="border-b border-slate-200 pb-1">
                <span class="text-slate-500 font-medium">Sewing Line:</span>
                <div class="font-bold text-slate-900">{{ $bundle->sewingLine->line_name ?? 'N/A' }}</div>
            </div>
            <div class="border-b border-slate-200 pb-1">
                <span class="text-slate-500 font-medium">Production Date:</span>
                <div class="font-bold text-slate-900">{{ $bundle->production_date }}</div>
            </div>
        </div>

        <!-- Quantity Summary Table -->
        <div class="border border-slate-900 rounded-lg overflow-hidden mb-4">
            <div class="grid grid-cols-4 bg-slate-900 text-white text-[11px] font-bold text-center py-1.5 uppercase">
                <div>Bundle Qty</div>
                <div>Completed</div>
                <div>Rejected</div>
                <div>Balance</div>
            </div>
            <div class="grid grid-cols-4 text-center py-2 font-black text-sm text-slate-900 bg-slate-50">
                <div>{{ $bundle->quantity }}</div>
                <div class="text-emerald-700">{{ $bundle->completed_qty }}</div>
                <div class="text-rose-700">{{ $bundle->rejected_qty }}</div>
                <div class="text-blue-700">{{ $bundle->balance_qty }}</div>
            </div>
        </div>

        @if($bundle->remarks)
            <div class="text-xs bg-yellow-50 p-2 rounded border border-yellow-200 text-yellow-900 mb-4">
                <strong>Remarks:</strong> {{ $bundle->remarks }}
            </div>
        @endif

        <!-- Sign-off Section -->
        <div class="grid grid-cols-2 gap-6 pt-4 border-t-2 border-slate-900 text-xs">
            <div>
                <div class="text-slate-500 mb-6">Operator Signature:</div>
                <div class="border-b border-slate-400"></div>
                <div class="text-[10px] text-slate-400 mt-1">{{ $bundle->operator_name ?: 'Operator' }}</div>
            </div>
            <div>
                <div class="text-slate-500 mb-6">QC Supervisor Sign-off:</div>
                <div class="border-b border-slate-400"></div>
                <div class="text-[10px] text-slate-400 mt-1">Authorized Inspection Stamp</div>
            </div>
        </div>

    </div>

</body>
</html>