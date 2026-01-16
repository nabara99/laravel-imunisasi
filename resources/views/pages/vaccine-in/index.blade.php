@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Inventori Vaksin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Vaksin Masuk</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-8"></div>
                <div class="col-4">
                    @include('layouts.alert')
                </div>

                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h6 class="card-title">Vaksin Masuk</h6>
                                    <p class="text-muted mb-0">Data vaksin masuk</p>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary mb-1 mb-md-0" data-bs-toggle="modal"
                                        data-bs-target="#vaccineInModal" onclick="resetForm()">
                                        <i class="fa-solid fa-plus"></i> Vaksin Masuk
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="dataTableExample" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%">No.</th>
                                            <th>Tanggal</th>
                                            <th>Nama Vaksin</th>
                                            <th>Kategori</th>
                                            <th>Batch</th>
                                            <th>Expired</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Keterangan</th>
                                            <th style="width: 10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vaccineIns as $index => $vaccineIn)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $vaccineIn->date_in->format('d/m/Y') }}</td>
                                                <td>{{ $vaccineIn->vaccine->vaccine_name }}</td>
                                                <td>{{ $vaccineIn->vaccine->category->name }}</td>
                                                <td>{{ $vaccineIn->vaccine->batch_number }}</td>
                                                <td>{{ $vaccineIn->vaccine->expired_date->format('d/m/Y') }}</td>
                                                <td>{{ number_format($vaccineIn->quantity) }}</td>
                                                <td>Rp {{ number_format($vaccineIn->vaccine->price) }}</td>
                                                <td>{{ $vaccineIn->notes ?? '-' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        onclick="editVaccineIn({{ json_encode($vaccineIn) }})" title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    <form action="{{ route('vaccine-in.destroy', $vaccineIn->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="vaccineInModal" tabindex="-1" aria-labelledby="vaccineInModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vaccineInModalLabel">Tambah Penerimaan Vaksin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="vaccineInForm" method="POST" action="{{ route('vaccine-in.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="id" id="vaccineInId">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_in" class="form-label">Tanggal Penerimaan *</label>
                                <input type="date" name="date_in" id="date_in" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3" id="quantityField">
                                <label for="quantity" class="form-label">Jumlah *</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" min="1"
                                    required>
                            </div>
                        </div>

                        <div id="vaccineFields">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="vaccine_name" class="form-label">Nama Vaksin *</label>
                                    <input type="text" name="vaccine_name" id="vaccine_name" class="form-control"
                                        placeholder="Contoh: Sinovac, AstraZeneca" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="id_category_vaccine" class="form-label">Kategori Kemasan *</label>
                                    <select name="id_category_vaccine" id="id_category_vaccine" class="form-control"
                                        required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="batch_number" class="form-label">Nomor Batch *</label>
                                    <input type="text" name="batch_number" id="batch_number" class="form-control"
                                        placeholder="Contoh: BATCH001" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="expired_date" class="form-label">Tanggal Kadaluarsa *</label>
                                    <input type="date" name="expired_date" id="expired_date" class="form-control"
                                        required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Harga per Unit (Rp) *</label>
                                <input type="number" name="price" id="price" class="form-control" min="0"
                                    placeholder="0" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Keterangan</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3"
                                placeholder="Keterangan tambahan (opsional)"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('js/data-table.js') }}"></script>

    <script>
        function resetForm() {
            document.getElementById('vaccineInForm').reset();
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('vaccineInForm').action = '{{ route('vaccine-in.store') }}';
            document.getElementById('vaccineInModalLabel').textContent = 'Tambah Penerimaan Vaksin';
            document.getElementById('vaccineFields').style.display = 'block';
            document.getElementById('date_in').value = new Date().toISOString().split('T')[0];
        }

        function editVaccineIn(vaccineIn) {
            document.getElementById('vaccineInId').value = vaccineIn.id;
            document.getElementById('date_in').value = vaccineIn.date_in.split('T')[0];
            document.getElementById('quantity').value = vaccineIn.quantity;
            document.getElementById('notes').value = vaccineIn.notes || '';

            // Hide vaccine fields on edit (only allow editing quantity, date, notes)
            document.getElementById('vaccineFields').style.display = 'none';

            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('vaccineInForm').action = `/vaccine-in/${vaccineIn.id}`;
            document.getElementById('vaccineInModalLabel').textContent = 'Edit Penerimaan Vaksin';

            var modal = new bootstrap.Modal(document.getElementById('vaccineInModal'));
            modal.show();
        }

        // Set default date to today
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('date_in').value = new Date().toISOString().split('T')[0];
        });
    </script>
@endpush
