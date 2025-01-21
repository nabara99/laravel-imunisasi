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
                            <form class="forms-sample" action="{{ route('ibl-imun.update', $ibl->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="">Bayi</label>
                                            <select name="id_children_disabled" class="form-select mb-3" disabled>
                                                @foreach ($childrens as $children)
                                                    <option value="{{ $children->id }}"
                                                        {{ $ibl->id_children == $children->id ? 'selected' : '' }}>
                                                        {{ $children->name_child }} - {{ $children->nik }} -
                                                        {{ date('j F Y', strtotime($children->date_birth)) }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="id_children" value="{{ $ibl->id_children }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">PCV3</label>
                                            <input type="text" id="datePicker" value="{{ $ibl->pcv3 }}"
                                                class="form-control @error('pcv3') is-invalid @enderror" name="pcv3"
                                                placeholder="Pilih Tanggal">
                                            @error('pcv3')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Penta4</label>
                                            <input type="text" id="datePicker" value="{{ $ibl->penta4 }}"
                                                class="form-control @error('penta4') is-invalid @enderror" name="penta4"
                                                placeholder="Pilih Tanggal">
                                            @error('penta4')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">MR2</label>
                                            <input type="text" id="datePicker" value="{{ $ibl->mr2 }}"
                                                class="form-control @error('mr2') is-invalid @enderror" name="mr2"
                                                placeholder="Pilih Tanggal">
                                            @error('mr2')
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
                                                        id="ya" value="1" @if ($ibl->lengkap == '1') checked @endif>
                                                    <label class="form-check-label" for="ya">
                                                        Lengkap
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="lengkap"
                                                        id="tidak" value="0" @if ($ibl->lengkap == '0') checked @endif>
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

    <script>
        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
        });
    </script>
@endpush
