@extends('layouts.app')

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Sasaran Anak Sekolah</a></li>
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
                            <form class="forms-sample" action="{{ route('student-target.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nama Sekolah</label>
                                            <select class="form-select mb-3" name="id_school" required>
                                                <option value="" selected>-- Pilih Sekolah --</option>
                                                @foreach ($schools as $school)
                                                    <option value="{{ $school->id }}"
                                                        {{ old('id_school') == $school->id ? 'selected' : '' }}>
                                                        {{ $school->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_school')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kelas</label>
                                            <input type="string" value="{{ old('classroom') }}"
                                                class="form-control @error('classroom') is-invalid @enderror"
                                                name="classroom" placeholder="Kelas" required>
                                            @error('classroom')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Murid Laki-laki</label>
                                            <input type="number" value="{{ old('sum_boys') }}"
                                                class="form-control @error('sum_boys') is-invalid @enderror"
                                                name="sum_boys" placeholder="Jumlah Anak" required>
                                            @error('sum_boys')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Murid Perempuan</label>
                                            <input type="number" value="{{ old('sum_girls') }}"
                                                class="form-control @error('sum_girls') is-invalid @enderror"
                                                name="sum_girls" placeholder="Jumlah Anak" required>
                                            @error('sum_girls')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                <a href="{{ route('student-target.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
