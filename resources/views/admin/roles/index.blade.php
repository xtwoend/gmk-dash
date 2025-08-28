@extends('layouts.app')

@section('title', 'Roles Management')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Administration
                    </div>
                    <h2 class="page-title">
                        Roles Management
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @can('role-create')
                        <a href="{{ route('roles.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Create new role
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
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th>Permissions</th>
                                <th>Users</th>
                                <th>Created</th>
                                <th class="w-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                                <tr>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">
                                            <span class="badge bg-{{ $role->name === 'Administrator' ? 'red' : ($role->name === 'Foreman' ? 'blue' : ($role->name === 'Supervisor' ? 'green' : 'yellow')) }}-lt me-2">
                                                {{ $role->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-outline text-blue">
                                            {{ $role->permissions->count() }} permissions
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-outline text-green">
                                            {{ $role->users->count() }} users
                                        </span>
                                    </td>
                                    <td>
                                        {{ $role->created_at->format('M d, Y') }}
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            @can('role-edit')
                                            <a href="{{ route('roles.show', $role) }}" class="btn btn-white btn-sm">
                                                View
                                            </a>
                                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-white btn-sm">
                                                Edit
                                            </a>
                                            @endcan
                                            @can('role-delete')
                                                @if($role->name !== 'Administrator')
                                                <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-white btn-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                                @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
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
                                            <p class="empty-title">No roles found</p>
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
                
                @if($roles->hasPages())
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">
                        Showing <span>{{ $roles->firstItem() }}</span> to <span>{{ $roles->lastItem() }}</span> of <span>{{ $roles->total() }}</span> entries
                    </p>
                    <ul class="pagination m-0 ms-auto">
                        {{ $roles->links() }}
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
