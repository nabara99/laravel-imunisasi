@extends('layouts.app')

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Sasaran Anak IDL</a></li>
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
                            <form class="forms-sample" action="{{ route('idl-target.update', $idlTarget->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="">Desa</label>
                                            <select class="form-select mb-3" name="village_id" required>
                                                <option value="" selected disabled>-- Pilih Desa --</option>
                                                @foreach ($villages as $village)
                                                    <option value="{{ $village->id }}"
                                                        {{ $idlTarget->village_id == $village->id ? 'selected' : '' }}>
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
                                            <label for="" class="form-label">Jumlah Anak Laki-Laki</label>
                                            <input type="number" value="{{ $idlTarget->sum_boys }}"
                                                class="form-control @error('sum_boys') is-invalid @enderror"
                                                name="sum_boys" placeholder="Junmlah Anak" required>
                                            @error('sum_boys')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jumlah Anak Perempuan</label>
                                            <input type="number" value="{{ $idlTarget->sum_boys }}"
                                                class="form-control @error('sum_girls') is-invalid @enderror"
                                                name="sum_girls" placeholder="JUmlah Anak" required>
                                            @error('sum_girls')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                <a href="{{ route('idl-target.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
