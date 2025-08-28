@extends('layouts.app')

@section('title', 'Shift Details')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('shifts.index') }}">Shifts</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $shift->name }}</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">{{ $shift->name }}</h2>
                    <div class="text-muted mt-1">
                        {{ $shift->start_time }} - {{ $shift->end_time }}
                        @if($shift->isCurrentlyActive())
                            <span class="badge bg-success ms-2">Currently Active</span>
                        @endif
                    </div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @can('shift-edit')
                        <a href="{{ route('shifts.edit', $shift) }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                <path d="M16 5l3 3"/>
                            </svg>
                            Edit Shift
                        </a>
                        @endcan
                        <a href="{{ route('shifts.index') }}" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 12l14 0"/>
                                <path d="M5 12l6 6"/>
                                <path d="M5 12l6 -6"/>
                            </svg>
                            Back to Shifts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- Shift Details -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Shift Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Shift Name</label>
                                <div class="form-control-plaintext h5">{{ $shift->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-control-plaintext">
                                    @if($shift->isCurrentlyActive())
                                        <span class="badge bg-success fs-6">Currently Active</span>
                                    @else
                                        <span class="badge bg-secondary fs-6">Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Start Time</label>
                                <div class="form-control-plaintext">
                                    <span class="badge bg-blue fs-6">{{ $shift->start_time }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">End Time</label>
                                <div class="form-control-plaintext">
                                    <span class="badge bg-purple fs-6">{{ $shift->end_time }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Duration</label>
                                <div class="form-control-plaintext">
                                    <span class="badge bg-green fs-6">{{ $shift->formatted_duration }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Metadata</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Created At</label>
                                <div class="form-control-plaintext">{{ $shift->created_at->format('M d, Y \a\t H:i') }}</div>
                                <div class="form-hint">{{ $shift->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Last Updated</label>
                                <div class="form-control-plaintext">{{ $shift->updated_at->format('M d, Y \a\t H:i') }}</div>
                                <div class="form-hint">{{ $shift->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush list-group-hoverable">
                        @can('shift-edit')
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="status-dot status-dot-animated bg-blue d-block"></span>
                                </div>
                                <div class="col text-truncate">
                                    <a href="{{ route('shifts.edit', $shift) }}" class="text-body d-block">Edit Shift</a>
                                    <div class="d-block text-muted text-truncate mt-n1">Modify shift details</div>
                                </div>
                            </div>
                        </div>
                        @endcan
                        
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="status-dot status-dot-animated bg-green d-block"></span>
                                </div>
                                <div class="col text-truncate">
                                    <a href="{{ route('shifts.index') }}" class="text-body d-block">All Shifts</a>
                                    <div class="d-block text-muted text-truncate mt-n1">View all shifts</div>
                                </div>
                            </div>
                        </div>

                        @can('shift-create')
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="status-dot status-dot-animated bg-purple d-block"></span>
                                </div>
                                <div class="col text-truncate">
                                    <a href="{{ route('shifts.create') }}" class="text-body d-block">Create New Shift</a>
                                    <div class="d-block text-muted text-truncate mt-n1">Add another shift</div>
                                </div>
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Shift Statistics -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Shift Statistics</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <div class="number">{{ $shift->duration }}</div>
                                <div class="text-muted">Minutes</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <div class="number">{{ number_format($shift->duration / 60, 1) }}</div>
                                <div class="text-muted">Hours</div>
                            </div>
                        </div>
                    </div>
                    
                    @if($shift->isCurrentlyActive())
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
                                <h4 class="alert-title">Active Now!</h4>
                                <div class="text-muted">This shift is currently running based on system time.</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Danger Zone -->
            @can('shift-delete')
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Danger Zone</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">Permanently delete this shift. This action cannot be undone.</p>
                    <form method="POST" action="{{ route('shifts.destroy', $shift) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this shift? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="4" y1="7" x2="20" y2="7"/>
                                <line x1="10" y1="11" x2="10" y2="17"/>
                                <line x1="14" y1="11" x2="14" y2="17"/>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                            </svg>
                            Delete Shift
                        </button>
                    </form>
                </div>
            </div>
            @endcan
        </div>
    </div>
@endsection
