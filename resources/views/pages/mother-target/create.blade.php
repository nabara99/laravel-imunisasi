@extends('layouts.app')

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Sasaran WUS</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Sasaran</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h6 class="card-title">Tambah Sasaran</h6>
                                </div>
                            </div>
                            <form class="forms-sample" action="{{ route('mother-target.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="">Desa</label>
                                            <select class="form-select mb-3" name="village_id" required>
                                                <option value="" selected>-- Pilih Desa --</option>
                                                @foreach ($villages as $village)
                                                    <option value="{{ $village->id }}"
                                                        {{ old('village_id') == $village->id ? 'selected' : '' }}>
                                                        {{ $village->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('village_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jumlah Ibu Hamil</label>
                                            <input type="number" value="{{ old('pregnant') }}"
                                                class="form-control @error('pregnant') is-invalid @enderror"
                                                name="pregnant" placeholder="Jumlah Ibu Hamil" required>
                                            @error('pregnant')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jumlah Ibu Tidak Hamil</label>
                                            <input type="number" value="{{ old('no_pregnant') }}"
                                                class="form-control @error('no_pregnant') is-invalid @enderror"
                                                name="no_pregnant" placeholder="Jumlah Ibu Tidak Hamil" required>
                                            @error('no_pregnant')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                <a href="{{ route('mother-target.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
