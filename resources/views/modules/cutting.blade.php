@extends('layouts.app')

@section('title', 'Fabric Cutting & Lay Plan')
@section('header_title', 'Cutting Room Orders')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Total Cut Pieces Today</div>
            <div class="text-2xl font-black text-slate-900 mt-1">12,450 <span class="text-xs font-normal text-slate-500">pcs</span></div>
            <div class="text-xs text-emerald-600 font-semibold mt-1">Across 8 Cutting Tables</div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Average Marker Efficiency</div>
            <div class="text-2xl font-black text-blue-600 mt-1">87.4%</div>
            <div class="text-xs text-slate-500 mt-1">Minimal fabric wastage</div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Bundles Prepared for Sewing</div>
            <div class="text-2xl font-black text-emerald-600 mt-1">68 Bundles</div>
            <div class="text-xs text-slate-500 mt-1">Barcoded & Dispatched to Line</div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Active Cutting Orders</div>
            <div class="text-2xl font-black text-slate-900 mt-1">14 Orders</div>
            <div class="text-xs text-slate-500 mt-1">In progress on floor</div>
        </div>
    </div>

    <!-- Cutting Orders Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Cutting Room Orders & Lay Schedule</h3>
                <p class="text-xs text-slate-400">Fabric spread lengths, plies count, and bundle generation status</p>
            </div>
            <a href="{{ route('bundles.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm flex items-center space-x-1.5">
                <i data-lucide="scissors" class="w-3.5 h-3.5"></i>
                <span>+ Create Bundle from Cut Lay</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3.5">CUT ORDER #</th>
                        <th class="px-6 py-3.5">STYLE NO</th>
                        <th class="px-6 py-3.5">BUYER</th>
                        <th class="px-6 py-3.5">TABLE / SPREAD</th>
                        <th class="px-6 py-3.5">PLIES (LAYERS)</th>
                        <th class="px-6 py-3.5">TOTAL CUT PCS</th>
                        <th class="px-6 py-3.5">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-3.5 font-mono font-bold text-slate-900">CUT-2026-101</td>
                        <td class="px-6 py-3.5 font-bold text-slate-800">ST-8821</td>
                        <td class="px-6 py-3.5 text-slate-600">Global Retail</td>
                        <td class="px-6 py-3.5 font-medium">Table #1 (12.5 meters)</td>
                        <td class="px-6 py-3.5 font-semibold">120 Plies</td>
                        <td class="px-6 py-3.5 font-bold text-slate-900">2,400 pcs (12 Bundles)</td>
                        <td class="px-6 py-3.5"><span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">BUNDLED & SENT</span></td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-3.5 font-mono font-bold text-slate-900">CUT-2026-102</td>
                        <td class="px-6 py-3.5 font-bold text-slate-800">UO-22X</td>
                        <td class="px-6 py-3.5 text-slate-600">Urban Out</td>
                        <td class="px-6 py-3.5 font-medium">Table #3 (9.8 meters)</td>
                        <td class="px-6 py-3.5 font-semibold">80 Plies</td>
                        <td class="px-6 py-3.5 font-bold text-slate-900">1,200 pcs (6 Bundles)</td>
                        <td class="px-6 py-3.5"><span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">IN CUTTING</span></td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-3.5 font-mono font-bold text-slate-900">CUT-2026-103</td>
                        <td class="px-6 py-3.5 font-bold text-slate-800">ST-402 / PO-992</td>
                        <td class="px-6 py-3.5 text-slate-600">Global Retail</td>
                        <td class="px-6 py-3.5 font-medium">Table #2 (15.0 meters)</td>
                        <td class="px-6 py-3.5 font-semibold">100 Plies</td>
                        <td class="px-6 py-3.5 font-bold text-slate-900">3,000 pcs (15 Bundles)</td>
                        <td class="px-6 py-3.5"><span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">FABRIC SPREADING</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection