@extends('layouts.app')

@section('title', 'Profile')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Account Settings</h2>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <span class="avatar avatar-xl" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random')"></span>
                    </div>
                    <div class="card-title mb-1">{{ Auth::user()->name }}</div>
                    <div class="text-muted">{{ Auth::user()->getRoleNames()->implode(', ') }}</div>
                    <div class="list-group list-group-transparent">
                        <a href="#" class="list-group-item list-group-item-action active d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                                <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/>
                                <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"/>
                            </svg>
                            My Profile
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"/>
                                <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"/>
                            </svg>
                            Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <form class="card" action="{{ route('dashboard.profile.update') }}" method="POST" autocomplete="off" novalidate>
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Edit Profile</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Name" value="{{ old('name', Auth::user()->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', Auth::user()->username) }}">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select class="form-select" disabled>
                                    <option>{{ Auth::user()->getRoleNames()->implode(', ') ?: 'No roles assigned' }}</option>
                                </select>
                                <small class="form-hint">Contact an administrator to change your role.</small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter new password (leave blank to keep current)">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
@endsection
