@extends('layouts.app')

@section('title', 'Role Details')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $role->name }}</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">
                        Role Details: {{ $role->name }}
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @can('role-edit')
                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                <path d="M16 5l3 3"/>
                            </svg>
                            Edit Role
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
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Role Information</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <span class="badge bg-{{ $role->name === 'Administrator' ? 'red' : ($role->name === 'Foreman' ? 'blue' : ($role->name === 'Supervisor' ? 'green' : 'yellow')) }}-lt badge-lg">
                            {{ $role->name }}
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h3 m-0">{{ $role->permissions->count() }}</div>
                                <div class="text-muted">Permissions</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h3 m-0">{{ $role->users->count() }}</div>
                                <div class="text-muted">Users</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users with this Role</h3>
                </div>
                <div class="card-body">
                    @if($role->users->isNotEmpty())
                        @foreach($role->users as $user)
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar me-2" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random')"></span>
                                <div>
                                    <div class="font-weight-medium">{{ $user->name }}</div>
                                    <div class="text-muted small">{{ $user->username }}</div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-muted">No users assigned to this role.</div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permissions</h3>
                </div>
                <div class="card-body">
                    @if($role->permissions->isNotEmpty())
                        @php
                            $groupedPermissions = $role->permissions->groupBy(function($permission) {
                                return explode('-', $permission->name)[0];
                            });
                        @endphp
                        
                        @foreach($groupedPermissions as $group => $permissions)
                            <div class="mb-4">
                                <h4 class="text-capitalize">{{ ucfirst($group) }} ({{ $permissions->count() }})</h4>
                                <div class="tags">
                                    @foreach($permissions as $permission)
                                        <span class="tag">{{ $permission->name }}</span>
                                    @endforeach
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
                            <p class="empty-title">No permissions assigned</p>
                            <p class="empty-subtitle text-muted">
                                This role doesn't have any permissions assigned yet.
                            </p>
                            @can('role-edit')
                            <div class="empty-action">
                                <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <line x1="12" y1="5" x2="12" y2="19"/>
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                    </svg>
                                    Assign Permissions
                                </a>
                            </div>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
