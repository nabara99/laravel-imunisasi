@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">TT WUS</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit TT WUS</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h6 class="card-title">Edit TT</h6>
                                </div>
                            </div>
                            <form class="forms-sample" action="{{ route('tt-imun.update', $tt->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="mb-2" for="">WUS</label>
                                            <select class="id_wus_disabled form-select" disabled>
                                                @foreach ($wuses as $wus)
                                                    <option value="{{ $wus->id }}"
                                                        {{ $tt->id_wus == $wus->id ? 'selected' : '' }}>
                                                        {{ $wus->name_wus }} - {{ $wus->nik }} {{ $wus->hamil == '0' ? '' : 'Hamil' }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="id_wus" value="{{ $tt->id_wus }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">T1</label>
                                            <input type="text" id="datePicker" value="{{ $tt->t1 }}"
                                                class="form-control @error('t1') is-invalid @enderror" name="t1"
                                                placeholder="Pilih Tanggal">
                                            @error('t1')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">T2</label>
                                            <input type="text" id="datePicker" value="{{ $tt->t2 }}"
                                                class="form-control @error('t2') is-invalid @enderror" name="t2"
                                                placeholder="Pilih Tanggal">
                                            @error('t2')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">T3</label>
                                            <input type="text" id="datePicker" value="{{ $tt->t3 }}"
                                                class="form-control @error('t3') is-invalid @enderror"
                                                name="t3" placeholder="Pilih Tanggal">
                                            @error('t3')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">T4</label>
                                            <input type="text" id="datePicker" value="{{ $tt->t4 }}"
                                                class="form-control @error('t4') is-invalid @enderror" name="t4"
                                                placeholder="Pilih Tanggal">
                                            @error('t4')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">T5</label>
                                            <input type="text" id="datePicker" value="{{ $tt->t5 }}"
                                                class="form-control @error('t5') is-invalid @enderror" name="t5"
                                                placeholder="Pilih Tanggal">
                                            @error('t5')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">T1 Status</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="t1_status"
                                                        id="ya" value="1" @if ($tt->t1_status == '1') checked @endif>
                                                    <label class="form-check-label" for="ya">
                                                        Hamil
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="t1_status"
                                                        id="tidak" value="0" @if ($tt->t1_status == '0') checked @endif>
                                                    <label class="form-check-label" for="tidak">
                                                        Tidak
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">T2 Status</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="t2_status"
                                                        id="ya" value="1" @if ($tt->t2_status == '1') checked @endif>
                                                    <label class="form-check-label" for="ya">
                                                        Hamil
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="t2_status"
                                                        id="tidak" value="0" @if ($tt->t2_status == '0') checked @endif>
                                                    <label class="form-check-label" for="tidak">
                                                        Tidak
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">T3 Status</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="t3_status"
                                                        id="ya" value="1" @if ($tt->t3_status == '1') checked @endif>
                                                    <label class="form-check-label" for="ya">
                                                        Hamil
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="t3_status"
                                                        id="tidak" value="0" @if ($tt->t3_status == '0') checked @endif>
                                                    <label class="form-check-label" for="tidak">
                                                        Tidak
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">T4 Status</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="t4_status"
                                                        id="ya" value="1" @if ($tt->t4_status == '1') checked @endif>
                                                    <label class="form-check-label" for="ya">
                                                        Hamil
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="t4_status"
                                                        id="tidak" value="0" @if ($tt->t4_status == '0') checked @endif>
                                                    <label class="form-check-label" for="tidak">
                                                        Tidak
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">T5 Status</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="t5_status"
                                                        id="ya" value="1" @if ($tt->t5_status == '1') checked @endif>
                                                    <label class="form-check-label" for="ya">
                                                        Hamil
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="t5_status"
                                                        id="tidak" value="0" @if ($tt->t5_status == '0') checked @endif>
                                                    <label class="form-check-label" for="tidak">
                                                        Tidak
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                <a href="{{ route('tt-imun.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.wuses').select2();
        });

        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
        });
    </script>
@endpush
