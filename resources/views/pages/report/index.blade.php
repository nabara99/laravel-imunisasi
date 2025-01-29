@extends('layouts.app')

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rekap Imunisasi</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-12 col-md-6 grid-margin">
                    <div class="card text-white bg-primary">
                        <div class="card-header">Cakupan IDL</div>
                        <div class="card-body">
                            <form action="{{ route('report-idl') }}" method="POST" target="blank">
                                @csrf
                                <h5 class="card-title text-white">
                                    Pilih tanggal
                                </h5>
                                <p class="card-text">
                                <div class="row">
                                    <div class="col-6">
                                        Tanggal awal
                                        <input type="date" id="start_date" class="form-control" name="start_date"
                                            required>
                                    </div>
                                    <div class="col-6">
                                        Tanggal akhir
                                        <input type="date" id="end_date" class="form-control" name="end_date" required>
                                    </div>
                                </div> <br>
                                <button type="submit" class="btn btn-primary">
                                    <i class="link-icon" data-feather="printer"></i>
                                    <span class="link-title">Cetak</span>
                                </button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 grid-margin">
                    <div class="card bg-info">
                        <div class="card-header">Cakupan IBL</div>
                        <div class="card-body">
                            <form action="" method="POST" target="blank">
                                @csrf
                                <h5 class="card-title">
                                    Pilih tanggal
                                </h5>
                                <p class="card-text">
                                <div class="row">
                                    <div class="col-6">
                                        Tanggal awal
                                        <input type="date" id="start_date" class="form-control" name="start_date"
                                            required>
                                    </div>
                                    <div class="col-6">
                                        Tanggal akhir
                                        <input type="date" id="end_date" class="form-control" name="end_date" required>
                                    </div>
                                </div> <br>
                                <button type="submit" class="btn btn-info">
                                    <i class="link-icon" data-feather="printer"></i>
                                    <span class="link-title">Cetak</span>
                                </button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 grid-margin">
                    <div class="card text-white bg-dark">
                        <div class="card-header">Cakupan BIAS</div>
                        <div class="card-body">
                            <form action="" method="POST" target="blank">
                                @csrf
                                <h5 class="card-title text-white">
                                    Pilih tanggal
                                </h5>
                                <p class="card-text">
                                <div class="row">
                                    <div class="col-6">
                                        Tanggal awal
                                        <input type="date" id="start_date" class="form-control" name="start_date"
                                            required>
                                    </div>
                                    <div class="col-6">
                                        Tanggal akhir
                                        <input type="date" id="end_date" class="form-control" name="end_date" required>
                                    </div>
                                </div> <br>
                                <button type="submit" class="btn btn-dark">
                                    <i class="link-icon" data-feather="printer"></i>
                                    <span class="link-title">Cetak</span>
                                </button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 grid-margin">
                    <div class="card text-white bg-secondary">
                        <div class="card-header">Cakupan WUS</div>
                        <div class="card-body">
                            <form action="" method="POST" target="blank">
                                @csrf
                                <h5 class="card-title text-white">
                                    Pilih tanggal
                                </h5>
                                <p class="card-text">
                                <div class="row">
                                    <div class="col-6">
                                        Tanggal awal
                                        <input type="date" id="start_date" class="form-control" name="start_date"
                                            required>
                                    </div>
                                    <div class="col-6">
                                        Tanggal akhir
                                        <input type="date" id="end_date" class="form-control" name="end_date" required>
                                    </div>
                                </div> <br>
                                <button type="submit" class="btn btn-secondary">
                                    <i class="link-icon" data-feather="printer"></i>
                                    <span class="link-title">Cetak</span>
                                </button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
