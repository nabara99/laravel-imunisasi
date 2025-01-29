@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">TT WUS</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data TT WUS</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col 8"></div>
                <div class="col-4">
                    @include('layouts.alert')
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h6 class="card-title">Data TT WUS</h6>
                                </div>
                                <div>
                                    <a href="{{ route('tt-imun.create') }}" class="btn btn-primary mb-1 mb-md-0">+
                                        TT</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="dataTableExample" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Desa</th>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>Tgl Lahir</th>
                                            <th>Riwayat</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wuses as $index => $wus)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td style="white-space: normal">{{ $wus->name }}</td>
                                                <td style="white-space: normal">{{ $wus->name_wus }}</td>
                                                <td style="white-space: normal">{{ $wus->nik }}</td>
                                                <td style="white-space: normal">{{ date('j F Y', strtotime($wus->date_birth)) }}</td>
                                                <td style="white-space: normal">
                                                    {{ $wus->t1 ? 't1' : '' }}{{ $wus->t1_status == 1 ? '[hamil],' : '' }}
                                                    {{ $wus->t2 ? 't2' : '' }}{{ $wus->t2_status == 1 ? '[hamil],' : '' }}
                                                    {{ $wus->t3 ? 't3' : '' }}{{ $wus->t3_status == 1 ? '[hamil],' : '' }}
                                                    {{ $wus->t4 ? 't4' : '' }}{{ $wus->t4_status == 1 ? '[hamil],' : '' }}
                                                    {{ $wus->t5 ? 't5' : '' }}{{ $wus->t5_status == 1 ? '[hamil],' : '' }}
                                                </td>
                                                {{-- <td>
                                                    @if ($wus->hamil == '0')
                                                        <button type="button" class="btn btn-inverse-warning btn-xs">Tidak</button>
                                                    @else
                                                        <button type="button" class="btn btn-inverse-danger btn-xs">Ya</button>
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    <a href="{{ route('tt-imun.edit', $wus->id) }}" title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
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
