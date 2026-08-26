@extends('layouts.app')

@section('title', 'Quality Control & Inspection')
@section('header_title', 'QC & Quality Inspection')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Total Garments Inspected</div>
            <div class="text-2xl font-black text-slate-900 mt-1">45,920 <span class="text-xs font-normal text-slate-500">pcs</span></div>
            <div class="text-xs text-slate-500 mt-1">100% End-of-Line Check</div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Factory First-Pass Yield</div>
            <div class="text-2xl font-black text-emerald-600 mt-1">98.2%</div>
            <div class="text-xs text-emerald-600 font-semibold mt-1">Exceeds 97.5% Target</div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Total Defective / Rejects</div>
            <div class="text-2xl font-black text-rose-600 mt-1">815 <span class="text-xs font-normal text-slate-500">pcs</span></div>
            <div class="text-xs text-rose-600 font-semibold mt-1">1.7% Factory Defect Rate</div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold uppercase text-slate-400">Major Defect Classification</div>
            <div class="text-sm font-bold text-slate-800 mt-2">1. Skip Stitch (42%)</div>
            <div class="text-xs text-slate-500">2. Broken Thread (28%)</div>
        </div>
    </div>

    <!-- QC Logs Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Live End-of-Line QC Inspections</h3>
                <p class="text-xs text-slate-400">Real-time quality audits per production bundle</p>
            </div>
            <a href="{{ route('bundles.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">View In Bundles Listing &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3.5">BUNDLE NO</th>
                        <th class="px-6 py-3.5">BUYER & STYLE</th>
                        <th class="px-6 py-3.5">SEWING LINE</th>
                        <th class="px-6 py-3.5 text-right">PASSED PCS</th>
                        <th class="px-6 py-3.5 text-right">REJECTED PCS</th>
                        <th class="px-6 py-3.5 text-center">DEFECT %</th>
                        <th class="px-6 py-3.5">QC VERDICT</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($recentInspections as $b)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-3.5 font-mono font-bold text-slate-900">{{ $b->bundle_no }}</td>
                            <td class="px-6 py-3.5 text-slate-700 font-medium">
                                {{ $b->style->style_no ?? 'N/A' }}
                                <span class="text-slate-400 block text-[10px]">{{ $b->buyer->buyer_name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-3.5 font-mono font-semibold text-slate-800">{{ $b->sewingLine->line_name ?? 'N/A' }}</td>
                            <td class="px-6 py-3.5 text-right font-bold text-emerald-600">{{ $b->completed_qty }}</td>
                            <td class="px-6 py-3.5 text-right font-bold text-rose-600">{{ $b->rejected_qty }}</td>
                            <td class="px-6 py-3.5 text-center font-bold {{ $b->rejection_percentage > 5 ? 'text-rose-600' : 'text-slate-700' }}">{{ $b->rejection_percentage }}%</td>
                            <td class="px-6 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $b->status_label === 'PASSED' ? 'bg-emerald-100 text-emerald-800' : ($b->status_label === 'REJECTED' ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ $b->status_label }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection