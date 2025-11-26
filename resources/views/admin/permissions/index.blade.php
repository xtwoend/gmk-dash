@extends('layouts.app')

@section('title', 'Permissions Management')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Administration
                    </div>
                    <h2 class="page-title">
                        Permissions Management
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @can('permission-create')
                        <a href="{{ route('permissions.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Create new permission
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="card">
                <form method="GET" action="{{ route('permissions.index') }}">
                <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                        <div class="text-muted">
                            Show
                            <div class="mx-2 d-inline-block">
                                <select class="form-select form-select-sm" name="per_page" onchange="this.form.submit()">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                </select>
                            </div>
                            entries
                        </div>
                        <div class="ms-auto text-muted">
                            Search:
                            <div class="ms-2 d-inline-block">
                                <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Search users..." value="{{ request('keyword') }}" onkeyup="if(event.keyCode==13) this.form.submit()">
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th>Permission</th>
                                <th>Roles</th>
                                <th class="w-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permissions as $permission)
                                <tr>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">
                                            <span class="tag">{{ $permission->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach($permission->roles as $role)
                                            <span class="badge bg-{{ $role->name === 'Administrator' ? 'red' : ($role->name === 'Foreman' ? 'blue' : ($role->name === 'Supervisor' ? 'green' : 'yellow')) }}-lt me-1">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                        @if($permission->roles->isEmpty())
                                            <span class="text-muted">No roles</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            @can('permission-edit')
                                            <a href="{{ route('permissions.show', $permission) }}" class="btn btn-white btn-sm">
                                                View
                                            </a>
                                            <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-white btn-sm">
                                                Edit
                                            </a>
                                            @endcan
                                            @can('permission-delete')
                                            <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this permission?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-white btn-sm">
                                                    Delete
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="empty">
                                            <div class="empty-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <rect x="3" y="8" width="6" height="6"/>
                                                    <rect x="9" y="8" width="6" height="6"/>
                                                    <rect x="15" y="8" width="6" height="6"/>
                                                    <rect x="3" y="14" width="6" height="6"/>
                                                    <rect x="9" y="14" width="6" height="6"/>
                                                    <rect x="15" y="14" width="6" height="6"/>
                                                </svg>
                                            </div>
                                            <p class="empty-title">No permissions found</p>
                                            <p class="empty-subtitle text-muted">
                                                Try adjusting your search or filter to find what you're looking for.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($permissions->hasPages())
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">
                        Showing <span>{{ $permissions->firstItem() }}</span> to <span>{{ $permissions->lastItem() }}</span> of <span>{{ $permissions->total() }}</span> entries
                    </p>
                    <div class="ms-auto">
                        {{ $permissions->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
