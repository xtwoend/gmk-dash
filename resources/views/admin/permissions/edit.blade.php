@extends('layouts.app')

@section('title', 'Edit Permission')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissions</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Permission</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">
                        Edit Permission: {{ $permission->name }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permission Information</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('permissions.update', $permission) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $permission->name) }}" placeholder="Enter permission name">
                            <small class="form-hint">Use kebab-case format (e.g., user-create, product-edit, etc.)</small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <a href="{{ route('permissions.index') }}" class="btn btn-link">Cancel</a>
                                <button type="submit" class="btn btn-primary ms-auto">Update Permission</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Roles using this Permission</h3>
                </div>
                <div class="card-body">
                    @if($permission->roles->isNotEmpty())
                        @foreach($permission->roles as $role)
                            <span class="badge bg-{{ $role->name === 'Administrator' ? 'red' : ($role->name === 'Foreman' ? 'blue' : ($role->name === 'Supervisor' ? 'green' : 'yellow')) }}-lt mb-2">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    @else
                        <div class="text-muted">No roles are using this permission.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
