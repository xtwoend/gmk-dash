@extends('layouts.app')

@section('title', 'Device Products Management')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Management</div>
                    <h2 class="page-title">Product Message List</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('device-products.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 5l0 14"/>
                                <path d="M5 12l14 0"/>
                            </svg>
                            Assign Product to Device
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

<div class="row row-deck row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Device Products List</h3>
            </div>
            
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Device</th>
                            <th>Product Code</th>
                            <th>Created At</th>
                            <th class="w-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deviceProducts as $deviceProduct)
                            <tr>
                                <td>{{ $deviceProduct->id }}</td>
                                <td>
                                    <div class="d-flex py-1 align-items-center">
                                        <div class="flex-fill">
                                            <div class="font-weight-medium">{{ $deviceProduct->device->name }}</div>
                                            <div class="text-muted">{{ $deviceProduct->device->type }} - {{ $deviceProduct->device->location }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-blue-lt">{{ $deviceProduct->product_code }}</span>
                                </td>
                                <td>{{ $deviceProduct->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <a href="{{ route('device-products.show', $deviceProduct) }}" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                        <a href="{{ route('device-products.edit', $deviceProduct) }}" class="btn btn-sm btn-outline-secondary">
                                            Edit
                                        </a>
                                        <form action="{{ route('device-products.destroy', $deviceProduct) }}" method="POST" class="d-inline" 
                                                onsubmit="return confirm('Are you sure you want to delete this device product assignment?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="empty">
                                        <div class="empty-img">
                                            <img src="{{ asset('img/undraw_printing_invoices_5r4r.svg') }}" height="128" alt="">
                                        </div>
                                        <p class="empty-title">No device products found</p>
                                        <p class="empty-subtitle text-muted">
                                            Try assigning a product to a device or adjusting your search.
                                        </p>
                                        <div class="empty-action">
                                            <a href="{{ route('device-products.create') }}" class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M12 5l0 14"/>
                                                    <path d="M5 12l14 0"/>
                                                </svg>
                                                Assign your first product
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($deviceProducts->hasPages())
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">
                        Showing <span>{{ $deviceProducts->firstItem() }}</span> to <span>{{ $deviceProducts->lastItem() }}</span>
                        of <span>{{ $deviceProducts->total() }}</span> entries
                    </p>
                    <ul class="pagination m-0 ms-auto">
                        {{ $deviceProducts->links() }}
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection