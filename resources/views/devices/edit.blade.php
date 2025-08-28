@extends('layouts.app')

@section('title', 'Edit Device')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('devices.index') }}">Devices</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">Edit Device</h2>
                    <div class="text-muted mt-1">{{ $device->name ?: 'Unnamed Device' }}</div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('devices.show', $device) }}" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                            </svg>
                            View Device
                        </a>
                        <a href="{{ route('devices.index') }}" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 12l14 0"/>
                                <path d="M5 12l6 6"/>
                                <path d="M5 12l6 -6"/>
                            </svg>
                            Back to Devices
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Device Information</h3>
                    <div class="card-actions">
                        {!! $device->status_badge !!}
                    </div>
                </div>
                
                <form method="POST" action="{{ route('devices.update', $device) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label required" for="name">Device Name</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $device->name) }}" 
                                           placeholder="Enter device name"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="type">Device Type</label>
                                    <input type="text" 
                                           class="form-control @error('type') is-invalid @enderror" 
                                           id="type" 
                                           name="type" 
                                           value="{{ old('type', $device->type) }}" 
                                           placeholder="e.g., Machine name">
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="verification_type">Verification Type</label>
                                    <select class="form-select @error('verification_type') is-invalid @enderror" 
                                            id="verification_type" 
                                            name="verification_type">
                                        <option value="">Select verification type</option>
                                        <option value="hourly" {{ old('verification_type', $device->verification_type) == 'hourly' ? 'selected' : '' }}>Hourly</option>
                                        <option value="batch" {{ old('verification_type', $device->verification_type) == 'batch' ? 'selected' : '' }}>Batch</option>
                                    </select>
                                    @error('verification_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="location">Location</label>
                                    <input type="text" 
                                           class="form-control @error('location') is-invalid @enderror" 
                                           id="location" 
                                           name="location" 
                                           value="{{ old('location', $device->location) }}" 
                                           placeholder="e.g., Production Floor A, Room 101">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="handler">Device Handler</label>
                                    <input type="text" 
                                           class="form-control @error('handler') is-invalid @enderror" 
                                           id="handler" 
                                           name="handler" 
                                           value="{{ old('handler', $device->handler) }}" 
                                           placeholder="1 OR 115 message machine">
                                    @error('handler')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Device Status</label>
                                    <div class="form-selectgroup form-selectgroup-boxes d-flex">
                                        <label class="form-selectgroup-item flex-fill">
                                            <input type="checkbox" 
                                                   name="status" 
                                                   value="1" 
                                                   class="form-selectgroup-input"
                                                   {{ old('status', $device->status) ? 'checked' : '' }}>
                                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                                                <div class="me-3">
                                                    <span class="form-selectgroup-check"></span>
                                                </div>
                                                <div>
                                                    <strong>Active</strong>
                                                    <div class="text-muted">Device is operational and available</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Device Metadata -->
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Created At</label>
                                    <div class="form-control-plaintext">{{ $device->created_at->format('M d, Y \a\t H:i') }}</div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Last Updated</label>
                                    <div class="form-control-plaintext">{{ $device->updated_at->format('M d, Y \a\t H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer text-end">
                        <div class="d-flex">
                            <a href="{{ route('devices.show', $device) }}" class="btn btn-link">Cancel</a>
                            <button type="submit" class="btn btn-primary ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 12l5 5l10 -10"/>
                                </svg>
                                Update Device
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
