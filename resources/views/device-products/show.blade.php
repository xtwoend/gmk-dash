@extends('layouts.app')

@section('title', 'Device Product Details')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Device Products</div>
                    <h2 class="page-title">Device Product Details</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('device-products.edit', $deviceProduct) }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                <path d="M16 5l3 3"/>
                            </svg>
                            Edit
                        </a>
                        <a href="{{ route('device-products.index') }}" class="btn btn-outline-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 12l14 0"/>
                                <path d="M12 5l7 7l-7 7"/>
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Device Product Assignment #{{ $deviceProduct->id }}</h3>
                        <div class="card-actions">
                            <span class="badge bg-blue-lt">Active Assignment</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Assignment ID</label>
                                    <div class="form-control-plaintext">
                                        <strong>#{{ $deviceProduct->id }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Product Code</label>
                                    <div class="form-control-plaintext">
                                        <span class="badge bg-blue-lt fs-6">{{ $deviceProduct->product_code }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Created Date</label>
                                    <div class="form-control-plaintext">
                                        {{ $deviceProduct->created_at->format('F d, Y \a\t H:i') }}
                                        <small class="text-muted d-block">{{ $deviceProduct->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Updated</label>
                                    <div class="form-control-plaintext">
                                        {{ $deviceProduct->updated_at->format('F d, Y \a\t H:i') }}
                                        <small class="text-muted d-block">{{ $deviceProduct->updated_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Device Information Card -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Assigned Device Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Device Name</label>
                                    <div class="form-control-plaintext">
                                        <strong>{{ $deviceProduct->device->name }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Device Type</label>
                                    <div class="form-control-plaintext">
                                        {{ $deviceProduct->device->type }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Location</label>
                                    <div class="form-control-plaintext">
                                        {{ $deviceProduct->device->location }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-control-plaintext">
                                        {!! $deviceProduct->device->status_badge !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($deviceProduct->device->handler)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Handler</label>
                                        <div class="form-control-plaintext">
                                            {{ $deviceProduct->device->handler }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-3">
                            <a href="{{ route('devices.show', $deviceProduct->device) }}" class="btn btn-outline-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="12" cy="12" r="2"/>
                                    <path d="M22 12c-2.667 4 -6 6 -10 6s-7.333 -2 -10 -6c2.667 -4 6 -6 10 -6s7.333 2 10 6"/>
                                </svg>
                                View Device Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="btn-list">
                            <a href="{{ route('device-products.edit', $deviceProduct) }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                    <path d="M16 5l3 3"/>
                                </svg>
                                Edit Assignment
                            </a>
                            <form action="{{ route('device-products.destroy', $deviceProduct) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this device product assignment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 7l16 0"/>
                                        <path d="M10 11l0 6"/>
                                        <path d="M14 11l0 6"/>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                    </svg>
                                    Delete Assignment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection