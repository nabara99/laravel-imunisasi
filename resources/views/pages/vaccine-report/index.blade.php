@extends('layouts.app')

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Vaksin</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-12 col-md-4 grid-margin">
                    <div class="card bg-info">
                        <div class="card-header">Laporan Penerimaan Vaksin</div>
                        <div class="card-body">
                            <form action="{{ route('vaccine-report.in') }}" method="POST" target="blank">
                                @csrf
                                <h5 class="card-title">
                                    Pilih tanggal dan vaksin
                                </h5>
                                <p class="card-text">
                                <div class="mb-3">
                                    <label>Vaksin (Opsional)</label>
                                    <select name="id_vaccine" class="form-control">
                                        <option value="">Semua Vaksin</option>
                                        @foreach ($vaccines as $vaccine)
                                            <option value="{{ $vaccine->id }}">
                                                {{ $vaccine->vaccine_name }} - {{ $vaccine->batch_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Tanggal awal
                                        <input type="date" class="form-control" name="start_date" required>
                                    </div>
                                    <div class="col-6">
                                        Tanggal akhir
                                        <input type="date" class="form-control" name="end_date" required>
                                    </div>
                                </div> <br>
                                <button type="submit" class="btn btn-light">
                                    <i class="link-icon" data-feather="printer"></i>
                                    <span class="link-title">Cetak Laporan</span>
                                </button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 grid-margin">
                    <div class="card bg-secondary">
                        <div class="card-header">Laporan Pengeluaran Vaksin</div>
                        <div class="card-body">
                            <form action="{{ route('vaccine-report.out') }}" method="POST" target="blank">
                                @csrf
                                <h5 class="card-title">
                                    Pilih tanggal dan vaksin
                                </h5>
                                <p class="card-text">
                                <div class="mb-3">
                                    <label>Vaksin (Opsional)</label>
                                    <select name="id_vaccine" class="form-control">
                                        <option value="">Semua Vaksin</option>
                                        @foreach ($vaccines as $vaccine)
                                            <option value="{{ $vaccine->id }}">
                                                {{ $vaccine->vaccine_name }} - {{ $vaccine->batch_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Tanggal awal
                                        <input type="date" class="form-control" name="start_date" required>
                                    </div>
                                    <div class="col-6">
                                        Tanggal akhir
                                        <input type="date" class="form-control" name="end_date" required>
                                    </div>
                                </div> <br>
                                <button type="submit" class="btn btn-light">
                                    <i class="link-icon" data-feather="printer"></i>
                                    <span class="link-title">Cetak Laporan</span>
                                </button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 grid-margin">
                    <div class="card text-white bg-primary">
                        <div class="card-header">Laporan Stok Vaksin</div>
                        <div class="card-body">
                            <form action="{{ route('vaccine-report.stock') }}" method="POST" target="blank">
                                @csrf
                                <h5 class="card-title text-white">
                                    Pilih tanggal dan vaksin
                                </h5>
                                <p class="card-text">
                                <div class="mb-3">
                                    <label class="text-white">Vaksin (Opsional)</label>
                                    <select name="id_vaccine" class="form-control">
                                        <option value="">Semua Vaksin</option>
                                        @foreach ($vaccines as $vaccine)
                                            <option value="{{ $vaccine->id }}">
                                                {{ $vaccine->vaccine_name }} - {{ $vaccine->batch_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Tanggal awal
                                        <input type="date" class="form-control" name="start_date" required>
                                    </div>
                                    <div class="col-6">
                                        Tanggal akhir
                                        <input type="date" class="form-control" name="end_date" required>
                                    </div>
                                </div> <br>
                                <button type="submit" class="btn btn-light">
                                    <i class="link-icon" data-feather="printer"></i>
                                    <span class="link-title">Cetak Laporan</span>
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
