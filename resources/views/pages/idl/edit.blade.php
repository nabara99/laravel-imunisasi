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
                            <form class="forms-sample" action="{{ route('idl-imun.update', $idl->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="">Bayi</label>
                                            <select name="id_children_disabled" class="form-select mb-3" disabled>
                                                @foreach ($childrens as $children)
                                                    <option value="{{ $children->id }}"
                                                        {{ $idl->id_children == $children->id ? 'selected' : '' }}>
                                                        {{ $children->name_child }} - {{ $children->nik }} -
                                                        {{ date('j F Y', strtotime($children->date_birth)) }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="id_children" value="{{ $idl->id_children }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">HB0</label>
                                            <input type="text" id="datePicker" value="{{ $idl->hb0 }}"
                                                class="form-control @error('hb0') is-invalid @enderror" name="hb0"
                                                placeholder="Pilih Tanggal">
                                            @error('hb0')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">BCG</label>
                                            <input type="text" id="datePicker" value="{{ $idl->bcg }}"
                                                class="form-control @error('bcg') is-invalid @enderror" name="bcg"
                                                placeholder="Pilih Tanggal">
                                            @error('bcg')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Polio1</label>
                                            <input type="text" id="datePicker" value="{{ $idl->polio1 }}"
                                                class="form-control @error('polio1') is-invalid @enderror" name="polio1"
                                                placeholder="Pilih Tanggal">
                                            @error('polio1')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Penta1</label>
                                            <input type="text" id="datePicker" value="{{ $idl->penta1 }}"
                                                class="form-control @error('penta1') is-invalid @enderror" name="penta1"
                                                placeholder="Pilih Tanggal">
                                            @error('penta1')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Polio2</label>
                                            <input type="text" id="datePicker" value="{{ $idl->polio2 }}"
                                                class="form-control @error('polio2') is-invalid @enderror" name="polio2"
                                                placeholder="Pilih Tanggal">
                                            @error('polio2')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">PCV1</label>
                                            <input type="text" id="datePicker" value="{{ $idl->pcv1 }}"
                                                class="form-control @error('pcv1') is-invalid @enderror" name="pcv1"
                                                placeholder="Pilih Tanggal">
                                            @error('pcv1')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Rotavirus1</label>
                                            <input type="text" id="datePicker" value="{{ $idl->rotavirus1 }}"
                                                class="form-control @error('rotavirus1') is-invalid @enderror"
                                                name="rotavirus1" placeholder="Pilih Tanggal">
                                            @error('rotavirus1')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Penta2</label>
                                            <input type="text" id="datePicker" value="{{ $idl->penta2 }}"
                                                class="form-control @error('penta2') is-invalid @enderror" name="penta2"
                                                placeholder="Pilih Tanggal">
                                            @error('penta2')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Polio3</label>
                                            <input type="text" id="datePicker" value="{{ $idl->polio3 }}"
                                                class="form-control @error('polio3') is-invalid @enderror" name="polio3"
                                                placeholder="Pilih Tanggal">
                                            @error('polio3')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">PCV2</label>
                                            <input type="text" id="datePicker" value="{{ $idl->pcv2 }}"
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
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Rotavirus2</label>
                                            <input type="text" id="datePicker" value="{{$idl->rotavirus2 }}"
                                                class="form-control @error('rotavirus2') is-invalid @enderror"
                                                name="rotavirus2" placeholder="Pilih Tanggal">
                                            @error('rotavirus2')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Penta3</label>
                                            <input type="text" id="datePicker" value="{{ $idl->penta3 }}"
                                                class="form-control @error('penta3') is-invalid @enderror" name="penta3"
                                                placeholder="Pilih Tanggal">
                                            @error('penta3')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Polio4</label>
                                            <input type="text" id="datePicker" value="{{ $idl->polio4 }}"
                                                class="form-control @error('polio4') is-invalid @enderror" name="polio4"
                                                placeholder="Pilih Tanggal">
                                            @error('polio4')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">IPV1</label>
                                            <input type="text" id="datePicker" value="{{ $idl->ipv1 }}"
                                                class="form-control @error('ipv1') is-invalid @enderror" name="ipv1"
                                                placeholder="Pilih Tanggal">
                                            @error('ipv1')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Rotavirus3</label>
                                            <input type="text" id="datePicker" value="{{ $idl->rotavirus3 }}"
                                                class="form-control @error('rotavirus3') is-invalid @enderror"
                                                name="rotavirus3" placeholder="Pilih Tanggal">
                                            @error('rotavirus3')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">MR1</label>
                                            <input type="text" id="datePicker" value="{{ $idl->mr1 }}"
                                                class="form-control @error('mr1') is-invalid @enderror" name="mr1"
                                                placeholder="Pilih Tanggal">
                                            @error('mr1')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="" class="form-label">IPV2</label>
                                            <input type="text" id="datePicker" value="{{ $idl->ipv2 }}"
                                                class="form-control @error('ipv2') is-invalid @enderror" name="ipv2"
                                                placeholder="Pilih Tanggal">
                                            @error('ipv2')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Status</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="lengkap"
                                                        id="ya" value="1" @if ($idl->lengkap == '1') checked @endif>
                                                    <label class="form-check-label" for="ya">
                                                        Lengkap
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="lengkap"
                                                        id="tidak" value="0" @if ($idl->lengkap == '0') checked @endif>
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

    <script>
        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
        });
    </script>
@endpush
