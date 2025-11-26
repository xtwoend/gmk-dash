@extends('layouts.app')

@section('title', 'Report Analytics')

@section('header')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Analytics
                </div>
                <h2 class="page-title">
                    Startup Analytics
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('startups.report') }}" class="btn btn-outline-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/>
                            <rect x="9" y="3" width="6" height="4" rx="2"/>
                            <path d="M9 14l2 2l4 -4"/>
                        </svg>
                        Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<!-- Filter Section -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('startups.analytics') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Date From</label>
                                <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Date To</label>
                                <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <circle cx="10" cy="10" r="7"/>
                                            <path d="m21 21l-6 -6"/>
                                        </svg>
                                        Update
                                    </button>
                                    <a href="{{ route('startups.analytics') }}" class="btn btn-outline-secondary">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Daily Startup Chart -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daily Startup Activity</h3>
            </div>
            <div class="card-body">
                <div id="chart-daily-startups" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Status Distribution and Performance -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Status Distribution by Device</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Device</th>
                                <th class="text-center">Active</th>
                                <th class="text-center">Paused</th>
                                <th class="text-center">Completed</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $statusByDevice = $statusData->groupBy('device_id');
                            @endphp
                            @foreach($devices as $device)
                                @php
                                    $deviceStatus = $statusByDevice->get($device->id, collect());
                                    $active = $deviceStatus->where('status', 1)->first()->count ?? 0;
                                    $paused = $deviceStatus->where('status', 2)->first()->count ?? 0;
                                    $completed = $deviceStatus->where('status', 3)->first()->count ?? 0;
                                    $total = $active + $paused + $completed;
                                @endphp
                                @if($total > 0)
                                <tr>
                                    <td>{{ $device->name }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-green">{{ $active }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-orange">{{ $paused }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-blue">{{ $completed }}</span>
                                    </td>
                                    <td class="text-center">
                                        <strong>{{ $total }}</strong>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Performance Metrics</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Device</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Completed</th>
                                <th class="text-center">Success Rate</th>
                                <th class="text-center">Avg. Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($performanceData as $perf)
                                @php
                                    $device = $devices->find($perf->device_id);
                                    $successRate = $perf->total_startups > 0 ? ($perf->completed_startups / $perf->total_startups) * 100 : 0;
                                @endphp
                                <tr>
                                    <td>{{ $device->name ?? 'Unknown' }}</td>
                                    <td class="text-center">{{ $perf->total_startups }}</td>
                                    <td class="text-center">{{ $perf->completed_startups }}</td>
                                    <td class="text-center">
                                        @if($successRate >= 80)
                                            <span class="text-green">{{ number_format($successRate, 1) }}%</span>
                                        @elseif($successRate >= 60)
                                            <span class="text-orange">{{ number_format($successRate, 1) }}%</span>
                                        @else
                                            <span class="text-red">{{ number_format($successRate, 1) }}%</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $perf->avg_completion_hours ? number_format($perf->avg_completion_hours, 1) : 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Device Activity Timeline -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Device Activity Timeline</h3>
            </div>
            <div class="card-body">
                @php
                    $dailyByDevice = $dailyData->groupBy('device_id');
                @endphp
                @foreach($devices as $device)
                    @php
                        $deviceDaily = $dailyByDevice->get($device->id, collect());
                    @endphp
                    @if($deviceDaily->count() > 0)
                    <div class="mb-4">
                        <h4 class="mb-3">{{ $device->name }}</h4>
                        <div class="row">
                            @foreach($deviceDaily->sortBy('date') as $daily)
                            <div class="col-auto mb-2">
                                <div class="card card-sm">
                                    <div class="card-body text-center p-2">
                                        <div class="text-muted small">
                                            {{ Carbon\Carbon::parse($daily->date)->format('M d') }}
                                        </div>
                                        <div class="h3 m-0">{{ $daily->startup_count }}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Prepare daily data for chart
    var dailyLabels = [];
    var deviceSeries = {};
    
    @foreach($devices as $device)
        deviceSeries['{{ $device->name }}'] = [];
    @endforeach
    
    // Get all unique dates
    var allDates = @json($dailyData->pluck('date')->unique()->sort()->values());
    
    allDates.forEach(function(date) {
        dailyLabels.push(new Date(date).toLocaleDateString());
        
        @foreach($devices as $device)
            var count = 0;
            @foreach($dailyData as $daily)
                if ('{{ $daily->date }}' === date && {{ $daily->device_id }} === {{ $device->id }}) {
                    count = {{ $daily->startup_count }};
                }
            @endforeach
            deviceSeries['{{ $device->name }}'].push(count);
        @endforeach
    });
    
    // Create series array
    var series = [];
    @foreach($devices as $device)
        series.push({
            name: '{{ $device->name }}',
            data: deviceSeries['{{ $device->name }}']
        });
    @endforeach
    
    var options = {
        chart: {
            type: 'line',
            height: 300,
            toolbar: {
                show: false
            }
        },
        series: series,
        xaxis: {
            categories: dailyLabels,
            title: {
                text: 'Date'
            }
        },
        yaxis: {
            title: {
                text: 'Number of Startups'
            }
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        markers: {
            size: 4
        },
        colors: ['#206bc4', '#79a6dc', '#a8bcd8', '#d4dcdc'],
        legend: {
            position: 'top'
        }
    };
    
    var chart = new ApexCharts(document.querySelector("#chart-daily-startups"), options);
    chart.render();
});
</script>
@endpush
