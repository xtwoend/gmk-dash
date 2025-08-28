@extends('layouts.app')

@section('title', 'Device Details')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('devices.index') }}">Devices</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $device->name ?: 'Device #' . $device->id }}</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">
                        {{ $device->name ?: 'Unnamed Device' }}
                        {!! $device->status_badge !!}
                    </h2>
                    <div class="text-muted mt-1">Device ID: {{ $device->id }}</div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @can('device-edit')
                            <form method="POST" action="{{ route('devices.toggle-status', $device) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn {{ $device->status ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                    @if($device->status)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                            <path d="M3 3l18 18"/>
                                        </svg>
                                        Deactivate
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                        </svg>
                                        Activate
                                    @endif
                                </button>
                            </form>
                            
                            <a href="{{ route('devices.edit', $device) }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                    <path d="M16 5l3 3"/>
                                </svg>
                                Edit Device
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <!-- Device Information -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Device Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Device Name</label>
                                <div class="font-weight-medium">{{ $device->name ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Device Type</label>
                                <div>
                                    @if($device->type)
                                        <span class="badge bg-blue-lt">{{ ucfirst($device->type) }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Verification Type</label>
                                <div>
                                    @if($device->verification_type)
                                        <span class="badge bg-azure-lt">{{ ucfirst($device->verification_type) }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Location</label>
                                <div>{{ $device->location ?: '-' }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Handler</label>
                                <div>{{ $device->handler ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Status</label>
                                <div>{!! $device->status_badge !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Device Metadata and Actions -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Device Metadata</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Device ID</label>
                        <div class="font-weight-medium">#{{ $device->id }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Created At</label>
                        <div>{{ $device->created_at->format('M d, Y') }}</div>
                        <small class="text-muted">{{ $device->created_at->format('H:i') }}</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Last Updated</label>
                        <div>{{ $device->updated_at->format('M d, Y') }}</div>
                        <small class="text-muted">{{ $device->updated_at->format('H:i') }}</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Time Since Created</label>
                        <div>{{ $device->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
            
            @can('device-delete')
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title text-danger">Danger Zone</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Deleting this device is permanent and cannot be undone. All associated data will be lost.
                        </p>
                        
                        <form method="POST" 
                              action="{{ route('devices.destroy', $device) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this device? This action cannot be undone.')"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 7l16 0"/>
                                    <path d="M10 11l0 6"/>
                                    <path d="M14 11l0 6"/>
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                </svg>
                                Delete Device
                            </button>
                        </form>
                    </div>
                </div>
            @endcan
        </div>
    </div>
    
    <!-- Related Information (Placeholder for future enhancements) -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Activity Log</h3>
                    <div class="card-actions">
                        <small class="text-muted">Recent device activities</small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="empty">
                        <div class="empty-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-muted" width="48" height="48" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"/>
                                <path d="M12 7v5l3 3"/>
                            </svg>
                        </div>
                        <p class="empty-title">No activity recorded</p>
                        <p class="empty-subtitle text-muted">
                            Activity logging will appear here when implemented.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
