@extends('layouts.app')

@section('title', 'Report MD')

@section('header')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Management
                </div>
                <h2 class="page-title">
                    Production Reports
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('startups.report') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/>
                            <rect x="9" y="3" width="6" height="4" rx="2"/>
                            <path d="M9 14l2 2l4 -4"/>
                        </svg>
                        View Reports
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
                <form method="GET" action="{{ route('startups.index') }}">
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
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Paused</option>
                                    <option value="3" {{ request('status') === '3' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label">Date From</label>
                                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label">Date To</label>
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
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
                                    <a href="{{ route('startups.index') }}" class="btn btn-outline-secondary">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Startups Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Device</th>
                            <th>Operator</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Verification</th>
                            <th class="text-center">OK</th>
                            <th class="text-center">NG</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($startups as $startup)
                        <tr>
                            <td>
                                <div class="text-muted">#{{ $startup->id }}</div>
                            </td>
                            <td>
                                <div class="d-flex py-1 align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <rect x="3" y="4" width="18" height="12" rx="1"/>
                                        <path d="M7 20h10"/>
                                        <path d="M9 16v4"/>
                                        <path d="M15 16v4"/>
                                    </svg>
                                    <div class="flex-fill">
                                        <div class="font-weight-medium">{{ $startup->device->name }}</div>
                                        <div class="text-muted">{{ $startup->device->location }}</div>
                                    </div>
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
                                <div class="text-muted">
                                    {{ Carbon\Carbon::parse($startup->startup_date)->format('d M Y') }}
                                </div>
                            </td>
                            <td>
                                @switch($startup->status)
                                    @case(1)
                                        Active
                                        @break
                                    @case(2)
                                        Paused
                                        @break
                                    @case(3)
                                        Completed
                                        @break
                                    @default
                                        Starting
                                @endswitch
                            </td>
                            <td>
                                {{ $startup->verification_type == 'hourly'? 'Per Jam': 'Per Batch' }}
                            </td>
                            <td class="text-center">
                                <span class="text-green font-weight-medium">{{ number_format($startup->ok_count) }}</span>
                            </td>
                            <td class="text-center">
                                <span class="text-red font-weight-medium">{{ number_format($startup->ng_count) }}</span>
                            </td>
                            <td class="text-end">
                                <div class="btn-list flex-nowrap">
                                    <a href="{{ route('startups.show', $startup->id) }}" class="btn btn-outline-primary btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <circle cx="12" cy="12" r="2"/>
                                            <path d="M12 1l.951 .298a7.985 7.985 0 0 1 2.53 .957l-.657 .656a13.26 13.26 0 0 0 -5.648 0l-.657 -.656a7.985 7.985 0 0 1 2.53 -.957l.951 -.298z"/>
                                        </svg>
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <div class="empty">
                                    <div class="empty-img">
                                        <img src="{{ asset('img/undraw_no_data.svg') }}" height="128" alt="">
                                    </div>
                                    <p class="empty-title">No startups found</p>
                                    <p class="empty-subtitle text-muted">
                                        Try adjusting your filters or check if any startups have been recorded.
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($startups->hasPages())
            <div class="card-footer">
                {{ $startups->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
