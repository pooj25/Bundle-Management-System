@extends('layouts.app')

@section('title', 'Fabric & Trim Sourcing')
@section('header_title', 'Sourcing & Procurement')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Total Purchase Orders</div>
            <div class="text-2xl font-black text-slate-900 mt-1">28 Active</div>
            <div class="text-xs text-emerald-600 font-semibold mt-1">94% On-Time Delivery</div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Fabric in Warehouse</div>
            <div class="text-2xl font-black text-slate-900 mt-1">142,500 <span class="text-xs font-normal text-slate-500">meters</span></div>
            <div class="text-xs text-slate-500 mt-1">Cotton, Denim, Linen, Knit</div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Pending Approvals</div>
            <div class="text-2xl font-black text-amber-600 mt-1">4 Orders</div>
            <div class="text-xs text-slate-500 mt-1">Yarn Lab Dips & Trims</div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Monthly Sourcing Value</div>
            <div class="text-2xl font-black text-blue-600 mt-1">$482,900</div>
            <div class="text-xs text-slate-500 mt-1">Across 12 Global Vendors</div>
        </div>
    </div>

    <!-- Sourcing Orders Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Fabric & Material Purchase Orders</h3>
                <p class="text-xs text-slate-400">Active mill procurement orders for scheduled apparel production lines</p>
            </div>
            <button onclick="showToast('New Purchase Order modal triggered', 'info')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm">
                + Create Purchase Order
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3.5">PO NUMBER</th>
                        <th class="px-6 py-3.5">BUYER / BRAND</th>
                        <th class="px-6 py-3.5">MATERIAL DESCRIPTION</th>
                        <th class="px-6 py-3.5">QUANTITY</th>
                        <th class="px-6 py-3.5">EST. ARRIVAL</th>
                        <th class="px-6 py-3.5">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-3.5 font-mono font-bold text-slate-900">PO-FAB-8921</td>
                        <td class="px-6 py-3.5 font-bold text-slate-800">Global Retail</td>
                        <td class="px-6 py-3.5 text-slate-600">100% Combed Cotton Single Jersey (180 GSM) - Navy</td>
                        <td class="px-6 py-3.5 font-semibold text-slate-800">25,000 meters</td>
                        <td class="px-6 py-3.5 text-slate-500">Tomorrow</td>
                        <td class="px-6 py-3.5"><span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">IN TRANSIT</span></td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-3.5 font-mono font-bold text-slate-900">PO-FAB-8922</td>
                        <td class="px-6 py-3.5 font-bold text-slate-800">Urban Out</td>
                        <td class="px-6 py-3.5 text-slate-600">Indigo Ring Spun Denim 12oz (Stretch 2%)</td>
                        <td class="px-6 py-3.5 font-semibold text-slate-800">18,500 meters</td>
                        <td class="px-6 py-3.5 text-slate-500">In 3 Days</td>
                        <td class="px-6 py-3.5"><span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">PROCESSING</span></td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-3.5 font-mono font-bold text-slate-900">PO-TRM-4011</td>
                        <td class="px-6 py-3.5 font-bold text-slate-800">Metro Wear</td>
                        <td class="px-6 py-3.5 text-slate-600">Polyester Core Spun Thread Tex 40 & YKK Metal Zippers</td>
                        <td class="px-6 py-3.5 font-semibold text-slate-800">50,000 units</td>
                        <td class="px-6 py-3.5 text-slate-500">Delivered</td>
                        <td class="px-6 py-3.5"><span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">RECEIVED</span></td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-3.5 font-mono font-bold text-slate-900">PO-FAB-8925</td>
                        <td class="px-6 py-3.5 font-bold text-slate-800">Zara Tex</td>
                        <td class="px-6 py-3.5 text-slate-600">Pure French Linen 160 GSM - Natural Olive</td>
                        <td class="px-6 py-3.5 font-semibold text-slate-800">12,000 meters</td>
                        <td class="px-6 py-3.5 text-slate-500">Next Week</td>
                        <td class="px-6 py-3.5"><span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">PENDING LAB DIP</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection