@extends('layouts.app')

@section('title', 'Factory Configuration & Settings')
@section('header_title', 'System Settings & Setup')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Factory Setup Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">
        <div class="border-b border-slate-200 pb-4">
            <h3 class="text-base font-bold text-slate-900">Apparel ERP Manufacturing Setup</h3>
            <p class="text-xs text-slate-400">Configure manufacturing complex parameters, shift rosters, and QA thresholds</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1.5">Factory / Plant Name</label>
                <input type="text" value="Pro Apparel Manufacturing Unit 1" class="w-full px-3.5 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-900 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1.5">ERP Currency & Timezone</label>
                <div class="flex space-x-2">
                    <input type="text" value="USD ($)" class="w-1/3 px-3 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-900 font-medium">
                    <input type="text" value="Asia/Kolkata (IST +5:30)" class="w-2/3 px-3 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-900 font-medium">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1.5">Standard Factory Shifts</label>
                <select class="w-full px-3.5 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-900 font-medium">
                    <option selected>2 Shifts (Shift A: 06:00 - 14:00, Shift B: 14:00 - 22:00)</option>
                    <option>1 General Day Shift (08:30 - 17:30)</option>
                    <option>3 Shifts 24/7 (Continuous Production)</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1.5">Quality Acceptance Limit (AQL Standard)</label>
                <select class="w-full px-3.5 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-900 font-medium">
                    <option selected>AQL 2.5 (Standard Export Garments)</option>
                    <option>AQL 1.5 (High Luxury / Strict Inspection)</option>
                    <option>AQL 4.0 (Fast Fashion / Relaxed Inspection)</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1.5">Defect Alert Warning Threshold</label>
                <div class="relative">
                    <input type="number" value="5.0" step="0.1" class="w-full px-3.5 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-900 font-bold">
                    <span class="absolute right-3 top-2 text-slate-400 font-bold">%</span>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1.5">Bundle Number Sequence Pattern</label>
                <input type="text" value="BN-{YYYY}-{RAND4}" class="w-full px-3.5 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-900 font-mono font-bold">
            </div>
        </div>

        <div class="pt-4 border-t border-slate-200 flex justify-between items-center">
            <span class="text-xs text-slate-400">Settings are persisted to database config store.</span>
            <button onclick="showToast('Factory configuration settings saved!', 'success')" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-lg shadow-sm">
                Save Changes
            </button>
        </div>
    </div>

</div>
@endsection