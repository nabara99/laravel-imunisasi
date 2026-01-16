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
                                <button type="submit" class="btn btn-warning" id="print-idl-btn" disabled>
                                    <i class="link-icon" data-feather="printer"></i>
                                    <span class="link-title">Cetak</span>
                                </button>
                                <button type="button" class="btn btn-success" id="excel-idl-btn" disabled>
                                    <i class="link-icon" data-feather="download"></i>
                                    <span class="link-title">Excel</span>
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
                            <form action="{{ route('report-ibl') }}" method="POST" target="blank">
                                @csrf
                                <h5 class="card-title">
                                    Pilih tanggal
                                </h5>
                                <p class="card-text">
                                <div class="row">
                                    <div class="col-6">
                                        Tanggal awal
                                        <input type="date" id="start_date_ibl" class="form-control" name="start_date"
                                            required>
                                    </div>
                                    <div class="col-6">
                                        Tanggal akhir
                                        <input type="date" id="end_date_ibl" class="form-control" name="end_date" required>
                                    </div>
                                </div> <br>
                                <button type="submit" class="btn btn-warning" id="print-ibl-btn" disabled>
                                    <i class="link-icon" data-feather="printer"></i>
                                    <span class="link-title">Cetak</span>
                                </button>
                                <button type="button" class="btn btn-success" id="excel-ibl-btn" disabled>
                                    <i class="link-icon" data-feather="download"></i>
                                    <span class="link-title">Excel</span>
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
                            <form action="{{ route('report-bias') }}" method="POST" target="blank">
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
                        <div class="card-header">Cakupan WUS & Bumil</div>
                        <div class="card-body">
                            <form action="{{ route('report-tt') }}" method="POST" target="blank">
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

@push('scripts')
<script>
    // IDL Report - Enable buttons when dates are selected
    const startDateIdl = document.querySelector('#start_date');
    const endDateIdl = document.querySelector('#end_date');
    const printBtnIdl = document.querySelector('#print-idl-btn');
    const excelBtnIdl = document.querySelector('#excel-idl-btn');

    function checkIdlDates() {
        if (startDateIdl.value && endDateIdl.value) {
            printBtnIdl.disabled = false;
            excelBtnIdl.disabled = false;
        } else {
            printBtnIdl.disabled = true;
            excelBtnIdl.disabled = true;
        }
    }

    startDateIdl.addEventListener('change', checkIdlDates);
    endDateIdl.addEventListener('change', checkIdlDates);

    // Excel download for IDL
    excelBtnIdl.addEventListener('click', function() {
        if (startDateIdl.value && endDateIdl.value) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('report-idl-excel') }}';
            form.target = '_blank';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            const startInput = document.createElement('input');
            startInput.type = 'hidden';
            startInput.name = 'start_date';
            startInput.value = startDateIdl.value;
            form.appendChild(startInput);

            const endInput = document.createElement('input');
            endInput.type = 'hidden';
            endInput.name = 'end_date';
            endInput.value = endDateIdl.value;
            form.appendChild(endInput);

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    });

    // IBL Report - Enable buttons when dates are selected
    const startDateIbl = document.querySelector('#start_date_ibl');
    const endDateIbl = document.querySelector('#end_date_ibl');
    const printBtnIbl = document.querySelector('#print-ibl-btn');
    const excelBtnIbl = document.querySelector('#excel-ibl-btn');

    function checkIblDates() {
        if (startDateIbl.value && endDateIbl.value) {
            printBtnIbl.disabled = false;
            excelBtnIbl.disabled = false;
        } else {
            printBtnIbl.disabled = true;
            excelBtnIbl.disabled = true;
        }
    }

    startDateIbl.addEventListener('change', checkIblDates);
    endDateIbl.addEventListener('change', checkIblDates);

    // Excel download for IBL
    excelBtnIbl.addEventListener('click', function() {
        if (startDateIbl.value && endDateIbl.value) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('report-ibl-excel') }}';
            form.target = '_blank';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            const startInput = document.createElement('input');
            startInput.type = 'hidden';
            startInput.name = 'start_date';
            startInput.value = startDateIbl.value;
            form.appendChild(startInput);

            const endInput = document.createElement('input');
            endInput.type = 'hidden';
            endInput.name = 'end_date';
            endInput.value = endDateIbl.value;
            form.appendChild(endInput);

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    });
</script>
@endpush
