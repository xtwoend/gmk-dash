@extends('layouts.app')

@section('title', 'Dashboard')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">Welcome back, {{ $user->name }}</div>
                    <h2 class="page-title">Dashboard</h2>
                </div>
                @if(isset($message))
                <div class="col-12">
                    <div class="alert alert-info">
                        {{ $message }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-deck row-cards">
        <!-- Quick Stats -->
        <div class="col-12">
            <div class="row row-cards">
                @can('device-list')
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-primary text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <rect width="18" height="14" x="3" y="5" rx="2"/>
                                            <path d="M7 15v-6h2l2 3l2-3h2v6"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">Devices</div>
                                    <div class="text-muted">Manage production devices</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                
                @can('shift-list')
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-green text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <circle cx="12" cy="12" r="9"/>
                                            <path d="M12 7v5l3 3"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">Shifts</div>
                                    <div class="text-muted">Work schedule management</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                
                @can('activity-list')
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-orange text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <rect width="7" height="7" x="14" y="3" rx="1"/>
                                            <path d="M10 21v-4a2 2 0 0 0-2-2h-5"/>
                                            <path d="M3 15h6a2 2 0 0 1 2 2v4"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">Activities</div>
                                    <div class="text-muted">Production activities</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                
                @can('verification-list')
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-blue text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M9 12l2 2l4-4"/>
                                            <path d="M21 12c-1.5-4.5-6-7-9-7s-7.5 2.5-9 7c1.5 4.5 6 7 9 7s7.5-2.5 9-7"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">Verifications</div>
                                    <div class="text-muted">Quality control checks</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @can('device-list')
                        <div class="col-6 col-sm-4 col-lg-2 mb-3">
                            <a href="{{ route('devices.index') }}" class="btn btn-outline-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="14" x="3" y="5" rx="2"/>
                                    <path d="M7 15v-6h2l2 3l2-3h2v6"/>
                                </svg>
                                <br>Devices
                            </a>
                        </div>
                        @endcan
                        
                        @can('shift-list')
                        <div class="col-6 col-sm-4 col-lg-2 mb-3">
                            <a href="{{ route('shifts.index') }}" class="btn btn-outline-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 7v5l3 3"/>
                                </svg>
                                <br>Shifts
                            </a>
                        </div>
                        @endcan
                        
                        @can('startup-list')
                        <div class="col-6 col-sm-4 col-lg-2 mb-3">
                            <a href="{{ route('startups.index') }}" class="btn btn-outline-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0-18 0"/>
                                    <path d="M8 12l2 2l4-4"/>
                                </svg>
                                <br>Startups
                            </a>
                        </div>
                        @endcan
                        
                        @can('user-list')
                        <div class="col-6 col-sm-4 col-lg-2 mb-3">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M7 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0-8 0"/>
                                    <path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    <path d="M21 21v-2a4 4 0 0 0-3-3.85"/>
                                </svg>
                                <br>Users
                            </a>
                        </div>
                        @endcan
                        
                        @can('role-list')
                        <div class="col-6 col-sm-4 col-lg-2 mb-3">
                            <a href="{{ route('roles.index') }}" class="btn btn-outline-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0-4 0"/>
                                    <path d="M8 21v-1a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1"/>
                                    <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0-4 0"/>
                                    <path d="M17 10h2a2 2 0 0 1 2 2v1"/>
                                    <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0-4 0"/>
                                    <path d="M3 13v-1a2 2 0 0 1 2-2h2"/>
                                </svg>
                                <br>Roles
                            </a>
                        </div>
                        @endcan
                        
                        @can('permission-list')
                        <div class="col-6 col-sm-4 col-lg-2 mb-3">
                            <a href="{{ route('permissions.index') }}" class="btn btn-outline-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                                <br>Permissions
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
