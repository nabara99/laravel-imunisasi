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
                    <li class="breadcrumb-item active" aria-current="page">Edit BIAS</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h6 class="card-title">Edit BIAS</h6>
                                </div>
                            </div>
                            <form class="forms-sample" action="{{ route('bias.update', $bias->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="">Siswa</label>
                                            <select class="students form-select" name="id_student" id="studentSelect"
                                                disabled>
                                                @foreach ($students as $student)
                                                    <option value="{{ $student->id }}"
                                                        data-class="{{ $student->class }}"
                                                        data-gender="{{ $student->gender }}"
                                                        {{ $bias->id_student == $student->id ? 'selected' : '' }}>
                                                        {{ $student->name_student }} - {{ $student->nik }} -
                                                        {{ $student->gender == 'L' ? 'Laki-Laki' : 'Perempuan' }} - Kelas:
                                                        {{ $student->class }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="id_student" value="{{ $bias->id_student }}">
                                        </div>
                                    </div>
                                </div>

                                <div id="dynamicInputs" class="row">
                                </div>

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

            const studentClass = $('#studentSelect option:selected').data('class');
            const studentGender = $('#studentSelect option:selected').data('gender');
            const dynamicInputs = $('#dynamicInputs');

            renderDynamicInputs(studentClass, studentGender);

            function renderDynamicInputs(studentClass, studentGender) {
                dynamicInputs.empty();

                if (studentClass === 1) {
                    dynamicInputs.append(createDateInput('DT', '{{ $bias->dt ?? '' }}'));
                    dynamicInputs.append(createDateInput('MR', '{{ $bias->mr ?? '' }}'));
                } else if (studentClass === 2) {
                    dynamicInputs.append(createDateInput('TD1', '{{ $bias->td1 ?? '' }}'));
                } else if (studentClass === 5 && studentGender === 'P') {
                    dynamicInputs.append(createDateInput('TD2PI', '{{ $bias->td2pi ?? '' }}'));
                    dynamicInputs.append(createDateInput('HPV1', '{{ $bias->hpv1 ?? '' }}'));
                } else if (studentClass === 5 && studentGender === 'L') {
                    dynamicInputs.append(createDateInput('TD2PA', '{{ $bias->td2pa ?? '' }}'));
                } else if (studentClass === 6 && studentGender === 'P') {
                    dynamicInputs.append(createDateInput('HPV2', '{{ $bias->hpv2 ?? '' }}'));
                }
            }

            function createDateInput(label, value) {
                return `
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">${label}</label>
                            <input type="date" class="form-control" name="${label.toLowerCase()}" value="${value}"
                                placeholder="Pilih tanggal">
                        </div>
                    </div>
                `;
            }
        });
    </script>
@endpush
