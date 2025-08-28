@extends('layouts.app')

@section('title', 'Startup Reports')

@section('header')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Reports
                </div>
                <h2 class="page-title">
                    Startup Reports per Device
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('startups.analytics') }}" class="btn btn-outline-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3 3v18h18"/>
                            <path d="M9 9l3 3l4 -4l4 4"/>
                        </svg>
                        Analytics
                    </a>
                    <a href="{{ route('startups.index') }}" class="btn btn-outline-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M9 11l3 3l8 -8"/>
                            <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"/>
                        </svg>
                        All Startups
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
            <div class="card-header">
                <h3 class="card-title">Filters</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('startups.report') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Device</label>
                                <select name="device_id" class="form-select">
                                    <option value="">All Devices</option>
                                    @foreach($devices as $device)
                                        <option value="{{ $device->id }}" {{ request('device_id') == $device->id ? 'selected' : '' }}>
                                            {{ $device->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Date From</label>
                                <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Date To</label>
                                <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <circle cx="10" cy="10" r="7"/>
                                            <path d="m21 21l-6 -6"/>
                                        </svg>
                                        Filter
                                    </button>
                                    <a href="{{ route('startups.report') }}" class="btn btn-outline-secondary">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Summary Section -->
<div class="row mb-3">
    <div class="col-md-2">
        <div class="card">
            <div class="card-body p-2 text-center">
                <div class="text-end text-green">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 2l3.09 6.26l6.91 1.01l-5 4.87l1.18 6.88l-6.18 -3.25l-6.18 3.25l1.18 -6.88l-5 -4.87l6.91 -1.01z"/>
                    </svg>
                </div>
                <div class="h1 m-0">{{ $summary['total_devices'] }}</div>
                <div class="text-muted">Active Devices</div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body p-2 text-center">
                <div class="text-end text-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 3v18"/>
                        <path d="M21 12h-18"/>
                    </svg>
                </div>
                <div class="h1 m-0">{{ $summary['total_startups'] }}</div>
                <div class="text-muted">Total Startups</div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body p-2 text-center">
                <div class="text-end text-green">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M7 12l3 3l7 -7"/>
                    </svg>
                </div>
                <div class="h1 m-0">{{ $summary['total_completed'] }}</div>
                <div class="text-muted">Completed</div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body p-2 text-center">
                <div class="text-end text-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M8 12h8"/>
                    </svg>
                </div>
                <div class="h1 m-0">{{ $summary['total_paused'] }}</div>
                <div class="text-muted">Paused</div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body p-2 text-center">
                <div class="text-end text-green">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M7 12l3 3l7 -7"/>
                    </svg>
                </div>
                <div class="h1 m-0">{{ number_format($summary['grand_total_ok']) }}</div>
                <div class="text-muted">Total OK</div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body p-2 text-center">
                <div class="text-end text-red">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M18 6l-12 12"/>
                        <path d="M6 6l12 12"/>
                    </svg>
                </div>
                <div class="h1 m-0">{{ number_format($summary['grand_total_ng']) }}</div>
                <div class="text-muted">Total NG</div>
            </div>
        </div>
    </div>
</div>

<!-- Device Reports -->
@if(count($deviceReports) > 0)
    @foreach($deviceReports as $report)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <rect x="3" y="4" width="18" height="12" rx="1"/>
                                    <path d="M7 20h10"/>
                                    <path d="M9 16v4"/>
                                    <path d="M15 16v4"/>
                                </svg>
                                {{ $report['device']->name }}
                            </h3>
                            <div class="card-subtitle">
                                {{ $report['device']->type }} - {{ $report['device']->location }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="row g-2">
                                <div class="col-auto">
                                    <span class="badge bg-blue">{{ $report['total_startups'] }} Startups</span>
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-green">{{ number_format($report['total_ok_records']) }} OK</span>
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-red">{{ number_format($report['total_ng_records']) }} NG</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Verification Type</th>
                                <th class="text-center">OK Records</th>
                                <th class="text-center">NG Records</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($report['startups'] as $startup)
                            <tr>
                                <td>
                                    <div class="text-muted">
                                        {{ Carbon\Carbon::parse($startup->startup_date)->format('M d, Y') }}
                                    </div>
                                    <div class="small text-muted">
                                        {{ Carbon\Carbon::parse($startup->startup_date)->format('H:i') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex py-1 align-items-center">
                                        <span class="avatar me-2" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($startup->user->name ?? 'Unknown') }}&background=random')"></span>
                                        <div class="flex-fill">
                                            <div class="font-weight-medium">{{ $startup->user->name ?? 'Unknown' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @switch($startup->status)
                                        @case(1)
                                            <span class="badge bg-green">Active</span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-orange">Paused</span>
                                            @break
                                        @case(3)
                                            <span class="badge bg-blue">Completed</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">Unknown</span>
                                    @endswitch
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $startup->verification_type }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="text-green font-weight-medium">{{ number_format($startup->ok_count) }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="text-red font-weight-medium">{{ number_format($startup->ng_count) }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('startups.show', $startup->id) }}" class="btn btn-outline-primary btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <circle cx="12" cy="12" r="2"/>
                                            <path d="M12 1l.951 .298a7.985 7.985 0 0 1 2.53 .957l-.657 .656a13.26 13.26 0 0 0 -5.648 0l-.657 -.656a7.985 7.985 0 0 1 2.53 -.957l.951 -.298z"/>
                                        </svg>
                                        View Details
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No startups found for this device in the selected period.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="empty">
                    <div class="empty-img">
                        <img src="{{ asset('img/undraw_no_data.svg') }}" height="128" alt="">
                    </div>
                    <p class="empty-title">No startup data found</p>
                    <p class="empty-subtitle text-muted">
                        Try adjusting your filters or check if any startups have been recorded for the selected period.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
