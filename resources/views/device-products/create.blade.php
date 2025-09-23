@extends('layouts.app')

@section('title', 'Assign Product to Device')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Device Products</div>
                    <h2 class="page-title">Assign Product to Device</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
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
                <form action="{{ route('device-products.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product Assignment Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Device</label>
                                        <select name="device_id" class="form-select @error('device_id') is-invalid @enderror" required>
                                            <option value="">Select Device</option>
                                            @foreach($devices as $device)
                                                <option value="{{ $device->id }}" {{ old('device_id') == $device->id ? 'selected' : '' }}>
                                                    {{ $device->name }} ({{ $device->type }} - {{ $device->location }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('device_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-hint">Select the device to assign a product to.</small>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Product Code</label>
                                        <input type="text" 
                                               name="product_code" 
                                               class="form-control @error('product_code') is-invalid @enderror" 
                                               value="{{ old('product_code') }}" 
                                               placeholder="Enter product code" 
                                               required>
                                        @error('product_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-hint">Enter the product code to assign to the selected device.</small>
                                    </div>
                                </div>
                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <div class="d-flex">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <circle cx="12" cy="12" r="9"/>
                                                <path d="m9 12l2 2l4 -4"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="alert-title">Please fix the following errors:</h4>
                                            <div class="text-muted">
                                                <ul class="mb-0">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <a href="{{ route('device-products.index') }}" class="btn btn-outline-secondary me-auto">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 5l0 14"/>
                                        <path d="M5 12l14 0"/>
                                    </svg>
                                    Assign Product
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection