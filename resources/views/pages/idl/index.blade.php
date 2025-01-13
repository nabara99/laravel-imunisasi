@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">IDL</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data IDL</li>
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
                                    <h6 class="card-title">Data IDL</h6>
                                </div>
                                <div>
                                    <a href="{{ route('idl-imun.create') }}" class="btn btn-primary mb-1 mb-md-0">+
                                        IDL</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="dataTableExample" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
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
                                        @foreach ($idls as $index => $idl)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td style="white-space: normal">{{ $idl->name_child }}</td>
                                                <td style="white-space: normal">{{ $idl->nik }}</td>
                                                <td style="white-space: normal">{{ date('j F Y', strtotime($idl->date_birth)) }}</td>
                                                <td>{{ $idl->gender }}</td>
                                                <td style="white-space: normal">{{ $idl->mother_name }}</td>
                                                <td style="white-space: normal">
                                                    {{ $idl->hb0 ? 'hb0,' : '' }}
                                                    {{ $idl->bcg ? 'bcg,' : '' }}
                                                    {{ $idl->polio1 ? 'polio1,' : '' }}
                                                    {{ $idl->penta1 ? 'penta1,' : '' }}
                                                    {{ $idl->polio2 ? 'polio2,' : '' }}
                                                    {{ $idl->pcv1 ? 'pcv1,' : '' }}
                                                    {{ $idl->rotavirus1 ? 'rotavirus1,' : '' }}
                                                    {{ $idl->penta2 ? 'penta2,' : '' }}
                                                    {{ $idl->polio3 ? 'polio3,' : '' }}
                                                    {{ $idl->pcv2 ? 'pcv2,' : '' }}
                                                    {{ $idl->rotavirus2 ? 'rotavirus2,' : '' }}
                                                    {{ $idl->penta3 ? 'penta3,' : '' }}
                                                    {{ $idl->polio4 ? 'polio4,' : '' }}
                                                    {{ $idl->ipv1 ? 'ipv1,' : '' }}
                                                    {{ $idl->rotavirus3 ? 'rotavirus3,' : '' }}
                                                    {{ $idl->mr1 ? 'mr1,' : '' }}
                                                    {{ $idl->ipv2 ? 'ipv2,' : '' }}
                                                </td>
                                                <td>
                                                    @if ($idl->lengkap == '0')
                                                        <button type="button" class="btn btn-inverse-warning btn-xs">Belum</button>
                                                    @else
                                                        <button type="button" class="btn btn-inverse-danger btn-xs">Lengkap</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('idl-imun.edit', $idl->id) }}" title="Edit">
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
