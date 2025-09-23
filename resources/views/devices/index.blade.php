@extends('layouts.app')

@section('title', 'Devices Management')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Management</div>
                    <h2 class="page-title">Devices</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @can('device-create')
                            <a href="{{ route('devices.create') }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 5l0 14"/>
                                    <path d="M5 12l14 0"/>
                                </svg>
                                Add Device
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
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Devices</h3>
                    <div class="card-actions">
                        <div class="d-flex">
                            <form method="GET" action="{{ route('devices.index') }}" class="d-flex">
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       class="form-control form-control-sm me-2" placeholder="Search devices..." 
                                       style="width: 200px;">
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"/>
                                        <path d="M21 21l-6 -6"/>
                                    </svg>
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('devices.index') }}" class="btn btn-sm btn-outline-secondary ms-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M18 6l-12 12"/>
                                            <path d="M6 6l12 12"/>
                                        </svg>
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                
                @if($devices->isEmpty())
                    <div class="card-body text-center py-5">
                        <div class="empty">
                            <div class="empty-img">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-muted" width="120" height="120" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M3 7a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-10z"/>
                                    <path d="M7 10l2 0"/>
                                    <path d="M7 14l4 0"/>
                                    <path d="M15 10l2 0"/>
                                    <path d="M15 14l2 0"/>
                                </svg>
                            </div>
                            <p class="empty-title">No devices found</p>
                            <p class="empty-subtitle text-muted">
                                @if(request('search'))
                                    No devices match your search criteria.
                                @else
                                    You haven't added any devices yet. Create your first device to get started.
                                @endif
                            </p>
                            @can('device-create')
                                <div class="empty-action">
                                    <a href="{{ route('devices.create') }}" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 5l0 14"/>
                                            <path d="M5 12l14 0"/>
                                        </svg>
                                        Add your first device
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Verification Type</th>
                                    <th>Location</th>
                                    <th>Handler</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th class="w-1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($devices as $device)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-sm me-2" style="background-color: {{ $device->status ? '#2fb344' : '#dc3545' }};">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M3 7a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-10z"/>
                                                        <path d="M7 10l2 0"/>
                                                        <path d="M7 14l4 0"/>
                                                        <path d="M15 10l2 0"/>
                                                        <path d="M15 14l2 0"/>
                                                    </svg>
                                                </span>
                                                <div>
                                                    <div class="font-weight-medium">{{ $device->name ?: 'Unnamed Device' }}</div>
                                                    @if($device->name)
                                                        <div class="text-muted text-sm">ID: {{ $device->id }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $device->type ?: '-' }}</span>
                                        </td>
                                        <td>
                                            @if($device->verification_type)
                                                <span class="badge bg-azure-lt">{{ $device->verification_type }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $device->location ?: '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $device->handler ?: '-' }}</span>
                                        </td>
                                        <td>
                                            {!! $device->status_badge !!}
                                        </td>
                                        <td class="text-muted">
                                            {{ $device->created_at->format('M d, Y') }}
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                @can('device-edit')
                                                    <a href="{{ route('devices.show', $device) }}" class="btn btn-sm btn-outline-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('devices.edit', $device) }}" class="btn btn-sm btn-outline-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                                            <path d="M16 5l3 3"/>
                                                        </svg>
                                                    </a>
                                                @endcan
                                                
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <circle cx="12" cy="12" r="1"/>
                                                            <circle cx="12" cy="19" r="1"/>
                                                            <circle cx="12" cy="5" r="1"/>
                                                        </svg>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('device-edit')
                                                            <a href="{{ route('device-products.index', ['device_id' => $device->id]) }}" class="dropdown-item">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M12 5l0 14"/>
                                                                    <path d="M5 12l14 0"/>
                                                                </svg>
                                                                Product List
                                                            </a>
                                                            <form method="POST" action="{{ route('devices.toggle-status', $device) }}" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="dropdown-item">
                                                                    @if($device->status)
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                                                            <path d="M3 3l18 18"/>
                                                                        </svg>
                                                                        Deactivate
                                                                    @else
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon text-success" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                                                        </svg>
                                                                        Activate
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        @endcan
                                                        
                                                        @can('device-delete')
                                                            <div class="dropdown-divider"></div>
                                                            <form method="POST" action="{{ route('devices.destroy', $device) }}" 
                                                                  onsubmit="return confirm('Are you sure you want to delete this device?')" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                        <path d="M4 7l16 0"/>
                                                                        <path d="M10 11l0 6"/>
                                                                        <path d="M14 11l0 6"/>
                                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                                                    </svg>
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($devices->hasPages())
                        <div class="card-footer">
                            {{ $devices->withQueryString()->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
