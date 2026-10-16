@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
    <style>
        .vaccine-report-form .select2-selection--single {
            height: auto;
            border-color: var(--bs-border-color);
            border-radius: var(--bs-border-radius);
        }

        .vaccine-report-form .select2-selection__rendered {
            padding: .469rem 2rem .469rem .8rem;
            color: var(--bs-body-color);
            line-height: 1.5;
        }

        .vaccine-report-form .select2-selection__arrow {
            height: 100%;
        }

        .vaccine-report-form .select2-dropdown {
            color: var(--bs-body-color);
        }
    </style>
@endpush

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
                            <form action="{{ route('vaccine-report.in') }}" method="POST" target="_blank" id="form-in" class="vaccine-report-form">
                                @csrf
                                <h5 class="card-title">
                                    Pilih tanggal dan vaksin
                                </h5>
                                <div class="card-text">
                                <div class="mb-3">
                                    <label for="id_vaccine_in">Vaksin (Opsional)</label>
                                    <select name="id_vaccine" id="id_vaccine_in" class="form-control vaccine-report-filter">
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
                            <form action="{{ route('vaccine-report.out') }}" method="POST" target="_blank" id="form-out" class="vaccine-report-form">
                                @csrf
                                <h5 class="card-title">
                                    Pilih tanggal dan vaksin
                                </h5>
                                <div class="card-text">
                                <div class="mb-3">
                                    <label for="id_vaccine_out">Vaksin (Opsional)</label>
                                    <select name="id_vaccine" id="id_vaccine_out" class="form-control vaccine-report-filter">
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
                            <form action="{{ route('vaccine-report.stock') }}" method="POST" target="_blank" id="form-stock" class="vaccine-report-form">
                                @csrf
                                <h5 class="card-title text-white">
                                    Pilih tanggal dan vaksin
                                </h5>
                                <div class="card-text">
                                <div class="mb-3">
                                    <label for="id_vaccine_stock" class="text-white">Vaksin (Opsional)</label>
                                    <select name="id_vaccine" id="id_vaccine_stock" class="form-control vaccine-report-filter">
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
<script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
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

    $(function() {
        $('.vaccine-report-filter').each(function() {
            const form = $(this).closest('form');

            $(this).select2({
                dropdownParent: form,
                width: '100%',
                placeholder: 'Semua Vaksin',
                allowClear: true,
                minimumResultsForSearch: 0,
                language: {
                    noResults: function() {
                        return 'Vaksin tidak ditemukan';
                    }
                }
            }).on('select2:open', function() {
                const searchField = form.find('.select2-search__field')
                    .attr('placeholder', 'Cari nama vaksin atau nomor batch')
                    .attr('aria-label', 'Cari nama vaksin atau nomor batch');

                searchField.get(0)?.focus();
            });
        });
    });
</script>
@endpush
