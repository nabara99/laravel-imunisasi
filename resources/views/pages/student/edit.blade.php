@extends('layouts.app')

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Anak Sekolah</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Anak Sekolah</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h6 class="card-title">Edit Anak Sekolah</h6>
                                </div>
                            </div>
                            <form class="forms-sample" action="{{ route('child-sch.update', $student->id) }}" method="POST">
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
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kelas</label>
                                            <input type="string" value="{{ $student->class }}"
                                                class="form-control @error('class') is-invalid @enderror"
                                                name="class" placeholder="Kelas" required>
                                            @error('class')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nama</label>
                                            <input type="text" value="{{ $student->name_student }}"
                                                class="form-control @error('name_student') is-invalid @enderror"
                                                name="name_student" placeholder="Nama" required>
                                            @error('name_student')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tgl Lahir</label>
                                            <input type="text" id="datePicker" value="{{ $student->birth_date }}"
                                                class="form-control @error('birth_date') is-invalid @enderror" name="birth_date"
                                                placeholder="Pilih Tanggal">
                                            @error('birth_date')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">NIK Anak</label>
                                            <input type="text" value="{{ $student->nik }}"
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
                                            <label for="" class="form-label">Jenis Kelamin</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="gender"
                                                        id="gender1" value="L" @if ($student->gender == 'L') checked @endif>
                                                    <label class="form-check-label" for="gender1">
                                                        Laki-Laki
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="gender"
                                                        id="gender2" value="P" @if ($student->gender == 'P') checked @endif>
                                                    <label class="form-check-label" for="gender2">
                                                        Perempuan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nama Ibu</label>
                                            <input type="text" value="{{ $student->mother_name }}"
                                                class="form-control @error('mother_name') is-invalid @enderror"
                                                name="mother_name" placeholder="Nama Ibu" minlength="3" required>
                                            @error('mother_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">NIK Ibu</label>
                                            <input type="text" value="{{ $student->mother_nik }}"
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
                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                <a href="{{ route('child-sch.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
