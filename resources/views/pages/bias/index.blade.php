@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">BIAS</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data BIAS</li>
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
                                    <h6 class="card-title">Data BIAS</h6>
                                </div>
                                <div>
                                    <a href="{{ route('bias.create') }}" class="btn btn-primary mb-1 mb-md-0">+
                                        BIAS</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="dataTableExample" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Sekolah</th>
                                            <th>Nama Siswa</th>
                                            <th>NIK</th>
                                            <th>Kelas</th>
                                            <th>Jenkel</th>
                                            <th>Riwayat</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $index => $student)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td style="white-space: normal">{{ $student->name }}</td>
                                                <td style="white-space: normal">{{ $student->name_student }}</td>
                                                <td style="white-space: normal">{{ $student->nik }}</td>
                                                <td style="white-space: normal">{{ $student->class }}</td>
                                                <td style="white-space: normal">{{ $student->gender }}</td>
                                                <td style="white-space: normal">
                                                    {{ $student->dt ? 'DT,' : '' }}
                                                    {{ $student->mr ? 'MR,' : '' }}
                                                    {{ $student->td1 ? 'TD1,' : '' }}
                                                    {{ $student->td2pa ? 'TD2,' : '' }}
                                                    {{ $student->td2pi ? 'TD2,' : '' }}
                                                    {{ $student->hpv1 ? 'HPV1,' : '' }}
                                                    {{ $student->hpv2 ? 'HPV2,' : '' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('bias.edit', $student->id) }}" title="Edit">
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
