@extends('layouts.app')

@section('title', 'Create Permission')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissions</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Permission</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">
                        Create Permission
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
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" placeholder="Enter permission name (e.g., user-create)">
                            <small class="form-hint">Use kebab-case format (e.g., user-create, product-edit, etc.)</small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <a href="{{ route('permissions.index') }}" class="btn btn-link">Cancel</a>
                                <button type="submit" class="btn btn-primary ms-auto">Create Permission</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permission Guidelines</h3>
                </div>
                <div class="card-body">
                    <div class="text-muted">
                        <p><strong>Naming Convention:</strong></p>
                        <p>Use kebab-case format: <code>resource-action</code></p>
                        
                        <p><strong>Examples:</strong></p>
                        <ul class="mb-0">
                            <li><code>user-list</code> - View users</li>
                            <li><code>user-create</code> - Create users</li>
                            <li><code>user-edit</code> - Edit users</li>
                            <li><code>user-delete</code> - Delete users</li>
                            <li><code>dashboard-view</code> - Access dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
