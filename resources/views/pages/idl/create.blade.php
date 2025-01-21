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
                    <li class="breadcrumb-item"><a href="#">Anak</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Anak</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h6 class="card-title">Tambah Anak</h6>
                                </div>
                            </div>
                            <form class="forms-sample" action="{{ route('idl-imun.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="mb-2" for="">Bayi</label>
                                            <select class="childs form-select @error('id_children') is-invalid @enderror"
                                                name="id_children" data-width="100%" required>
                                                <option value="">-- Pilih Bayi --</option>
                                                @foreach ($childrens as $children)
                                                    <option value="{{ $children->id }}"
                                                        {{ old('id_children') == $children->id ? 'selected' : '' }}>
                                                        {{ $children->name_child }} - {{ $children->nik }} -
                                                        {{ date('j F Y', strtotime($children->date_birth)) }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_children')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">HB0</label>
                                            <input type="text" id="datePicker" value="{{ old('hb0') }}"
                                                class="form-control @error('hb0') is-invalid @enderror" name="hb0"
                                                placeholder="Pilih Tanggal">
                                            @error('hb0')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">BCG</label>
                                            <input type="text" id="datePicker" value="{{ old('bcg') }}"
                                                class="form-control @error('bcg') is-invalid @enderror" name="bcg"
                                                placeholder="Pilih Tanggal">
                                            @error('bcg')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Polio1</label>
                                            <input type="text" id="datePicker" value="{{ old('polio1') }}"
                                                class="form-control @error('polio1') is-invalid @enderror" name="polio1"
                                                placeholder="Pilih Tanggal">
                                            @error('polio1')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Penta1</label>
                                            <input type="text" id="datePicker" value="{{ old('penta1') }}"
                                                class="form-control @error('penta1') is-invalid @enderror" name="penta1"
                                                placeholder="Pilih Tanggal">
                                            @error('penta1')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Polio2</label>
                                            <input type="text" id="datePicker" value="{{ old('polio2') }}"
                                                class="form-control @error('polio2') is-invalid @enderror" name="polio2"
                                                placeholder="Pilih Tanggal">
                                            @error('polio2')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">PCV1</label>
                                            <input type="text" id="datePicker" value="{{ old('pcv1') }}"
                                                class="form-control @error('pcv1') is-invalid @enderror" name="pcv1"
                                                placeholder="Pilih Tanggal">
                                            @error('pcv1')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Rotavirus1</label>
                                            <input type="text" id="datePicker" value="{{ old('rotavirus1') }}"
                                                class="form-control @error('rotavirus1') is-invalid @enderror"
                                                name="rotavirus1" placeholder="Pilih Tanggal">
                                            @error('rotavirus1')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Penta2</label>
                                            <input type="text" id="datePicker" value="{{ old('penta2') }}"
                                                class="form-control @error('penta2') is-invalid @enderror" name="penta2"
                                                placeholder="Pilih Tanggal">
                                            @error('penta2')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Polio3</label>
                                            <input type="text" id="datePicker" value="{{ old('polio3') }}"
                                                class="form-control @error('polio3') is-invalid @enderror" name="polio3"
                                                placeholder="Pilih Tanggal">
                                            @error('polio3')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">PCV2</label>
                                            <input type="text" id="datePicker" value="{{ old('pcv2') }}"
                                                class="form-control @error('pcv2') is-invalid @enderror" name="pcv2"
                                                placeholder="Pilih Tanggal">
                                            @error('pcv2')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Rotavirus2</label>
                                            <input type="text" id="datePicker" value="{{ old('rotavirus2') }}"
                                                class="form-control @error('rotavirus2') is-invalid @enderror"
                                                name="rotavirus2" placeholder="Pilih Tanggal">
                                            @error('rotavirus2')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Penta3</label>
                                            <input type="text" id="datePicker" value="{{ old('penta3') }}"
                                                class="form-control @error('penta3') is-invalid @enderror" name="penta3"
                                                placeholder="Pilih Tanggal">
                                            @error('penta3')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Polio4</label>
                                            <input type="text" id="datePicker" value="{{ old('polio4') }}"
                                                class="form-control @error('polio4') is-invalid @enderror" name="polio4"
                                                placeholder="Pilih Tanggal">
                                            @error('polio4')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">IPV1</label>
                                            <input type="text" id="datePicker" value="{{ old('ipv1') }}"
                                                class="form-control @error('ipv1') is-invalid @enderror" name="ipv1"
                                                placeholder="Pilih Tanggal">
                                            @error('ipv1')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Rotavirus3</label>
                                            <input type="text" id="datePicker" value="{{ old('rotavirus3') }}"
                                                class="form-control @error('rotavirus3') is-invalid @enderror"
                                                name="rotavirus3" placeholder="Pilih Tanggal">
                                            @error('rotavirus3')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">MR1</label>
                                            <input type="text" id="datePicker" value="{{ old('mr1') }}"
                                                class="form-control @error('mr1') is-invalid @enderror" name="mr1"
                                                placeholder="Pilih Tanggal">
                                            @error('mr1')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">IPV2</label>
                                            <input type="text" id="datePicker" value="{{ old('ipv2') }}"
                                                class="form-control @error('ipv2') is-invalid @enderror" name="ipv2"
                                                placeholder="Pilih Tanggal">
                                            @error('ipv2')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Status</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="lengkap"
                                                        id="ya" value="1">
                                                    <label class="form-check-label" for="ya">
                                                        Lengkap
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="lengkap"
                                                        id="tidak" value="0" checked>
                                                    <label class="form-check-label" for="tidak">
                                                        Belum
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                <a href="{{ route('idl-imun.index') }}" class="btn btn-secondary">Batal</a>
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
            $('.childs').select2();
        });

        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
        });
    </script>
@endpush
