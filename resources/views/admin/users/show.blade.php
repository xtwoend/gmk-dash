@extends('layouts.app')

@section('title', 'User Details')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">
                        User Details
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @can('user-edit')
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                <path d="M16 5l3 3"/>
                            </svg>
                            Edit User
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
                <div class="card-body text-center">
                    <span class="avatar avatar-xl mb-3" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=128')"></span>
                    <h3 class="m-0 mb-1">{{ $user->name }}</h3>
                    <div class="text-muted">{{ $user->username }}</div>
                    <div class="mt-3">
                        @foreach($user->roles as $role)
                            <span class="badge bg-{{ $role->name === 'Administrator' ? 'red' : ($role->name === 'Foreman' ? 'blue' : ($role->name === 'Supervisor' ? 'green' : 'yellow')) }}-lt">
                                {{ $role->name }}
                            </span>
                        @endforeach
                        @if($user->roles->isEmpty())
                            <span class="text-muted">No roles assigned</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Information</h3>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-auto">
                                <span class="text-muted">ID:</span>
                            </div>
                            <div class="col">
                                <strong>{{ $user->id }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-auto">
                                <span class="text-muted">Username:</span>
                            </div>
                            <div class="col">
                                <strong>{{ $user->username }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-auto">
                                <span class="text-muted">Created:</span>
                            </div>
                            <div class="col">
                                {{ $user->created_at->format('M d, Y H:i') }}
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-auto">
                                <span class="text-muted">Updated:</span>
                            </div>
                            <div class="col">
                                {{ $user->updated_at->format('M d, Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Roles & Permissions</h3>
                </div>
                <div class="card-body">
                    @if($user->roles->isNotEmpty())
                        @foreach($user->roles as $role)
                            <div class="mb-4">
                                <h4>
                                    <span class="badge bg-{{ $role->name === 'Administrator' ? 'red' : ($role->name === 'Foreman' ? 'blue' : ($role->name === 'Supervisor' ? 'green' : 'yellow')) }}-lt me-2">
                                        {{ $role->name }}
                                    </span>
                                    <small class="text-muted">({{ $role->permissions->count() }} permissions)</small>
                                </h4>
                                
                                @if($role->permissions->isNotEmpty())
                                    <div class="row">
                                        @php
                                            $groupedPermissions = $role->permissions->groupBy(function($permission) {
                                                return explode('-', $permission->name)[0];
                                            });
                                        @endphp
                                        
                                        @foreach($groupedPermissions as $group => $permissions)
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-capitalize">{{ ucfirst($group) }}</h5>
                                                <div class="tags">
                                                    @foreach($permissions as $permission)
                                                        <span class="tag">{{ $permission->name }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">No permissions assigned to this role.</p>
                                @endif
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
                                This user doesn't have any roles assigned yet.
                            </p>
                            @can('user-edit')
                            <div class="empty-action">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <line x1="12" y1="5" x2="12" y2="19"/>
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                    </svg>
                                    Assign Roles
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
