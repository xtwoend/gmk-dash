@extends('layouts.app')

@section('title', 'Create User')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create User</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">
                        Create User
                    </h2>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Information</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" placeholder="Enter full name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                                           value="{{ old('username') }}" placeholder="Enter username">
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Enter password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control" 
                                           placeholder="Confirm password">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Roles</label>
                                    <div class="form-selectgroup">
                                        @foreach($roles as $role)
                                            <label class="form-selectgroup-item">
                                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                                       class="form-selectgroup-input" 
                                                       {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">
                                                    <span class="badge bg-{{ $role->name === 'Administrator' ? 'red' : ($role->name === 'Foreman' ? 'blue' : ($role->name === 'Supervisor' ? 'green' : 'yellow')) }}-lt me-2">
                                                        {{ $role->name }}
                                                    </span>
                                                    {{ $role->permissions->count() }} permissions
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('roles')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Role Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-muted">
                                            <p><strong>Administrator:</strong> Full access to all features</p>
                                            <p><strong>Foreman:</strong> Production management and device control</p>
                                            <p><strong>Supervisor:</strong> Production monitoring and basic management</p>
                                            <p><strong>Quality:</strong> Quality control and verification tasks</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <a href="{{ route('users.index') }}" class="btn btn-link">Cancel</a>
                                <button type="submit" class="btn btn-primary ms-auto">Create User</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
