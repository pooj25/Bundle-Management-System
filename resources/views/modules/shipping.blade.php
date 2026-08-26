@extends('layouts.app')

@section('title', 'Finished Goods & Shipping')
@section('header_title', 'Packing & Shipping Logistics')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Total Cartons Packed</div>
            <div class="text-2xl font-black text-slate-900 mt-1">1,840 <span class="text-xs font-normal text-slate-500">cartons</span></div>
            <div class="text-xs text-slate-500 mt-1">Barcode verified & poly-bagged</div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Ready for Dispatch</div>
            <div class="text-2xl font-black text-emerald-600 mt-1">38,112 <span class="text-xs font-normal text-slate-500">pcs</span></div>
            <div class="text-xs text-emerald-600 font-semibold mt-1">Final QC Passed</div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Export Containers Booked</div>
            <div class="text-2xl font-black text-blue-600 mt-1">3 Containers</div>
            <div class="text-xs text-slate-500 mt-1">Port of Long Beach & Hamburg</div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Commercial Invoices</div>
            <div class="text-2xl font-black text-slate-900 mt-1">6 Active</div>
            <div class="text-xs text-slate-500 mt-1">Customs Clearance Pending</div>
        </div>
    </div>

    <!-- Ready to Ship Bundles Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Finished Garment Bundles Ready for Export Dispatch</h3>
                <p class="text-xs text-slate-400">100% completed production orders packaged for warehouse transfer</p>
            </div>
            <button onclick="showToast('Export manifest generated successfully', 'success')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm">
                Generate Packing Manifest
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3.5">BUNDLE NO</th>
                        <th class="px-6 py-3.5">BUYER</th>
                        <th class="px-6 py-3.5">STYLE</th>
                        <th class="px-6 py-3.5">COLOR / SIZE</th>
                        <th class="px-6 py-3.5 text-right">PACKED QUANTITY</th>
                        <th class="px-6 py-3.5">CARTON NO</th>
                        <th class="px-6 py-3.5">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($readyShipments as $b)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-3.5 font-mono font-bold text-slate-900">{{ $b->bundle_no }}</td>
                            <td class="px-6 py-3.5 font-bold text-slate-800">{{ $b->buyer->buyer_name ?? 'N/A' }}</td>
                            <td class="px-6 py-3.5 font-medium text-slate-700">{{ $b->style->style_no ?? 'N/A' }}</td>
                            <td class="px-6 py-3.5 text-slate-600">{{ $b->color }} / {{ $b->size }}</td>
                            <td class="px-6 py-3.5 text-right font-bold text-emerald-600">{{ $b->completed_qty }} pcs</td>
                            <td class="px-6 py-3.5 font-mono text-slate-500">CTN-{{ str_pad($b->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-3.5"><span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">READY FOR SHIP</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400">All completed bundles have been processed into packing list.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection