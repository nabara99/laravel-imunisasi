@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                            <form class="forms-sample" action="{{ route('children.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="">Desa</label>
                                            <select class="form-select mb-3" name="id_village" required>
                                                <option value="" selected>-- Pilih Desa --</option>
                                                @foreach ($villages as $village)
                                                    <option value="{{ $village->id }}"
                                                        {{ old('id_village') == $village->id ? 'selected' : '' }}>
                                                        {{ $village->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_village')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nama Anak</label>
                                            <input type="text" value="{{ old('name_child') }}"
                                                class="form-control @error('name_child') is-invalid @enderror"
                                                name="name_child" placeholder="Nama Anak" minlength="3" required>
                                            @error('name_child')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">NIK Anak</label>
                                            <input type="text" value="{{ old('nik') }}"
                                                class="form-control @error('nik') is-invalid @enderror" name="nik"
                                                placeholder="NIK Anak" maxlength="16"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'');" required>
                                            @error('nik')
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
                                            <label for="" class="form-label">Tgl Lahir</label>
                                            <input type="text" id="datePicker" value="{{ old('date_birth') }}"
                                                class="form-control @error('date_birth') is-invalid @enderror"
                                                name="date_birth" placeholder="Pilih Tanggal">
                                            @error('date_birth')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nama Ibu</label>
                                            <input type="text" value="{{ old('mother_name') }}"
                                                class="form-control @error('mother_name') is-invalid @enderror"
                                                name="mother_name" placeholder="Nama Ibu" minlength="3" required>
                                            @error('mother_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">NIK Ibu</label>
                                            <input type="text" value="{{ old('mother_nik') }}"
                                                class="form-control @error('mother_nik') is-invalid @enderror"
                                                name="mother_nik" placeholder="NIK Ibu" maxlength="16"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'');" required>
                                            @error('mother_nik')
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
                                            <label for="" class="form-label">Jenis Kelamin</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="gender"
                                                        id="gender1" value="L" checked>
                                                    <label class="form-check-label" for="gender1">
                                                        Laki-Laki
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="gender"
                                                        id="gender2" value="P">
                                                    <label class="form-check-label" for="gender2">
                                                        Perempuan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="mb-3">
                                            <label for="">Alamat</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="2" required></textarea>
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                <a href="{{ route('children.index') }}" class="btn btn-secondary">Batal</a>
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

    <script>
        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
        });
    </script>
@endpush
