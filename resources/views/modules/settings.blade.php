@extends('layouts.app')

@section('title', 'System Settings')
@section('header_title', 'ERP System Settings')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">
        <div class="border-b border-slate-200 pb-4">
            <h3 class="text-base font-bold text-slate-900">Apparel ERP Manufacturing Settings</h3>
            <p class="text-xs text-slate-400">Configure factory shifts, threshold alerts, and calculation defaults</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Factory Name</label>
                <input type="text" value="Apex Apparel Manufacturing Complex Unit-1" class="w-full px-3 py-2 border rounded-lg bg-slate-50 text-slate-800">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Currency Code</label>
                <input type="text" value="USD ($)" class="w-full px-3 py-2 border rounded-lg bg-slate-50 text-slate-800">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Standard Daily Working Shifts</label>
                <select class="w-full px-3 py-2 border rounded-lg bg-slate-50 text-slate-800">
                    <option selected>2 Shifts (8 Hours Each - Shift A & B)</option>
                    <option>1 General Shift (8 Hours)</option>
                    <option>3 Shifts (24 Hours Round-the-Clock)</option>
                </select>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Defect Rate Warning Threshold (%)</label>
                <input type="number" value="5.0" class="w-full px-3 py-2 border rounded-lg bg-slate-50 text-slate-800">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Target Efficiency Goal (%)</label>
                <input type="number" value="85.0" class="w-full px-3 py-2 border rounded-lg bg-slate-50 text-slate-800">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Default Bundle Number Prefix</label>
                <input type="text" value="BN-" class="w-full px-3 py-2 border rounded-lg bg-slate-50 text-slate-800 font-mono">
            </div>
        </div>

        <div class="pt-4 border-t border-slate-200 flex justify-end">
            <button onclick="showToast('Configuration settings saved successfully!', 'success')" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-lg shadow-sm">
                Save System Settings
            </button>
        </div>
    </div>

</div>
@endsection