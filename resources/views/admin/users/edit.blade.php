@extends('layouts.app')

@section('title', 'Edit User')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">
                        Edit User: {{ $user->name }}
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
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $user->name) }}" placeholder="Enter full name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                                           value="{{ old('username', $user->username) }}" placeholder="Enter username">
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <div class="input-group input-group-flat">
                                        <input type="password" id="password-input" name="password" class="form-control @error('password') is-invalid @enderror" 
                                               placeholder="Leave blank to keep current password">
                                        <span class="input-group-text">
                                            <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip" id="toggle-password">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" id="eye-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                                </svg>
                                            </a>
                                        </span>
                                    </div>
                                    <small class="form-hint">Leave blank if you don't want to change the password.</small>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <div class="input-group input-group-flat">
                                        <input type="password" id="password-confirmation-input" name="password_confirmation" class="form-control" 
                                               placeholder="Confirm new password">
                                        <span class="input-group-text">
                                            <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip" id="toggle-password-confirmation">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" id="eye-icon-confirmation" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                                </svg>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Roles</label>
                                    <div class="form-selectgroup">
                                        @foreach($roles as $role)
                                            <label class="form-selectgroup-item">
                                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                                       class="form-selectgroup-input" 
                                                       {{ in_array($role->id, old('roles', $userRoles)) ? 'checked' : '' }}>
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
                                        <h3 class="card-title">User Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex py-1 align-items-center mb-3">
                                            <span class="avatar me-2" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random')"></span>
                                            <div class="flex-fill">
                                                <div class="font-weight-medium">{{ $user->name }}</div>
                                                <div class="text-muted">{{ $user->username }}</div>
                                            </div>
                                        </div>
                                        <div class="text-muted">
                                            <p><strong>Created:</strong> {{ $user->created_at->format('M d, Y') }}</p>
                                            <p><strong>Updated:</strong> {{ $user->updated_at->format('M d, Y') }}</p>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <h4>Current Roles</h4>
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-{{ $role->name === 'Administrator' ? 'red' : ($role->name === 'Foreman' ? 'blue' : ($role->name === 'Supervisor' ? 'green' : 'yellow')) }}-lt mb-1">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                            @if($user->roles->isEmpty())
                                                <span class="text-muted">No roles assigned</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <a href="{{ route('users.index') }}" class="btn btn-link">Cancel</a>
                                <button type="submit" class="btn btn-primary ms-auto">Update User</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Password
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password-input');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (togglePassword) {
            togglePassword.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    togglePassword.setAttribute('title', 'Hide password');
                    eyeIcon.innerHTML = `
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828"/>
                        <path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87"/>
                        <path d="M3 3l18 18"/>
                    `;
                } else {
                    passwordInput.type = 'password';
                    togglePassword.setAttribute('title', 'Show password');
                    eyeIcon.innerHTML = `
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                    `;
                }
            });
        }
        
        // Toggle Password Confirmation
        const togglePasswordConfirmation = document.getElementById('toggle-password-confirmation');
        const passwordConfirmationInput = document.getElementById('password-confirmation-input');
        const eyeIconConfirmation = document.getElementById('eye-icon-confirmation');
        
        if (togglePasswordConfirmation) {
            togglePasswordConfirmation.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (passwordConfirmationInput.type === 'password') {
                    passwordConfirmationInput.type = 'text';
                    togglePasswordConfirmation.setAttribute('title', 'Hide password');
                    eyeIconConfirmation.innerHTML = `
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828"/>
                        <path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87"/>
                        <path d="M3 3l18 18"/>
                    `;
                } else {
                    passwordConfirmationInput.type = 'password';
                    togglePasswordConfirmation.setAttribute('title', 'Show password');
                    eyeIconConfirmation.innerHTML = `
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                    `;
                }
            });
        }
    });
</script>
@endpush
