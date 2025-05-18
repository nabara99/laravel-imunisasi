@extends('layouts.app')

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Sasaran Anak IBL</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Sasaran</li>
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
                                    <h6 class="card-title">Data Sasaran Anak IBL</h6>
                                </div>
                                <div>
                                    <a href="{{ route('ibl-target.create') }}" class="btn btn-primary mb-1 mb-md-0">+
                                        Sasaran</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Desa</th>
                                            <th>Jumlah Anak Laki-laki</th>
                                            <th>Jumlah Anak Perempuan</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($iblTargets as $index => $ibl)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $ibl->name }}</td>
                                                <td>{{ $ibl->sum_boys }}</td>
                                                <td>{{ $ibl->sum_girls }}</td>
                                                <td>
                                                    <a href="{{ route('ibl-target.edit', $ibl->id) }}" title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td style="text-align: center" colspan="2">Jumlah</td>
                                            <td>{{$sumBoys}}</td>
                                            <td>{{$sumGirls}}</td>
                                            <td>-</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
