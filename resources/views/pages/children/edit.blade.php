@extends('layouts.app')

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Anak</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Anak</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h6 class="card-title">Edit Anak</h6>
                                </div>
                            </div>
                            <form class="forms-sample" action="{{ route('children.update', $children->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="">Desa</label>
                                            <select class="form-select mb-3" name="id_village" required>
                                                <option value="" selected disabled>-- Pilih Desa --</option>
                                                @foreach ($villages as $village)
                                                    <option value="{{ $village->id }}"
                                                        {{ $children->id_village == $village->id ? 'selected' : '' }}>
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
                                            <input type="text" value="{{ $children->name_child }}"
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
                                            <input type="text" value="{{ $children->nik }}"
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
                                            <input type="date" value="{{ $children->date_birth }}"
                                                class="form-control @error('date_birth') is-invalid @enderror"
                                                name="date_birth" required>
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
                                            <input type="text" value="{{ $children->mother_name }}"
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
                                            <input type="text" value="{{ $children->mother_nik }}"
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
                                                        id="gender1" value="L" @if ($children->gender == 'L') checked @endif>
                                                    <label class="form-check-label" for="gender1">
                                                        Laki-Laki
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="gender"
                                                        id="gender2" value="P" @if ($children->gender == 'P') checked @endif>
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
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                            name="address" rows="2">{{ $children->address }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route('children.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
