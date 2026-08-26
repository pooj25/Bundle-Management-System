@extends('layouts.app')

@section('title', 'Production Dashboard')
@section('header_title', 'Bundle Management')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- KPI Summary Cards Grid with Hover Lift Animations -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-5">

        <!-- 1. Total Bundles -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:-translate-y-1 hover:shadow-lg transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Bundles</span>
                <div class="p-2 bg-slate-100 group-hover:bg-blue-50 group-hover:text-blue-600 rounded-xl transition text-slate-600">
                    <i data-lucide="box" class="w-4 h-4"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">
                    {{ number_format($metrics['total_bundles']) }}
                </div>
                <div class="text-xs text-slate-400 mt-1 font-medium flex items-center">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span>
                    Active in production
                </div>
            </div>
        </div>

        <!-- 2. Total Quantity -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:-translate-y-1 hover:shadow-lg transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Quantity</span>
                <div class="p-2 bg-slate-100 group-hover:bg-indigo-50 group-hover:text-indigo-600 rounded-xl transition text-slate-600">
                    <i data-lucide="layers" class="w-4 h-4"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">
                    {{ number_format($metrics['total_quantity']) }}
                </div>
                <div class="text-xs text-slate-400 mt-1 font-medium">Units across all active</div>
            </div>
        </div>

        <!-- 3. Today's Pulse -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:-translate-y-1 hover:shadow-lg transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Today's Pulse</span>
                <div class="p-2 bg-blue-50 text-blue-600 rounded-xl group-hover:scale-110 transition">
                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 mt-1">
                <div>
                    <div class="text-[11px] text-slate-400 font-medium">Produced</div>
                    <div class="text-lg font-bold text-slate-900">{{ number_format($metrics['today_production']) }} <span class="text-[10px] text-slate-400 font-normal">units</span></div>
                </div>
                <div>
                    <div class="text-[11px] text-slate-400 font-medium">Rejected</div>
                    <div class="text-lg font-bold text-rose-600">{{ number_format($metrics['today_rejection']) }} <span class="text-[10px] text-slate-400 font-normal">units</span></div>
                </div>
            </div>
        </div>

        <!-- 4. Total Completed -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:-translate-y-1 hover:shadow-lg transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Completed</span>
                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl group-hover:scale-110 transition">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">
                    {{ number_format($metrics['total_completed']) }}
                </div>
                <div class="mt-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                        {{ $metrics['completion_rate'] }}% Completion
                    </span>
                </div>
            </div>
        </div>

        <!-- 5. Total Rejected -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:-translate-y-1 hover:shadow-lg transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Rejected</span>
                <div class="p-2 bg-rose-50 text-rose-600 rounded-xl group-hover:scale-110 transition">
                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">
                    {{ number_format($metrics['total_rejected']) }}
                </div>
                <div class="mt-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">
                        {{ $metrics['defect_rate'] }}% Defect Rate
                    </span>
                </div>
            </div>
        </div>

    </div>

    <!-- Middle Charts Row with Smooth Renderings -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Chart 1: Daily Production Volume -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.03)]">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Daily Production Volume</h3>
                    <p class="text-xs text-slate-400">Trend of completed vs rejected garments over the last 7 days</p>
                </div>
                <div class="flex items-center space-x-3 text-xs font-semibold">
                    <span class="inline-flex items-center text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-blue-600 mr-1.5 shadow-sm"></span> Produced</span>
                    <span class="inline-flex items-center text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-rose-500 mr-1.5 shadow-sm"></span> Rejected</span>
                </div>
            </div>
            <div class="h-64 relative">
                <canvas id="productionVolumeChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Average Efficiency Donut -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.03)] flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-bold text-slate-900">Average Efficiency</h3>
                <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2.5 py-1 rounded-full">+2.4% vs last week</span>
            </div>
            
            <div class="relative flex items-center justify-center my-auto py-2">
                <div class="w-48 h-48 relative">
                    <canvas id="efficiencyDonutChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-3xl font-black text-slate-900 tracking-tight">{{ $metrics['avg_efficiency'] }}%</span>
                        <span class="text-[11px] font-bold uppercase text-slate-400 tracking-wider">OEE</span>
                    </div>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 grid grid-cols-2 text-center text-xs">
                <div>
                    <div class="text-slate-400">Target Efficiency</div>
                    <div class="font-bold text-slate-800 text-sm">85.0%</div>
                </div>
                <div>
                    <div class="text-slate-400">Current Average</div>
                    <div class="font-bold text-blue-600 text-sm">{{ $metrics['avg_efficiency'] }}%</div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Section: Recent Bundle Activity Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.03)] overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Recent Bundle Activity</h3>
                <p class="text-xs text-slate-400">Live shop floor update of active production lots</p>
            </div>
            <a href="{{ route('bundles.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center space-x-1 group">
                <span>View All</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition transform"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-400 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">BUNDLE ID</th>
                        <th class="px-6 py-3.5">STYLE / PO</th>
                        <th class="px-6 py-3.5">QUANTITY</th>
                        <th class="px-6 py-3.5">SEWING LINE</th>
                        <th class="px-6 py-3.5">STATUS</th>
                        <th class="px-6 py-3.5 text-right">LAST UPDATED</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-mono">
                    @forelse($metrics['recent_bundles'] as $bundle)
                        <tr class="hover:bg-blue-50/30 transition duration-150">
                            <td class="px-6 py-3.5 font-bold text-slate-900">
                                <a href="{{ route('bundles.index') }}?search={{ $bundle->bundle_no }}" class="hover:text-blue-600 transition">
                                    {{ $bundle->bundle_no }}
                                </a>
                            </td>
                            <td class="px-6 py-3.5 text-slate-700 font-sans">
                                <span class="font-bold">{{ $bundle->style->style_no ?? 'N/A' }}</span>
                                <span class="text-slate-400 text-[11px] block">{{ $bundle->buyer->buyer_name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-3.5 font-bold text-slate-900 font-sans">
                                {{ $bundle->quantity }} <span class="text-slate-400 font-normal text-[11px]">pcs</span>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-bold text-[11px]">
                                    {{ $bundle->sewingLine->line_name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5 font-sans">
                                @if($bundle->status_label === 'PASSED')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> PASSED
                                    </span>
                                @elseif($bundle->status_label === 'REJECTED')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> REJECTED
                                    </span>
                                @elseif($bundle->status_label === 'IN PROGRESS')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span> IN PROGRESS
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mr-1.5"></span> PENDING
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 text-right text-slate-400 font-sans text-[11px]">
                                {{ $bundle->updated_at ? $bundle->updated_at->diffForHumans() : 'Just now' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-sans">
                                No bundle activity records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Daily Production Volume Chart with Gradient Fill
    const ctxVolume = document.getElementById('productionVolumeChart').getContext('2d');
    const chartLabels = @json($metrics['chart']['labels']);
    const producedData = @json($metrics['chart']['produced']);
    const rejectedData = @json($metrics['chart']['rejected']);

    new Chart(ctxVolume, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: 'Produced',
                    data: producedData,
                    backgroundColor: '#2563eb',
                    borderRadius: 6,
                    barPercentage: 0.55,
                },
                {
                    label: 'Rejected',
                    data: rejectedData,
                    backgroundColor: '#f43f5e',
                    borderRadius: 6,
                    barPercentage: 0.55,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleFont: { family: 'Inter', size: 12, weight: 'bold' },
                    bodyFont: { family: 'Inter', size: 11 },
                    padding: 10,
                    cornerRadius: 8,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11, family: 'Inter' }, color: '#64748b' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { font: { size: 11, family: 'Inter' }, color: '#64748b' }
                }
            }
        }
    });

    // 2. Efficiency Donut Chart
    const ctxDonut = document.getElementById('efficiencyDonutChart').getContext('2d');
    const effValue = {{ $metrics['avg_efficiency'] }};
    const remainder = Math.max(0, 100 - effValue);

    new Chart(ctxDonut, {
        type: 'doughnut',
        data: {
            labels: ['Efficiency', 'Remaining'],
            datasets: [{
                data: [effValue, remainder],
                backgroundColor: ['#2563eb', '#f1f5f9'],
                borderWidth: 0,
                cutout: '80%',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                animateRotate: true,
                duration: 1200,
            },
            plugins: {
                legend: { display: false },
                tooltip: { enabled: false }
            }
        }
    });
});
</script>
@endsection