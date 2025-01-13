@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">WUS</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit WUS</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h6 class="card-title">Edit WUS</h6>
                                </div>
                            </div>
                            <form class="forms-sample" action="{{ route('wus.update', $wus->id) }}" method="POST">
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
                                                        {{ $wus->id_village == $village->id ? 'selected' : '' }}>
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
                                            <label for="" class="form-label">Nama</label>
                                            <input type="text" value="{{ $wus->name_wus }}"
                                                class="form-control @error('name_wus') is-invalid @enderror" name="name_wus"
                                                minlength="3" required>
                                            @error('name_wus')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">NIK</label>
                                            <input type="text" value="{{ $wus->nik }}"
                                                class="form-control @error('nik') is-invalid @enderror" name="nik"
                                                maxlength="16" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                                required>
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
                                            <input type="text" id="datePicker" value="{{ $wus->date_birth }}"
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
                                            <label for="" class="form-label">Status Kehamilan</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="hamil"
                                                        id="hamil" value="1" @if ($wus->hamil == '1') checked @endif>
                                                    <label class="form-check-label" for="hamil">
                                                        Hamil
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="hamil"
                                                        id="tidak" value="0" @if ($wus->hamil == '0') checked @endif>
                                                    <label class="form-check-label" for="tidak">
                                                        Tidak
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="mb-3">
                                            <label for="">Alamat</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="2">
                                                {{ $wus->address }}
                                            </textarea>
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route('wus.index') }}" class="btn btn-secondary">Batal</a>
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
