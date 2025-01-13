@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Anak Sekolah</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Anak Sekolah</li>
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
                                    <h6 class="card-title">Data Anak Sekolah</h6>
                                </div>
                                <div>
                                    <a href="{{ route('child-sch.create') }}" class="btn btn-primary mb-1 mb-md-0">+
                                        Anak</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="dataTableExample" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Sekolah / Kelas</th>
                                            <th>Nama</th>
                                            <th>Tgl Lahir</th>
                                            <th>Gender</th>
                                            <th>NIK</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $index => $student)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $student->name }} / {{ $student->class }}</td>
                                                <td>{{ $student->name_student }}</td>
                                                <td style="white-space: normal">{{ date('j F Y', strtotime($student->birth_date )) }}</td>
                                                <td>{{ $student->gender }}</td>
                                                <td>{{ $student->nik }}</td>
                                                <td>
                                                    <a href="{{ route('child-sch.edit', $student->id) }}" title="Edit">
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
