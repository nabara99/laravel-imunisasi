@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">BIAS</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah BIAS</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h6 class="card-title">Tambah BIAS</h6>
                                </div>
                            </div>
                            <form class="forms-sample" action="{{ route('bias.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="mb-2" for="studentSelect">Siswa</label>
                                            <select
                                                class="students form-select @error('id_student')
                                                is-invalid
                                            @enderror"
                                                name="id_student" id="studentSelect" data-width="100%" required>
                                                <option value="">-- Pilih Siswa --</option>
                                                @foreach ($students as $student)
                                                    <option value="{{ $student->id }}" data-class="{{ $student->class }}"
                                                        data-gender="{{ $student->gender }}"
                                                        {{ old('id_student') == $student->id ? 'selected' : '' }}>
                                                        {{ $student->name_student }} - {{ $student->nik }} -
                                                        {{ $student->gender == 'L' ? 'Laki-Laki' : 'Perempuan' }} - Kelas:
                                                        {{ $student->class }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_student')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div id="dynamicInputs" class="row"></div>

                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                <a href="{{ route('bias.index') }}" class="btn btn-secondary">Batal</a>
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
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.students').select2();

            $('#studentSelect').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const studentClass = selectedOption.data('class');
                const studentGender = selectedOption.data('gender');
                const dynamicInputs = $('#dynamicInputs');

                dynamicInputs.empty();

                if (studentClass === 1) {
                    dynamicInputs.append(createDateInput('DT'));
                    dynamicInputs.append(createDateInput('MR'));
                } else if (studentClass === 2) {
                    dynamicInputs.append(createDateInput('TD1'));
                } else if (studentClass === 5 && studentGender === 'P') {
                    dynamicInputs.append(createDateInput('TD2PI'));
                    dynamicInputs.append(createDateInput('HPV1'));
                } else if (studentClass === 5 && studentGender === 'L') {
                    dynamicInputs.append(createDateInput('TD2PA'));
                } else if (studentClass === 6 && studentGender === 'P') {
                    dynamicInputs.append(createDateInput('HPV2'));
                }
            });
        });

        function createDateInput(label) {
            return `
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label">${label}</label>
                        <input type="date" class="form-control" name="${label.toLowerCase()}" placeholder="Pilih tanggal">
                    </div>
                </div>
            `;
        }

    </script>
@endpush
