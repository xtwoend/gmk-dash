@extends('layouts.app')

@section('title', 'Shifts')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Shifts Management</h2>
                    <div class="text-muted mt-1">Manage work shifts and schedules</div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @can('shift-create')
                        <a href="{{ route('shifts.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            New Shift
                        </a>
                        @endcan
                        <a href="{{ route('shifts.create') }}" class="btn btn-primary d-sm-none btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Current Shift Status -->
    @if($currentShift)
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-success" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="12" cy="12" r="9"/>
                            <polyline points="12,7 12,12 15,15"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="alert-title">Current Active Shift</h4>
                        <div class="text-muted">
                            <strong>{{ $currentShift->name }}</strong> 
                            ({{ $currentShift->start_time }} - {{ $currentShift->end_time }})
                            <span class="badge bg-green ms-2">{{ $currentShift->formatted_duration }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-warning" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"/>
                            <path d="M12 8v4"/>
                            <path d="M12 16h.01"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="alert-title">No Active Shift</h4>
                        <div class="text-muted">No shift is currently active based on the system time.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Search and Filter -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('shifts.index') }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-control" 
                                           name="search" 
                                           value="{{ request('search') }}" 
                                           placeholder="Search shifts by name...">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <circle cx="11" cy="11" r="8"/>
                                            <path d="m21 21l-4.35 -4.35"/>
                                        </svg>
                                        Search
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(request('search'))
                                    <a href="{{ route('shifts.index') }}" class="btn btn-outline-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <line x1="18" y1="6" x2="6" y2="18"/>
                                            <line x1="6" y1="6" x2="18" y2="18"/>
                                        </svg>
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Shifts Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Shifts</h3>
                    <div class="card-actions">
                        <span class="text-muted">{{ $shifts->total() }} shifts found</span>
                    </div>
                </div>
                
                @if($shifts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Shift Name</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th class="w-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shifts as $shift)
                            <tr>
                                <td>
                                    <div class="d-flex py-1 align-items-center">
                                        <span class="avatar me-2" style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($shift->name) }}&background=random&color=fff)"></span>
                                        <div class="flex-fill">
                                            <div class="font-weight-medium">{{ $shift->name }}</div>
                                            <div class="text-muted">
                                                <small>Created {{ $shift->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-blue">{{ $shift->start_time }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-purple">{{ $shift->end_time }}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $shift->formatted_duration }}</span>
                                </td>
                                <td>
                                    @if($shift->isCurrentlyActive())
                                        <span class="badge bg-success">Active Now</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <a href="{{ route('shifts.show', $shift) }}" class="btn btn-white btn-sm" title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                            </svg>
                                        </a>
                                        @can('shift-edit')
                                        <a href="{{ route('shifts.edit', $shift) }}" class="btn btn-white btn-sm" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                                <path d="M16 5l3 3"/>
                                            </svg>
                                        </a>
                                        @endcan
                                        @can('shift-delete')
                                        <form method="POST" action="{{ route('shifts.destroy', $shift) }}" class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this shift?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-white btn-sm" title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <line x1="4" y1="7" x2="20" y2="7"/>
                                                    <line x1="10" y1="11" x2="10" y2="17"/>
                                                    <line x1="14" y1="11" x2="14" y2="17"/>
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                                </svg>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($shifts->hasPages())
                <div class="card-footer d-flex align-items-center">
                    {{ $shifts->links() }}
                </div>
                @endif
                
                @else
                <div class="empty">
                    <div class="empty-img"><img src="{{ asset('img/undraw_printing_invoices_5r4r.svg') }}" height="128" alt=""></div>
                    <p class="empty-title">No shifts found</p>
                    <p class="empty-subtitle text-muted">
                        @if(request('search'))
                            No shifts match your search criteria.
                        @else
                            Try creating your first shift to get started.
                        @endif
                    </p>
                    <div class="empty-action">
                        @can('shift-create')
                        <a href="{{ route('shifts.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Create your first shift
                        </a>
                        @endcan
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
