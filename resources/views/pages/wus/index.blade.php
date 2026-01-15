@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">WUS</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data WYS</li>
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
                                    <h6 class="card-title">Data WUS</h6>
                                </div>
                                <div>
                                    <a href="{{ route('wus.create') }}" class="btn btn-primary mb-1 mb-md-0">+
                                        WUS</a>
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
                                            <th>Hamil</th>
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
                                                    @if ($wus->hamil == '0')
                                                        <button type="button" class="btn btn-inverse-warning btn-xs">Tidak</button>
                                                    @else
                                                        <button type="button" class="btn btn-inverse-danger btn-xs">Ya</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('wus.edit', $wus->id) }}" title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('wus.destroy', $wus->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Hapus" style="border: none; background: none; padding: 0; color: red; cursor: pointer;" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
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

