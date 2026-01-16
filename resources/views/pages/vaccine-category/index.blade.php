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
                    <li class="breadcrumb-item active" aria-current="page">Kategori Kemasan</li>
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
                                    <h6 class="card-title">Kategori Kemasan Vaksin</h6>
                                    <p class="text-muted mb-0">Kategori kemasan vaksin seperti: Vial, Botol, Ampul, dll</p>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary mb-1 mb-md-0" data-bs-toggle="modal"
                                        data-bs-target="#categoryModal" onclick="resetForm()">
                                        <i class="fa-solid fa-plus"></i> Tambah Kategori
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="dataTableExample" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No.</th>
                                            <th>Nama Kategori</th>
                                            <th style="width: 15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $index => $category)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        onclick="editCategory({{ $category->id }}, '{{ $category->name }}')"
                                                        title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    <form action="{{ route('vaccine-category.destroy', $category->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
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
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Tambah Kategori Kemasan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="categoryForm" method="POST" action="{{ route('vaccine-category.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="id" id="categoryId">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori *</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Contoh: Vial, Botol, Ampul, dll" required>
                            <div class="invalid-feedback" id="nameError"></div>
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
            document.getElementById('categoryForm').reset();
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('categoryForm').action = '{{ route('vaccine-category.store') }}';
            document.getElementById('categoryModalLabel').textContent = 'Tambah Kategori Kemasan';
            document.getElementById('name').classList.remove('is-invalid');
        }

        function editCategory(id, name) {
            document.getElementById('categoryId').value = id;
            document.getElementById('name').value = name;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('categoryForm').action = `/vaccine-category/${id}`;
            document.getElementById('categoryModalLabel').textContent = 'Edit Kategori Kemasan';

            var modal = new bootstrap.Modal(document.getElementById('categoryModal'));
            modal.show();
        }
    </script>
@endpush
