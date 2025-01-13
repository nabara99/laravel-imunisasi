@extends('layouts.app')

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Sasaran Anak Sekolah</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Sasaran</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h6 class="card-title">Edit Sasaran</h6>
                                </div>
                            </div>
                            <form class="forms-sample" action="{{ route('student-target.update', $student->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nama Sekolah</label>
                                            <select name="id_school_disabled" class="form-select mb-3" disabled>
                                                @foreach ($schools as $school)
                                                    <option value="{{ $school->id }}"
                                                        {{ $student->id_school == $school->id ? 'selected' : '' }}>
                                                        {{ $school->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="id_school" value="{{ $student->id_school }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kelas</label>
                                            <input type="string" value="{{ $student->classroom }}"
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
                                            <input type="number" value="{{ $student->sum_boys }}"
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
                                            <input type="number" value="{{ $student->sum_girls }}"
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
