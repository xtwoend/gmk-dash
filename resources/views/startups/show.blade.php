@extends('layouts.app')

@section('title', 'Report Details')

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
                    Report Details
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
                <h3 class="card-title">REKAP HASIL VERIFIKASI METAL DETECTION</h3>
                <div class="card-actions">
                    <h3>FRM-C3-5C.010 <span class="text-muted" style="font-size: 12px;">Rev 4</span></h3>
                </div>
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
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Pause Reason</label>
                            <div class="form-control-plaintext">
                                @if($startup->status == 2 && $startup->pause_reason)
                                    {{ $startup->pause_reason }}
                                    @if($startup->pause_time)
                                        <div class="text-muted small">
                                            Paused at: {{ Carbon\Carbon::parse($startup->pause_time)->format('M d, Y H:i') }}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
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
                                <span class="text-green h3 mb-0">{{ $okTotal = $startup->products->sum('ok_quantity') }}</span>
                            </div>
                            <div class="progress progress-sm">
                                @php
                                    $total = $startup->products->sum('target_quantity');
                                    $okPercent = $total > 0 ? ($okTotal / $total) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-green" style="width: {{ $okPercent }}%" aria-valuenow="{{ $okPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">NG Records</span>
                                <span class="text-red h3 mb-0">{{ $ngTotal = $startup->products->sum('ng_quantity') }}</span>
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
                                <span class="text-muted">Total Target</span>
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
                                {{ $verification->user->name ?? 'Unknown' }}
                            </td>
                            <td class="text-center">
                                @if($verification->foreman)
                                    {{ $verification->foreman?->name ?? '' }}
                                @else
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#verificationModal{{ $verification->id }}">
                                        Validasi
                                    </button>
                                @endif
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

@if($startup->products)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Product Terproses</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Nama Produk</th>
                            <th class="text-center">BN</th>
                            <th class="text-center">Satuan Kemasan</th>
                            <th class="text-center">Jumlah Target Product</th>
                            <th class="text-center">Jumlah Produk OK</th>
                            <th class="text-center">Jumlah Produk NOT OK</th>
                            <th class="text-center">Waktu Record</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($startup->products as $product)
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->batch_number }}</td>
                            <td class="text-center">{{ $product->unit }}</td>
                            <td class="text-center">{{ $product->target_quantity }}</td>
                            <td class="text-center">{{ $product->ok_quantity }}</td>
                            <td class="text-center">{{ $product->ng_quantity }}</td>
                            <td class="text-center">{{ $product->created_at }}</td>
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
                            <th rowspan="3" class="text-center align-middle" style="min-width: 150px;">Produk Massage</th>
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
                            <td>{{ $activity->product?->message }}</td>
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
                            <td class="text-center">
                                @if($activity->foreman)
                                    {{ $activity->foreman?->name }}
                                @else
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#activityModal{{ $activity->id }}">
                                        Validasi
                                    </button>
                                @endif
                            </td>
                            <!-- Action -->
                            <td class="text-center">
                                {{-- {{ $activity->product?->message }} --}}
                            </td>
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
                                @if($record->status > 0)
                                <span class="badge bg-danger">NG</span>
                                @else
                                <span class="badge bg-success">OK</span>
                                @endif
                            </td>
                            <td class="text-center">{!! $record->is_reported ? '&#x2705;' : '' !!}</td>
                            <td class="text-center">{!! $record->is_separated ? '&#x2705;' : '' !!}</td>
                            <td class="text-center">{!! $record->is_quarantined ? '&#x2705;' : '' !!}</td>

                            <td class="text-center">{{ $record->startup?->user?->name }}</td>
                            <td class="text-center">
                                @if($record->qa)
                                    {{ $record->qa?->name }}
                                @else
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#recordModal{{ $record->id }}">
                                        Validasi
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modals for Verification -->
@foreach($startup->verifications as $verification)
@if(!$verification->foreman)
<div class="modal fade" id="verificationModal{{ $verification->id }}" tabindex="-1" aria-labelledby="verificationModalLabel{{ $verification->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('startups.verification-confirm') }}" method="POST">
                @csrf
                <input type="hidden" name="verification_id" value="{{ $verification->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="verificationModalLabel{{ $verification->id }}">Validasi Verifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jam: {{ $verification->created_at->format('H:i') }}</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan: {{ $verification->type }}</label>
                    </div>
                    <div class="mb-3">
                        <label for="note{{ $verification->id }}" class="form-label">Catatan</label>
                        <textarea class="form-control" id="note{{ $verification->id }}" name="remarks" rows="3" placeholder="Masukkan catatan (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Validasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach

<!-- Modals for Activity -->
@foreach($startup->activities()->orderBy('created_at')->get() as $activity)
@if(!$activity->foreman)
<div class="modal fade" id="activityModal{{ $activity->id }}" tabindex="-1" aria-labelledby="activityModalLabel{{ $activity->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('startups.activity-confirm') }}" method="POST">
                @csrf
                <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="activityModalLabel{{ $activity->id }}">Validasi Aktivitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Shift: {{ $activity->shift }}</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam: {{ $activity->activity_date->format('H:i') }}</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Produk: {{ $activity->product?->product_name }}</label>
                    </div>
                    <div class="mb-3">
                        <label for="activityNote{{ $activity->id }}" class="form-label">Catatan</label>
                        <textarea class="form-control" id="activityNote{{ $activity->id }}" name="remarks" rows="3" placeholder="Masukkan catatan (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Validasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach

<!-- Modals for Records -->
@foreach($startup->records as $record)
@if(!$record->qa)
<div class="modal fade" id="recordModal{{ $record->id }}" tabindex="-1" aria-labelledby="recordModalLabel{{ $record->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('startups.ng-confirm') }}" method="POST">
                @csrf
                <input type="hidden" name="record_id" value="{{ $record->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="recordModalLabel{{ $record->id }}">Validasi Record NG</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Waktu: {{ $record->record_time->format('Y-m-d H:i:s') }}</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Produk: {{ $record->product?->product_name }}</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">BN: {{ $record->product?->batch_number }}</label>
                    </div>
                    <div class="mb-3">
                        <label for="recordNote{{ $record->id }}" class="form-label">Catatan</label>
                        <textarea class="form-control" id="recordNote{{ $record->id }}" name="remarks" rows="3" placeholder="Masukkan catatan (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Validasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection
