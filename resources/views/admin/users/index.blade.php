@extends('layouts.app')

@section('title', 'Users Management')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Administration
                    </div>
                    <h2 class="page-title">
                        Users Management
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @can('user-create')
                        <a href="{{ route('users.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Create new user
                        </a>
                        <a href="{{ route('users.create') }}" class="btn btn-primary d-sm-none btn-icon" aria-label="Create new user">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
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
                <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                        <div class="text-muted">
                            Show
                            <div class="mx-2 d-inline-block">
                                <select class="form-select form-select-sm">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            entries
                        </div>
                        <div class="ms-auto text-muted">
                            Search:
                            <div class="ms-2 d-inline-block">
                                <input type="text" class="form-control form-control-sm" placeholder="Search users...">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Username</th>
                                <th>Roles</th>
                                <th>Created</th>
                                <th class="w-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">
                                            <span class="avatar me-2" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random')"></span>
                                            <div class="flex-fill">
                                                <div class="font-weight-medium">{{ $user->name }}</div>
                                                <div class="text-muted">ID: {{ $user->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-outline text-blue">{{ $user->username }}</span>
                                    </td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="badge bg-{{ $role->name === 'Administrator' ? 'red' : ($role->name === 'Foreman' ? 'blue' : ($role->name === 'Supervisor' ? 'green' : 'yellow')) }}-lt">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                        @if($user->roles->isEmpty())
                                            <span class="text-muted">No roles assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            @can('user-edit')
                                            <a href="{{ route('users.show', $user) }}" class="btn btn-white btn-sm">
                                                View
                                            </a>
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-white btn-sm">
                                                Edit
                                            </a>
                                            @endcan
                                            @can('user-delete')
                                                @if($user->id !== Auth::id())
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
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
                                                    <circle cx="12" cy="7" r="4"/>
                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                                                </svg>
                                            </div>
                                            <p class="empty-title">No users found</p>
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
                
                @if($users->hasPages())
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">
                        Showing <span>{{ $users->firstItem() }}</span> to <span>{{ $users->lastItem() }}</span> of <span>{{ $users->total() }}</span> entries
                    </p>
                    <ul class="pagination m-0 ms-auto">
                        {{ $users->links() }}
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
