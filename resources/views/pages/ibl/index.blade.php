@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">IBL</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data IBL</li>
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
                                    <h6 class="card-title">Data IBL</h6>
                                </div>
                                <div>
                                    <a href="{{ route('ibl-imun.create') }}" class="btn btn-primary mb-1 mb-md-0">+
                                        IBL</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="dataTableExample" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Desa</th>
                                            <th>Nama Bayi</th>
                                            <th>NIK</th>
                                            <th>Tgl Lahir</th>
                                            <th>Jenkel</th>
                                            <th>Nama Ibu</th>
                                            <th>Riwayat</th>
                                            <th>Status</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ibls as $index => $ibl)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td style="white-space: normal">{{ $ibl->name }}</td>
                                                <td style="white-space: normal">{{ $ibl->name_child }}</td>
                                                <td style="white-space: normal">{{ $ibl->nik }}</td>
                                                <td style="white-space: normal">{{ date('j F Y', strtotime($ibl->date_birth)) }}</td>
                                                <td>{{ $ibl->gender }}</td>
                                                <td style="white-space: normal">{{ $ibl->mother_name }}</td>
                                                <td style="white-space: normal">
                                                    {{ $ibl->pcv3 ? 'pcv3,' : '' }}
                                                    {{ $ibl->penta4 ? 'penta4,' : '' }}
                                                    {{ $ibl->mr2 ? 'mr2,' : '' }}
                                                </td>
                                                <td>
                                                    @if ($ibl->lengkap == '0')
                                                        <button type="button" class="btn btn-inverse-warning btn-xs">Belum</button>
                                                    @else
                                                        <button type="button" class="btn btn-inverse-danger btn-xs">Lengkap</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('ibl-imun.edit', $ibl->id) }}" title="Edit">
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
