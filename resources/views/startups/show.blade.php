@extends('layouts.app')

@section('title', 'Startup Details')

@section('header')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('startups.report') }}" class="text-muted">
                        ← Back to Reports
                    </a>
                </div>
                <h2 class="page-title">
                    Startup Details
                </h2>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <!-- Basic Information -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Basic Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Device</label>
                            <div class="form-control-plaintext">
                                <strong>{{ $startup->device->name }}</strong>
                                <div class="text-muted small">{{ $startup->device->location }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Operator</label>
                            <div class="form-control-plaintext">
                                <div class="d-flex align-items-center">
                                    <span class="avatar me-2" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($startup->user->name ?? 'Unknown') }}&background=random')"></span>
                                    <strong>{{ $startup->user->name ?? 'Unknown' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Startup Date</label>
                            <div class="form-control-plaintext">
                                {{ Carbon\Carbon::parse($startup->startup_date)->format('d F Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-control-plaintext">
                                @switch($startup->status)
                                    @case(1)
                                        Active
                                        @break
                                    @case(2)
                                        Paused
                                        @break
                                    @case(3)
                                        Completed
                                        @break
                                    @default
                                        Starting
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Verification Type</label>
                            <div class="form-control-plaintext">
                                {{ $startup->verification_type == 'hourly' ? 'Per Jam' : 'Per Batch' }}
                            </div>
                        </div>
                    </div>
                    @if($startup->status == 2 && $startup->pause_reason)
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Pause Reason</label>
                            <div class="form-control-plaintext">
                                {{ $startup->pause_reason }}
                                @if($startup->pause_time)
                                    <div class="text-muted small">
                                        Paused at: {{ Carbon\Carbon::parse($startup->pause_time)->format('M d, Y H:i') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Statistics</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">OK Records</span>
                                <span class="text-green h3 mb-0">{{ number_format($startup->ok_count) }}</span>
                            </div>
                            <div class="progress progress-sm">
                                @php
                                    $total = $startup->ok_count + $startup->ng_count;
                                    $okPercent = $total > 0 ? ($startup->ok_count / $total) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-green" style="width: {{ $okPercent }}%" aria-valuenow="{{ $okPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">NG Records</span>
                                <span class="text-red h3 mb-0">{{ number_format($startup->ng_count) }}</span>
                            </div>
                            <div class="progress progress-sm">
                                @php
                                    $ngPercent = $total > 0 ? ($startup->ng_count / $total) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-red" style="width: {{ $ngPercent }}%" aria-valuenow="{{ $ngPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Total Records</span>
                                <span class="h3 mb-0">{{ number_format($total) }}</span>
                            </div>
                        </div>
                    </div>
                    @if($total > 0)
                    <div class="col-12">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Success Rate</span>
                                <span class="h3 mb-0 text-green">{{ number_format($okPercent, 1) }}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activities -->
@if($startup->verifications->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Verifikasi Startup</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center align-middle">Jam</th>
                            <th rowspan="2" class="text-center align-middle">Keterangan</th>
                            <th colspan="3" class="text-center">Verifikasi</th>
                            <th class="text-center">Dibuat oleh</th>
                            <th class="text-center">Divalidasi oleh</th>
                            <th rowspan="2" class="text-center align-middle">Tindakan Koreksi jika MD error<br>(Input No. WOR)</th>
                        </tr>
                        <tr>
                            <th class="text-center">Fe</th>
                            <th class="text-center">Non Fe</th>
                            <th class="text-center">SS</th>
                            <th class="text-center">Nama Operator</th>
                            <th class="text-center">Nama Foreman</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic rows from database -->
                        @foreach($startup->verifications as $verification)
                        <tr>
                            <td class="text-center">
                                <div class="text-muted small">
                                    {{ $verification->created_at->format('H:i') }}
                                </div>
                            </td>
                            <td>
                                {{ $verification->type }}
                            </td>
                            <td class="text-center">
                                {!! $verification->fe == 1 ? '&#x2705;' : 'X' !!}
                            </td>
                            <td class="text-center">
                                {!! $verification->non_fe == 1 ? '&#x2705;' : 'X' !!}
                            </td>
                            <td class="text-center">
                                {!! $verification->ss == 1 ? '&#x2705;' : 'X' !!}
                            </td>
                            <td class="text-center">
                                {{ $startup->user->name ?? 'Unknown' }}
                            </td>
                            <td class="text-center">
                                {{ $verification->foreman?->name ?? '' }}
                            </td>
                            <td class="text-center">
                                {{ $verification->wor }} {{ $verification->remarks ?? '' }} 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Kondisi Sensitif Produk Table untuk verifikasi per jam--> 
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Verifikasi Produksi</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="3" class="text-center align-middle" style="min-width: 50px;">No</th>
                            <th rowspan="3" class="text-center align-middle" style="min-width: 80px;">Shift</th>
                            <th rowspan="3" class="text-center align-middle" style="min-width: 100px;">Jam</th>
                            <th rowspan="3" class="text-center align-middle" style="min-width: 150px;">Nama Produk</th>
                            <th rowspan="3" class="text-center align-middle" style="min-width: 100px;">BN</th>
                            <th rowspan="3" class="text-center align-middle" style="min-width: 120px;">Satuan Kemasan</th>
                            <th colspan="9" class="text-center" style="background-color: #f8f9fa;">Kondisi Sensitif Produk</th>
                            <th colspan="2" class="text-center" style="background-color: #e3f2fd;">Jumlah</th>
                            <th rowspan="3" class="text-center align-middle" style="background-color: #fff3e0;">Dibuat oleh</th>
                            <th rowspan="3" class="text-center align-middle" style="background-color: #f3e5f5;">Divalidasi oleh</th>
                            <th rowspan="3" class="text-center align-middle" style="min-width: 200px;">Tindakan Koreksi Untuk Produk NOT OK</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-center" style="background-color: #ffebee;">Fe</th>
                            <th colspan="3" class="text-center" style="background-color: #e8f5e8;">Non Fe</th>
                            <th colspan="3" class="text-center" style="background-color: #fff8e1;">SS</th>
                            <th rowspan="2" class="text-center align-middle" style="background-color: #e3f2fd; min-width: 120px;">Jumlah Produk OK</th>
                            <th rowspan="2" class="text-center align-middle" style="background-color: #e3f2fd; min-width: 120px;">Produk NOT OK</th>
                        </tr>
                        <tr>
                            <th class="text-center" style="background-color: #ffebee; min-width: 80px;">ujung depan</th>
                            <th class="text-center" style="background-color: #ffebee; min-width: 80px;">ujung tengah</th>
                            <th class="text-center" style="background-color: #ffebee; min-width: 80px;">ujung belakang</th>
                            <th class="text-center" style="background-color: #e8f5e8; min-width: 80px;">ujung depan</th>
                            <th class="text-center" style="background-color: #e8f5e8; min-width: 80px;">ujung tengah</th>
                            <th class="text-center" style="background-color: #e8f5e8; min-width: 80px;">ujung belakang</th>
                            <th class="text-center" style="background-color: #fff8e1; min-width: 80px;">ujung depan</th>
                            <th class="text-center" style="background-color: #fff8e1; min-width: 80px;">ujung tengah</th>
                            <th class="text-center" style="background-color: #fff8e1; min-width: 80px;">ujung belakang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Add more empty rows as needed -->
                        @foreach($startup->activities()->orderBy('created_at')->get() as $activity)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $activity->shift }}</td>
                            <td class="text-center">{{ $activity->activity_date->format('H:i') }}</td>
                            <td>{{ $activity->product?->product_name }}</td>
                            <td>{{ $activity->product?->batch_number }}</td>
                            <td>{{ $activity->product?->unit }}</td>
                            <!-- Fe columns -->
                            <td class="text-center">{!! $activity->fe_front == 1 ? '&#x2705;' : 'X' !!}</td>
                            <td class="text-center">{!! $activity->fe_middle == 1 ? '&#x2705;' : 'X' !!}</td>
                            <td class="text-center">{!! $activity->fe_back == 1 ? '&#x2705;' : 'X' !!}</td>
                            <!-- Non Fe columns -->
                            <td class="text-center">{!! $activity->non_fe_front == 1 ? '&#x2705;' : 'X' !!}</td>
                            <td class="text-center">{!! $activity->non_fe_middle == 1 ? '&#x2705;' : 'X' !!}</td>
                            <td class="text-center">{!! $activity->non_fe_back == 1 ? '&#x2705;' : 'X' !!}</td>
                            <!-- SS columns -->
                            <td class="text-center">{!! $activity->ss_front == 1 ? '&#x2705;' : 'X' !!}</td>
                            <td class="text-center">{!! $activity->ss_middle == 1 ? '&#x2705;' : 'X' !!}</td>
                            <td class="text-center">{!! $activity->ss_back == 1 ? '&#x2705;' : 'X' !!}</td>
                            <!-- Jumlah -->
                            <td class="text-center">{{ $activity->recheck_qty }}</td>
                            <td class="text-center">{{ $activity->ng_qty }}</td>
                            <!-- Created by -->
                            <td class="text-center">{{ $activity->user?->name }}</td>
                            <!-- Validated by -->
                            <td class="text-center">{{ $activity->foreman?->name }}</td>
                            <!-- Action -->
                            <td class="text-center">-</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Action Report Table -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Product Terdeteksi Metal Detektor</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center align-middle" style="min-width: 80px;">Datetime</th>
                            <th rowspan="2" class="text-center align-middle" style="min-width: 150px;">Product Name</th>
                            <th rowspan="2" class="text-center align-middle" style="min-width: 100px;">BN</th>
                            <th rowspan="2" class="text-center align-middle" style="min-width: 80px;">Status</th>
                            <th colspan="3" class="text-center" style="background-color: #f8f9fa;">Tindakan</th>
                            <th rowspan="2" class="text-center align-middle" style="min-width: 120px;">Operator</th>
                            <th rowspan="2" class="text-center align-middle" style="min-width: 120px;">QA</th>
                        </tr>
                        <tr>
                            <th class="text-center" style="background-color: #f8f9fa; min-width: 100px;">Telah di Laporkan</th>
                            <th class="text-center" style="background-color: #f8f9fa; min-width: 100px;">Telah Pisahkan</th>
                            <th class="text-center" style="background-color: #f8f9fa; min-width: 100px;">Telah di Karantina</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample data rows - replace with actual data -->
                        @foreach($startup->records as $record)
                        <tr>
                            <td class="text-center">{{ $record->record_time->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $record->product?->product_name }}</td>
                            <td>{{ $record->product?->batch_number }}</td>
                            <td class="text-center">
                                <span class="badge bg-green">OK</span>
                            </td>
                            <td class="text-center">{!! $record->is_reported ? '&#x2705;' : '' !!}</td>
                            <td class="text-center">{!! $record->is_separated ? '&#x2705;' : '' !!}</td>
                            <td class="text-center">{!! $record->is_quarantined ? '&#x2705;' : '' !!}</td>

                            <td class="text-center">{{ $record->startup?->user?->name }}</td>
                            <td class="text-center">{{ $record->qa?->name }}</td>
                        </tr>
                        @endforeach
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
