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
            @include('layouts.alert')
            <div class="row">
                <div class="col-12 col-md-4 grid-margin">
                    <div class="card bg-info">
                        <div class="card-header">Laporan Penerimaan Vaksin</div>
                        <div class="card-body">
                            <form action="{{ route('vaccine-report.in') }}" method="POST" target="_blank" id="form-in">
                                @csrf
                                <h5 class="card-title">
                                    Pilih tanggal dan vaksin
                                </h5>
                                <div class="card-text">
                                <div class="mb-3">
                                    <label>Vaksin (Opsional)</label>
                                    <select name="id_vaccine" id="id_vaccine_in" class="form-control">
                                        <option value="">Semua Vaksin</option>
                                        @foreach ($vaccineIns as $vaccine)
                                            <option value="{{ $vaccine->id }}">
                                                {{ $vaccine->vaccine_name }} - {{ $vaccine->batch_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Tanggal awal
                                        <input type="date" class="form-control" name="start_date" id="start_date_in" required>
                                    </div>
                                    <div class="col-6">
                                        Tanggal akhir
                                        <input type="date" class="form-control" name="end_date" id="end_date_in" required>
                                    </div>
                                </div> <br>
                                <button type="submit" class="btn btn-light" id="print-in-btn">
                                    <i class="link-icon" data-feather="printer"></i>
                                    <span class="link-title">Cetak Laporan</span>
                                </button>
                                <button type="submit" class="btn btn-success" id="excel-in-btn"
                                    formaction="{{ route('vaccine-report.in-excel') }}">
                                    <i class="link-icon" data-feather="download"></i>
                                    <span class="link-title">Export Excel</span>
                                </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 grid-margin">
                    <div class="card bg-secondary">
                        <div class="card-header">Laporan Pengeluaran Vaksin</div>
                        <div class="card-body">
                            <form action="{{ route('vaccine-report.out') }}" method="POST" target="_blank" id="form-out">
                                @csrf
                                <h5 class="card-title">
                                    Pilih tanggal dan vaksin
                                </h5>
                                <div class="card-text">
                                <div class="mb-3">
                                    <label>Vaksin (Opsional)</label>
                                    <select name="id_vaccine" id="id_vaccine_out" class="form-control">
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
                                        <input type="date" class="form-control" name="start_date" id="start_date_out" required>
                                    </div>
                                    <div class="col-6">
                                        Tanggal akhir
                                        <input type="date" class="form-control" name="end_date" id="end_date_out" required>
                                    </div>
                                </div> <br>
                                <button type="submit" class="btn btn-light" id="print-out-btn">
                                    <i class="link-icon" data-feather="printer"></i>
                                    <span class="link-title">Cetak Laporan</span>
                                </button>
                                <button type="submit" class="btn btn-success" id="excel-out-btn"
                                    formaction="{{ route('vaccine-report.out-excel') }}">
                                    <i class="link-icon" data-feather="download"></i>
                                    <span class="link-title">Export Excel</span>
                                </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 grid-margin">
                    <div class="card text-white bg-primary">
                        <div class="card-header">Laporan Stok Vaksin</div>
                        <div class="card-body">
                            <form action="{{ route('vaccine-report.stock') }}" method="POST" target="_blank" id="form-stock">
                                @csrf
                                <h5 class="card-title text-white">
                                    Pilih tanggal dan vaksin
                                </h5>
                                <div class="card-text">
                                <div class="mb-3">
                                    <label class="text-white">Vaksin (Opsional)</label>
                                    <select name="id_vaccine" id="id_vaccine_stock" class="form-control">
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
                                        <input type="date" class="form-control" name="start_date" id="start_date_stock" required>
                                    </div>
                                    <div class="col-6">
                                        Tanggal akhir
                                        <input type="date" class="form-control" name="end_date" id="end_date_stock" required>
                                    </div>
                                </div> <br>
                                <button type="submit" class="btn btn-light" id="print-stock-btn">
                                    <i class="link-icon" data-feather="printer"></i>
                                    <span class="link-title">Cetak Laporan</span>
                                </button>
                                <button type="submit" class="btn btn-success" id="excel-stock-btn"
                                    formaction="{{ route('vaccine-report.stock-excel') }}">
                                    <i class="link-icon" data-feather="download"></i>
                                    <span class="link-title">Export Excel</span>
                                </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('#form-in, #form-out, #form-stock').forEach(function(form) {
        const startDate = form.querySelector('[name="start_date"]');
        const endDate = form.querySelector('[name="end_date"]');

        function validateDateRange() {
            endDate.min = startDate.value;
            endDate.setCustomValidity(
                startDate.value && endDate.value && endDate.value < startDate.value
                    ? 'Tanggal akhir tidak boleh sebelum tanggal awal.'
                    : ''
            );
        }

        startDate.addEventListener('input', validateDateRange);
        startDate.addEventListener('change', validateDateRange);
        endDate.addEventListener('input', validateDateRange);
        endDate.addEventListener('change', validateDateRange);
        window.addEventListener('pageshow', validateDateRange);
        validateDateRange();
    });
</script>
@endpush
