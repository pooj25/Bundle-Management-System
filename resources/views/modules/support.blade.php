@extends('layouts.app')

@section('title', 'Help & Documentation')
@section('header_title', 'Support & Documentation')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 text-slate-800">

    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl p-8 shadow-sm">
        <h2 class="text-2xl font-black tracking-tight">Production Bundle Management - Knowledge Base</h2>
        <p class="text-blue-100 text-sm mt-1">Complete system guide, mathematical formulas, and REST API documentation</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm space-y-3">
            <h3 class="text-sm font-bold text-slate-900 flex items-center space-x-2">
                <i data-lucide="calculator" class="w-4 h-4 text-blue-600"></i>
                <span>Real-Time Formulas</span>
            </h3>
            <ul class="space-y-2 text-slate-600">
                <li>• <strong>Balance Qty:</strong> <code>Quantity - Completed - Rejected</code></li>
                <li>• <strong>Efficiency %:</strong> <code>(Completed / Quantity) * 100</code></li>
                <li>• <strong>Rejection %:</strong> <code>(Rejected / Quantity) * 100</code></li>
                <li>• <strong>Constraint:</strong> <code>Completed + Rejected &le; Total Quantity</code></li>
            </ul>
        </div>

        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm space-y-3">
            <h3 class="text-sm font-bold text-slate-900 flex items-center space-x-2">
                <i data-lucide="terminal" class="w-4 h-4 text-blue-600"></i>
                <span>Console Commands</span>
            </h3>
            <ul class="space-y-2 text-slate-600 font-mono">
                <li>• <code>php artisan migrate --seed</code></li>
                <li>• <code>php artisan test</code> (Run 19 automated tests)</li>
                <li>• <code>php artisan bundle:generate-50k 50000</code></li>
                <li>• <code>php artisan serve</code> (Start web server)</li>
            </ul>
        </div>
    </div>

</div>
@endsection