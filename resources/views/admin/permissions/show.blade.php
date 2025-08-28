@extends('layouts.app')

@section('title', 'Permission Details')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissions</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $permission->name }}</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">
                        Permission Details
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @can('permission-edit')
                        <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                <path d="M16 5l3 3"/>
                            </svg>
                            Edit Permission
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permission Information</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <div>
                            <span class="tag tag-lg">{{ $permission->name }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guard</label>
                        <div>{{ $permission->guard_name }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Created</label>
                        <div>{{ $permission->created_at->format('M d, Y H:i') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Updated</label>
                        <div>{{ $permission->updated_at->format('M d, Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Roles using this Permission</h3>
                </div>
                <div class="card-body">
                    @if($permission->roles->isNotEmpty())
                        @foreach($permission->roles as $role)
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-{{ $role->name === 'Administrator' ? 'red' : ($role->name === 'Foreman' ? 'blue' : ($role->name === 'Supervisor' ? 'green' : 'yellow')) }}-lt me-3">
                                    {{ $role->name }}
                                </span>
                                <div class="text-muted small">
                                    {{ $role->users->count() }} users with this role
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty">
                            <div class="empty-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="12" cy="12" r="4"/>
                                    <path d="M12 2v2"/>
                                    <path d="M12 20v2"/>
                                    <path d="M4.93 4.93l1.41 1.41"/>
                                    <path d="M17.66 17.66l1.41 1.41"/>
                                    <path d="M2 12h2"/>
                                    <path d="M20 12h2"/>
                                    <path d="M4.93 19.07l1.41 -1.41"/>
                                    <path d="M17.66 6.34l1.41 -1.41"/>
                                </svg>
                            </div>
                            <p class="empty-title">No roles assigned</p>
                            <p class="empty-subtitle text-muted">
                                This permission is not assigned to any roles yet.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
