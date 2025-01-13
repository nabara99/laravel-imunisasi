@extends('layouts.app')

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Sekolah</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Sekolah</li>
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
                                    <h6 class="card-title">Data Sekolah</h6>
                                </div>
                                <div>
                                    <a href="{{ route('school.create') }}" class="btn btn-primary mb-1 mb-md-0">+
                                        Sekolah</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Sekolah</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($schools as $index => $school)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $school->name }}</td>
                                                <td>
                                                    <a href="{{ route('school.edit', $school->id) }}" title="Edit">
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
