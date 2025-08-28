@extends('layouts.app')

@section('title', 'Edit Shift')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('shifts.index') }}">Shifts</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">Edit Shift</h2>
                    <div class="text-muted mt-1">{{ $shift->name }}</div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('shifts.show', $shift) }}" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                            </svg>
                            View Shift
                        </a>
                        <a href="{{ route('shifts.index') }}" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 12l14 0"/>
                                <path d="M5 12l6 6"/>
                                <path d="M5 12l6 -6"/>
                            </svg>
                            Back to Shifts
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
                    <h3 class="card-title">Shift Information</h3>
                    <div class="card-actions">
                        @if($shift->isCurrentlyActive())
                            <span class="badge bg-success">Currently Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>
                </div>
                
                <form method="POST" action="{{ route('shifts.update', $shift) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label required" for="name">Shift Name</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $shift->name) }}" 
                                           placeholder="e.g., Morning Shift, Night Shift"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-hint">Choose a descriptive name for this shift</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required" for="start_time">Start Time</label>
                                    <input type="time" 
                                           class="form-control @error('start_time') is-invalid @enderror" 
                                           id="start_time" 
                                           name="start_time" 
                                           value="{{ old('start_time', \Carbon\Carbon::parse($shift->getRawOriginal('start_time'))->format('H:i')) }}" 
                                           required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required" for="end_time">End Time</label>
                                    <input type="time" 
                                           class="form-control @error('end_time') is-invalid @enderror" 
                                           id="end_time" 
                                           name="end_time" 
                                           value="{{ old('end_time', \Carbon\Carbon::parse($shift->getRawOriginal('end_time'))->format('H:i')) }}" 
                                           required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Current Duration</label>
                                    <div class="form-control-plaintext">{{ $shift->formatted_duration }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Status</label>
                                    <div class="form-control-plaintext">
                                        @if($shift->isCurrentlyActive())
                                            <span class="badge bg-success">Currently Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shift Metadata -->
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Created At</label>
                                    <div class="form-control-plaintext">{{ $shift->created_at->format('M d, Y \a\t H:i') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Last Updated</label>
                                    <div class="form-control-plaintext">{{ $shift->updated_at->format('M d, Y \a\t H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer text-end">
                        <div class="d-flex">
                            <a href="{{ route('shifts.show', $shift) }}" class="btn btn-link">Cancel</a>
                            <button type="submit" class="btn btn-primary ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 12l5 5l10 -10"/>
                                </svg>
                                Update Shift
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
