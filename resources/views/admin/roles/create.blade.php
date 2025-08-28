@extends('layouts.app')

@section('title', 'Create Role')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Role</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">
                        Create Role
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
                    <h3 class="card-title">Role Information</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" placeholder="Enter role name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                                @foreach($permissions as $group => $groupPermissions)
                                    <div class="form-selectgroup-item mb-3">
                                        <div class="border rounded p-3">
                                            <h4 class="mb-2 text-capitalize">{{ $group }}</h4>
                                            <div class="row">
                                                @foreach($groupPermissions as $permission)
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-check">
                                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                                                   class="form-check-input" 
                                                                   {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                                            <span class="form-check-label">{{ $permission->name }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('permissions')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <a href="{{ route('roles.index') }}" class="btn btn-link">Cancel</a>
                                <button type="submit" class="btn btn-primary ms-auto">Create Role</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
