@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
    <style>
        #vaccineOutModal .select2-selection--single {
            height: auto;
            border-color: var(--bs-border-color);
            border-radius: var(--bs-border-radius);
        }

        #vaccineOutModal .select2-selection__rendered {
            padding: .469rem 2rem .469rem .8rem;
            color: var(--bs-body-color);
            line-height: 1.5;
        }

        #vaccineOutModal .select2-selection__arrow {
            height: 100%;
        }

        #vaccineOutModal .select2-container--focus .select2-selection--single,
        #vaccineOutModal .select2-container--open .select2-selection--single {
            border-color: var(--bs-gray-400);
        }

        #vaccineOutModal .vvm-fieldset legend {
            float: none;
            width: auto;
            font-size: inherit;
        }

        .vvm-options {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .5rem;
        }

        .vvm-option {
            display: flex;
            gap: .75rem;
            align-items: flex-start;
            padding: .75rem;
            margin-bottom: 0;
            border: 1px solid var(--bs-border-color);
            border-radius: var(--bs-border-radius);
            background-color: var(--bs-white);
            cursor: pointer;
        }

        .vvm-option .form-check-input {
            flex-shrink: 0;
            float: none;
            margin: .2rem 0 0;
        }

        .vvm-option:hover {
            border-color: var(--vvm-color);
        }

        .vvm-option:has(input:checked) {
            border-color: var(--vvm-color);
            background-color: var(--vvm-background);
        }

        .vvm-option:has(input:focus-visible) {
            outline: 2px solid var(--bs-primary);
            outline-offset: 2px;
        }

        .vvm-option input:checked {
            background-color: var(--vvm-color);
            border-color: var(--vvm-color);
        }

        .vvm-option strong,
        .vvm-option span {
            display: block;
        }

        .vvm-option strong {
            font-weight: 500;
        }

        .vvm-option strong::before {
            content: '';
            display: inline-block;
            width: .5rem;
            height: .5rem;
            margin-right: .4rem;
            border-radius: 50%;
            background-color: var(--vvm-color);
            vertical-align: middle;
        }

        .vvm-option .vvm-description {
            margin-top: .25rem;
            color: var(--bs-secondary);
            font-size: .812rem;
            line-height: 1.5;
        }

        .vvm-indicator {
            display: inline-block;
            min-width: 2rem;
            padding: .2rem .45rem;
            border-radius: 3px;
            color: white;
            font-weight: 700;
            text-align: center;
        }

        @media (max-width: 575.98px) {
            .vvm-options {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
                                            <th>VVM</th>
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
                                                <td>
                                                    @if ($vaccineOut->vvm)
                                                        @php
                                                            $vvmColors = [
                                                                'A' => '#198754',
                                                                'B' => '#d6a500',
                                                                'C' => '#fd7e14',
                                                                'D' => '#dc3545',
                                                            ];
                                                        @endphp
                                                        <span class="vvm-indicator"
                                                            style="background-color: {{ $vvmColors[$vaccineOut->vvm] }}"
                                                            title="{{ ['A' => 'Kondisi vaksin baik, vaksin dapat digunakan', 'B' => 'Vaksin harus segera digunakan jika belum kadaluarsa', 'C' => 'Kondisi vaksin tidak baik, vaksin tidak dapat digunakan', 'D' => 'Kondisi vaksin tidak baik, vaksin tidak dapat digunakan'][$vaccineOut->vvm] }}">
                                                            {{ $vaccineOut->vvm }}
                                                        </span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
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

                        <fieldset class="vvm-fieldset mb-3">
                            <legend class="form-label">Kondisi VVM *</legend>
                            <div class="vvm-options">
                                <label class="vvm-option" style="--vvm-color: #198754; --vvm-background: #f0f8f4">
                                    <input type="radio" class="form-check-input" name="vvm" value="A" required>
                                    <span><strong>A - Baik</strong><span class="vvm-description">Kondisi vaksin baik, vaksin dapat
                                            digunakan.</span></span>
                                </label>
                                <label class="vvm-option" style="--vvm-color: #d6a500; --vvm-background: #fffbeb">
                                    <input type="radio" class="form-check-input" name="vvm" value="B">
                                    <span><strong>B - Segera digunakan</strong><span class="vvm-description">Vaksin harus segera digunakan jika
                                            belum kadaluarsa.</span></span>
                                </label>
                                <label class="vvm-option" style="--vvm-color: #fd7e14; --vvm-background: #fff5ed">
                                    <input type="radio" class="form-check-input" name="vvm" value="C">
                                    <span><strong>C - Tidak baik</strong><span class="vvm-description">Kondisi vaksin tidak baik, vaksin tidak dapat
                                            digunakan.</span></span>
                                </label>
                                <label class="vvm-option" style="--vvm-color: #dc3545; --vvm-background: #fdf1f2">
                                    <input type="radio" class="form-check-input" name="vvm" value="D">
                                    <span><strong>D - Tidak baik</strong><span class="vvm-description">Kondisi vaksin tidak baik, vaksin tidak dapat
                                            digunakan.</span></span>
                                </label>
                            </div>
                        </fieldset>

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
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>

    <script>
        function resetForm() {
            document.getElementById('vaccineOutForm').reset();
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('vaccineOutForm').action = '{{ route('vaccine-out.store') }}';
            document.getElementById('vaccineOutModalLabel').textContent = 'Tambah Pengeluaran Vaksin';

            // Show vaccine select and make it required
            document.getElementById('vaccineSelectField').style.display = 'block';
            document.getElementById('id_vaccine').required = true;
            $('#id_vaccine').val('').trigger('change');

            document.getElementById('date_out').value = new Date().toISOString().split('T')[0];
            document.getElementById('stockInfo').textContent = '';
        }

        function editVaccineOut(vaccineOut) {
            document.getElementById('date_out').value = vaccineOut.date_out.split('T')[0];
            document.getElementById('quantity').value = vaccineOut.quantity;
            document.getElementById('notes').value = vaccineOut.notes || '';
            document.querySelectorAll('#vaccineOutForm input[name="vvm"]').forEach(input => {
                input.checked = input.value === vaccineOut.vvm;
            });

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
        $('#id_vaccine').on('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const stock = selectedOption.getAttribute('data-stock');
            if (stock) {
                document.getElementById('stockInfo').textContent = `Stok tersedia: ${stock}`;
                document.getElementById('quantity').max = stock;
            } else {
                document.getElementById('stockInfo').textContent = '';
                document.getElementById('quantity').removeAttribute('max');
            }
        });

        // Set default date to today
        document.addEventListener('DOMContentLoaded', function() {
            $('#id_vaccine').select2({
                dropdownParent: $('#vaccineOutModal'),
                width: '100%',
                placeholder: 'Pilih Vaksin',
                minimumResultsForSearch: 0,
                language: {
                    noResults: function() {
                        return 'Vaksin tidak ditemukan';
                    }
                }
            }).on('select2:open', function() {
                $('#vaccineOutModal .select2-search__field')
                    .attr('placeholder', 'Cari nama vaksin atau nomor batch')
                    .attr('aria-label', 'Cari nama vaksin atau nomor batch')
                    .trigger('focus');
            });
            document.getElementById('date_out').value = new Date().toISOString().split('T')[0];
        });
    </script>
@endpush
