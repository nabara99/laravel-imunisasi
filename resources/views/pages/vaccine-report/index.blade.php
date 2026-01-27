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
                            <form action="{{ route('vaccine-report.in') }}" method="POST" target="blank" id="form-in">
                                @csrf
                                <h5 class="card-title">
                                    Pilih tanggal dan vaksin
                                </h5>
                                <p class="card-text">
                                <div class="mb-3">
                                    <label>Vaksin (Opsional)</label>
                                    <select name="id_vaccine" id="id_vaccine_in" class="form-control">
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
                                <button type="button" class="btn btn-success" id="excel-in-btn" disabled>
                                    <i class="link-icon" data-feather="download"></i>
                                    <span class="link-title">Export Excel</span>
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
                            <form action="{{ route('vaccine-report.out') }}" method="POST" target="blank" id="form-out">
                                @csrf
                                <h5 class="card-title">
                                    Pilih tanggal dan vaksin
                                </h5>
                                <p class="card-text">
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
                                <button type="button" class="btn btn-success" id="excel-out-btn" disabled>
                                    <i class="link-icon" data-feather="download"></i>
                                    <span class="link-title">Export Excel</span>
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
                            <form action="{{ route('vaccine-report.stock') }}" method="POST" target="blank" id="form-stock">
                                @csrf
                                <h5 class="card-title text-white">
                                    Pilih tanggal dan vaksin
                                </h5>
                                <p class="card-text">
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
                                <button type="button" class="btn btn-success" id="excel-stock-btn" disabled>
                                    <i class="link-icon" data-feather="download"></i>
                                    <span class="link-title">Export Excel</span>
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

@push('scripts')
<script>
    // Laporan Penerimaan Vaksin - Enable buttons when dates are selected
    const startDateIn = document.querySelector('#start_date_in');
    const endDateIn = document.querySelector('#end_date_in');
    const printBtnIn = document.querySelector('#print-in-btn');
    const excelBtnIn = document.querySelector('#excel-in-btn');
    const idVaccineIn = document.querySelector('#id_vaccine_in');

    function checkInDates() {
        if (startDateIn.value && endDateIn.value) {
            printBtnIn.disabled = false;
            excelBtnIn.disabled = false;
        } else {
            printBtnIn.disabled = true;
            excelBtnIn.disabled = true;
        }
    }

    startDateIn.addEventListener('change', checkInDates);
    endDateIn.addEventListener('change', checkInDates);

    // Laporan Pengeluaran Vaksin - Enable buttons when dates are selected
    const startDateOut = document.querySelector('#start_date_out');
    const endDateOut = document.querySelector('#end_date_out');
    const printBtnOut = document.querySelector('#print-out-btn');
    const excelBtnOut = document.querySelector('#excel-out-btn');
    const idVaccineOut = document.querySelector('#id_vaccine_out');

    function checkOutDates() {
        if (startDateOut.value && endDateOut.value) {
            printBtnOut.disabled = false;
            excelBtnOut.disabled = false;
        } else {
            printBtnOut.disabled = true;
            excelBtnOut.disabled = true;
        }
    }

    startDateOut.addEventListener('change', checkOutDates);
    endDateOut.addEventListener('change', checkOutDates);

    // Excel download for Out
    excelBtnOut.addEventListener('click', function() {
        if (startDateOut.value && endDateOut.value) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('vaccine-report.out-excel') }}';
            form.target = '_blank';

            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            // Add start_date
            const startDate = document.createElement('input');
            startDate.type = 'hidden';
            startDate.name = 'start_date';
            startDate.value = startDateOut.value;
            form.appendChild(startDate);

            // Add end_date
            const endDate = document.createElement('input');
            endDate.type = 'hidden';
            endDate.name = 'end_date';
            endDate.value = endDateOut.value;
            form.appendChild(endDate);

            // Add id_vaccine if selected
            if (idVaccineOut.value) {
                const vaccineId = document.createElement('input');
                vaccineId.type = 'hidden';
                vaccineId.name = 'id_vaccine';
                vaccineId.value = idVaccineOut.value;
                form.appendChild(vaccineId);
            }

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    });

    // Excel download for In
    excelBtnIn.addEventListener('click', function() {
        if (startDateIn.value && endDateIn.value) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('vaccine-report.in-excel') }}';
            form.target = '_blank';

            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            // Add start_date
            const startDate = document.createElement('input');
            startDate.type = 'hidden';
            startDate.name = 'start_date';
            startDate.value = startDateIn.value;
            form.appendChild(startDate);

            // Add end_date
            const endDate = document.createElement('input');
            endDate.type = 'hidden';
            endDate.name = 'end_date';
            endDate.value = endDateIn.value;
            form.appendChild(endDate);

            // Add id_vaccine if selected
            if (idVaccineIn.value) {
                const vaccineId = document.createElement('input');
                vaccineId.type = 'hidden';
                vaccineId.name = 'id_vaccine';
                vaccineId.value = idVaccineIn.value;
                form.appendChild(vaccineId);
            }

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    });

    // Laporan Stok Vaksin - Enable buttons when dates are selected
    const startDateStock = document.querySelector('#start_date_stock');
    const endDateStock = document.querySelector('#end_date_stock');
    const printBtnStock = document.querySelector('#print-stock-btn');
    const excelBtnStock = document.querySelector('#excel-stock-btn');
    const idVaccineStock = document.querySelector('#id_vaccine_stock');

    function checkStockDates() {
        if (startDateStock.value && endDateStock.value) {
            printBtnStock.disabled = false;
            excelBtnStock.disabled = false;
        } else {
            printBtnStock.disabled = true;
            excelBtnStock.disabled = true;
        }
    }

    startDateStock.addEventListener('change', checkStockDates);
    endDateStock.addEventListener('change', checkStockDates);

    // Excel download for Stock
    excelBtnStock.addEventListener('click', function() {
        if (startDateStock.value && endDateStock.value) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('vaccine-report.stock-excel') }}';
            form.target = '_blank';

            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            // Add start_date
            const startDate = document.createElement('input');
            startDate.type = 'hidden';
            startDate.name = 'start_date';
            startDate.value = startDateStock.value;
            form.appendChild(startDate);

            // Add end_date
            const endDate = document.createElement('input');
            endDate.type = 'hidden';
            endDate.name = 'end_date';
            endDate.value = endDateStock.value;
            form.appendChild(endDate);

            // Add id_vaccine if selected
            if (idVaccineStock.value) {
                const vaccineId = document.createElement('input');
                vaccineId.type = 'hidden';
                vaccineId.name = 'id_vaccine';
                vaccineId.value = idVaccineStock.value;
                form.appendChild(vaccineId);
            }

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    });
</script>
@endpush
