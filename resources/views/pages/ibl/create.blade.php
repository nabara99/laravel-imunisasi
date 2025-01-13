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
                            <form class="forms-sample" action="{{ route('ibl-imun.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label class="mb-2" for="">Balita</label>
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
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">PCV3</label>
                                            <input type="text" id="datePicker" value="{{ old('pcv3') }}"
                                                class="form-control @error('pcv3') is-invalid @enderror" name="pcv3"
                                                placeholder="Pilih Tanggal">
                                            @error('pcv3')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Penta4</label>
                                            <input type="text" id="datePicker" value="{{ old('penta4') }}"
                                                class="form-control @error('penta4') is-invalid @enderror" name="penta4"
                                                placeholder="Pilih Tanggal">
                                            @error('penta4')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">MR2</label>
                                            <input type="text" id="datePicker" value="{{ old('mr2') }}"
                                                class="form-control @error('mr2') is-invalid @enderror" name="mr2"
                                                placeholder="Pilih Tanggal">
                                            @error('mr2')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
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
                                <a href="{{ route('ibl-imun.index') }}" class="btn btn-secondary">Batal</a>
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
