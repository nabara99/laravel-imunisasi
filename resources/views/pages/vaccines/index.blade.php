@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Inventori Vaksin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Master Vaksin</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-8"></div>
                <div class="col-4">
                    @include('layouts.alert')
                </div>

                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h6 class="card-title">Master Data Vaksin</h6>
                                    <p class="text-muted mb-0">Daftar semua vaksin yang tersimpan dalam sistem</p>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="dataTableExample" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%">No.</th>
                                            <th>Nama Vaksin</th>
                                            <th>Kategori</th>
                                            <th>Batch</th>
                                            <th>Expired</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vaccines as $index => $vaccine)
                                            @php
                                                $isExpired = $vaccine->expired_date->isPast();
                                                $isExpiringSoon = $vaccine->expired_date->diffInDays(now()) <= 30 && !$isExpired;
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $vaccine->vaccine_name }}</td>
                                                <td>{{ $vaccine->category->name }}</td>
                                                <td>{{ $vaccine->batch_number }}</td>
                                                <td>
                                                    @if($isExpired)
                                                        <span class="badge bg-danger">{{ $vaccine->expired_date->format('d/m/Y') }}</span>
                                                    @elseif($isExpiringSoon)
                                                        <span class="badge bg-warning">{{ $vaccine->expired_date->format('d/m/Y') }}</span>
                                                    @else
                                                        {{ $vaccine->expired_date->format('d/m/Y') }}
                                                    @endif
                                                </td>
                                                <td>Rp {{ number_format($vaccine->price) }}</td>
                                                <td>
                                                    @if($vaccine->stock == 0)
                                                        <span class="badge bg-secondary">0</span>
                                                    @elseif($vaccine->stock < 10)
                                                        <span class="badge bg-warning">{{ number_format($vaccine->stock) }}</span>
                                                    @else
                                                        <span class="badge bg-success">{{ number_format($vaccine->stock) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($isExpired)
                                                        <span class="badge bg-danger">Kadaluarsa</span>
                                                    @elseif($isExpiringSoon)
                                                        <span class="badge bg-warning">Segera Kadaluarsa</span>
                                                    @elseif($vaccine->stock == 0)
                                                        <span class="badge bg-secondary">Habis</span>
                                                    @else
                                                        <span class="badge bg-success">Tersedia</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('js/data-table.js') }}"></script>
@endpush
