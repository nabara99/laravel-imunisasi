@extends('layouts.app')

@extends('layouts.app')

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Sekolah</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Sekolah</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h6 class="card-title">Edit Sekolah</h6>
                                </div>
                            </div>
                            <form class="forms-sample" action="{{ route('school.update', $school->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Sekolah *</label>
                                    <input type="text" value="{{ $school->name }}"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        placeholder="Nama Desa" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route('school.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

