@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Inventori Vaksin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Vaksin Keluar</li>
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
                                    <h6 class="card-title">Vaksin Keluar</h6>
                                    <p class="text-muted mb-0">Data vaksin keluar</p>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary mb-1 mb-md-0" data-bs-toggle="modal"
                                        data-bs-target="#vaccineOutModal" onclick="resetForm()">
                                        <i class="fa-solid fa-minus"></i> Vaksin Keluar
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
                                            <th>Jumlah</th>
                                            <th>Keterangan</th>
                                            <th style="width: 10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vaccineOuts as $index => $vaccineOut)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $vaccineOut->date_out->format('d/m/Y') }}</td>
                                                <td>{{ $vaccineOut->vaccine->vaccine_name }}</td>
                                                <td>{{ $vaccineOut->vaccine->category->name }}</td>
                                                <td>{{ $vaccineOut->vaccine->batch_number }}</td>
                                                <td>{{ number_format($vaccineOut->quantity) }}</td>
                                                <td>{{ $vaccineOut->notes ?? '-' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        onclick="editVaccineOut({{ json_encode($vaccineOut) }})" title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    <form action="{{ route('vaccine-out.destroy', $vaccineOut->id) }}"
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
    <div class="modal fade" id="vaccineOutModal" tabindex="-1" aria-labelledby="vaccineOutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vaccineOutModalLabel">Tambah Pengeluaran Vaksin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="vaccineOutForm" method="POST" action="{{ route('vaccine-out.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="date_out" class="form-label">Tanggal Pengeluaran *</label>
                            <input type="date" name="date_out" id="date_out" class="form-control" required>
                        </div>

                        <div class="mb-3" id="vaccineSelectField">
                            <label for="id_vaccine" class="form-label">Pilih Vaksin *</label>
                            <select name="id_vaccine" id="id_vaccine" class="form-control">
                                <option value="">Pilih Vaksin</option>
                                @foreach ($vaccines as $vaccine)
                                    <option value="{{ $vaccine->id }}" data-stock="{{ $vaccine->stock }}">
                                        {{ $vaccine->vaccine_name }} - {{ $vaccine->batch_number }}
                                        (Stok: {{ number_format($vaccine->stock) }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted" id="stockInfo"></small>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah *</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
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
            document.getElementById('vaccineOutForm').reset();
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('vaccineOutForm').action = '{{ route('vaccine-out.store') }}';
            document.getElementById('vaccineOutModalLabel').textContent = 'Tambah Pengeluaran Vaksin';

            // Show vaccine select and make it required
            document.getElementById('vaccineSelectField').style.display = 'block';
            document.getElementById('id_vaccine').required = true;

            document.getElementById('date_out').value = new Date().toISOString().split('T')[0];
            document.getElementById('stockInfo').textContent = '';
        }

        function editVaccineOut(vaccineOut) {
            document.getElementById('date_out').value = vaccineOut.date_out.split('T')[0];
            document.getElementById('quantity').value = vaccineOut.quantity;
            document.getElementById('notes').value = vaccineOut.notes || '';

            // Hide vaccine select on edit and remove required attribute
            document.getElementById('vaccineSelectField').style.display = 'none';
            document.getElementById('id_vaccine').required = false;

            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('vaccineOutForm').action = `/vaccine-out/${vaccineOut.id}`;
            document.getElementById('vaccineOutModalLabel').textContent = 'Edit Pengeluaran Vaksin';

            var modal = new bootstrap.Modal(document.getElementById('vaccineOutModal'));
            modal.show();
        }

        // Show stock info when vaccine is selected
        document.getElementById('id_vaccine').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const stock = selectedOption.getAttribute('data-stock');
            if (stock) {
                document.getElementById('stockInfo').textContent = `Stok tersedia: ${stock}`;
                document.getElementById('quantity').max = stock;
            }
        });

        // Set default date to today
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('date_out').value = new Date().toISOString().split('T')[0];
        });
    </script>
@endpush
