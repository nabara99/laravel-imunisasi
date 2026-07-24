@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
    <style>
        .tab-badge { font-size: 0.7rem; vertical-align: middle; }
        .nav-tabs .nav-link { color: #6c757d; }
        .nav-tabs .nav-link.active { font-weight: 600; }
        .filter-card { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; padding: 1rem 1.25rem; margin-bottom: 1.25rem; }
    </style>
@endpush

@section('main')
<div class="main-content">
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Input Imunisasi</li>
                <li class="breadcrumb-item active" aria-current="page">Filter Imunisasi</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-8"></div>
            <div class="col-4">@include('layouts.alert')</div>

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                            <div>
                                <h6 class="card-title mb-0">Filter Imunisasi</h6>
                                <small class="text-muted">Filter data per bulan dan cari berdasarkan nama</small>
                            </div>
                        </div>

                        {{-- Filter Form --}}
                        <div class="filter-card">
                            <form method="GET" action="{{ route('imunisasi.index') }}" class="row g-2 align-items-end">
                                <input type="hidden" name="tab" id="activeTabInput" value="{{ $tab }}">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold mb-1">Bulan</label>
                                    <input type="month" name="month" class="form-control form-control-sm"
                                           value="{{ $month }}">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold mb-1">Cari Nama</label>
                                    <input type="text" name="search" class="form-control form-control-sm"
                                           placeholder="Cari nama anak / WUS..." value="{{ $search }}">
                                </div>
                                <div class="col-md-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i data-feather="search" style="width:14px;height:14px;"></i> Filter
                                    </button>
                                    <a href="{{ route('imunisasi.index') }}" class="btn btn-outline-secondary btn-sm">
                                        <i data-feather="x" style="width:14px;height:14px;"></i> Reset
                                    </a>
                                </div>
                            </form>
                            @if($month || $search)
                            <div class="mt-2">
                                <small class="text-muted">
                                    Menampilkan data
                                    @if($month) bulan <strong>{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y') }}</strong>@endif
                                    @if($search) dengan nama "<strong>{{ $search }}</strong>"@endif
                                </small>
                            </div>
                            @endif
                        </div>

                        {{-- Nav Tabs --}}
                        <ul class="nav nav-tabs" id="imunisasiTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $tab == 'idl' ? 'active' : '' }}"
                                        id="tab-idl" data-bs-toggle="tab" data-bs-target="#pane-idl"
                                        type="button" role="tab" data-tab="idl">
                                    IDL
                                    <span class="badge bg-primary tab-badge ms-1">{{ $idls->count() }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $tab == 'ibl' ? 'active' : '' }}"
                                        id="tab-ibl" data-bs-toggle="tab" data-bs-target="#pane-ibl"
                                        type="button" role="tab" data-tab="ibl">
                                    IBL
                                    <span class="badge bg-success tab-badge ms-1">{{ $ibls->count() }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $tab == 'bias' ? 'active' : '' }}"
                                        id="tab-bias" data-bs-toggle="tab" data-bs-target="#pane-bias"
                                        type="button" role="tab" data-tab="bias">
                                    BIAS
                                    <span class="badge bg-warning text-dark tab-badge ms-1">{{ $bias->count() }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $tab == 'wus' ? 'active' : '' }}"
                                        id="tab-wus" data-bs-toggle="tab" data-bs-target="#pane-wus"
                                        type="button" role="tab" data-tab="wus">
                                    WUS
                                    <span class="badge bg-info tab-badge ms-1">{{ $wus->count() }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $tab == 'bumil' ? 'active' : '' }}"
                                        id="tab-bumil" data-bs-toggle="tab" data-bs-target="#pane-bumil"
                                        type="button" role="tab" data-tab="bumil">
                                    Bumil
                                    <span class="badge bg-danger tab-badge ms-1">{{ $bumil->count() }}</span>
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content mt-3" id="imunisasiTabContent">

                            {{-- ===== TAB IDL ===== --}}
                            <div class="tab-pane fade {{ $tab == 'idl' ? 'show active' : '' }}"
                                 id="pane-idl" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="tableIDL" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Desa</th>
                                                <th>Nama Bayi</th>
                                                <th>NIK</th>
                                                <th>Tgl Lahir</th>
                                                <th>Jenkel</th>
                                                <th>Nama Ibu</th>
                                                <th>Riwayat Vaksin</th>
                                                <th>Status</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($idls as $index => $idl)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td style="white-space:normal">{{ $idl->village_name }}</td>
                                                <td style="white-space:normal">{{ $idl->name_child }}</td>
                                                <td>{{ $idl->nik }}</td>
                                                <td>{{ $idl->date_birth ? date('d/m/Y', strtotime($idl->date_birth)) : '-' }}</td>
                                                <td>{{ $idl->gender }}</td>
                                                <td style="white-space:normal">{{ $idl->mother_name }}</td>
                                                <td style="white-space:normal; font-size:0.8rem;">
                                                    @php
                                                        $riwayat = [];
                                                        $vaksinIdl = ['hb0','bcg','polio1','penta1','polio2','pcv1','rotavirus1','penta2','polio3','pcv2','rotavirus2','penta3','polio4','ipv1','rotavirus3','mr1','ipv2'];
                                                        foreach ($vaksinIdl as $v) {
                                                            if ($idl->$v) $riwayat[] = strtoupper($v) . ' (' . date('d/m/Y', strtotime($idl->$v)) . ')';
                                                        }
                                                    @endphp
                                                    {{ implode(', ', $riwayat) ?: '-' }}
                                                </td>
                                                <td>
                                                    @if ($idl->lengkap == '1')
                                                        <span class="badge bg-success">Lengkap</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">Belum</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('idl-imun.edit', $idl->id) }}" title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- ===== TAB IBL ===== --}}
                            <div class="tab-pane fade {{ $tab == 'ibl' ? 'show active' : '' }}"
                                 id="pane-ibl" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="tableIBL" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Desa</th>
                                                <th>Nama Anak</th>
                                                <th>NIK</th>
                                                <th>Tgl Lahir</th>
                                                <th>Jenkel</th>
                                                <th>Nama Ibu</th>
                                                <th>Riwayat Vaksin</th>
                                                <th>Status</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ibls as $index => $ibl)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td style="white-space:normal">{{ $ibl->village_name }}</td>
                                                <td style="white-space:normal">{{ $ibl->name_child }}</td>
                                                <td>{{ $ibl->nik }}</td>
                                                <td>{{ $ibl->date_birth ? date('d/m/Y', strtotime($ibl->date_birth)) : '-' }}</td>
                                                <td>{{ $ibl->gender }}</td>
                                                <td style="white-space:normal">{{ $ibl->mother_name }}</td>
                                                <td style="white-space:normal; font-size:0.8rem;">
                                                    @php
                                                        $riwayatIbl = [];
                                                        foreach (['pcv3','penta4','mr2'] as $v) {
                                                            if ($ibl->$v) $riwayatIbl[] = strtoupper($v) . ' (' . date('d/m/Y', strtotime($ibl->$v)) . ')';
                                                        }
                                                    @endphp
                                                    {{ implode(', ', $riwayatIbl) ?: '-' }}
                                                </td>
                                                <td>
                                                    @if ($ibl->lengkap == '1')
                                                        <span class="badge bg-success">Lengkap</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">Belum</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('ibl-imun.edit', $ibl->id) }}" title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- ===== TAB BIAS ===== --}}
                            <div class="tab-pane fade {{ $tab == 'bias' ? 'show active' : '' }}"
                                 id="pane-bias" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="tableBIAS" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Sekolah</th>
                                                <th>Nama Siswa</th>
                                                <th>NIK</th>
                                                <th>Kelas</th>
                                                <th>Jenkel</th>
                                                <th>Riwayat Vaksin</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bias as $index => $b)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td style="white-space:normal">{{ $b->school_name }}</td>
                                                <td style="white-space:normal">{{ $b->name_student }}</td>
                                                <td>{{ $b->nik }}</td>
                                                <td>{{ $b->class }}</td>
                                                <td>{{ $b->gender }}</td>
                                                <td style="white-space:normal; font-size:0.8rem;">
                                                    @php
                                                        $riwayatBias = [];
                                                        foreach (['dt','mr','td1','td2pa','td2pi','hpv1','hpv2'] as $v) {
                                                            if ($b->$v) $riwayatBias[] = strtoupper($v) . ' (' . date('d/m/Y', strtotime($b->$v)) . ')';
                                                        }
                                                    @endphp
                                                    {{ implode(', ', $riwayatBias) ?: '-' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('bias.edit', $b->id) }}" title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- ===== TAB WUS ===== --}}
                            <div class="tab-pane fade {{ $tab == 'wus' ? 'show active' : '' }}"
                                 id="pane-wus" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="tableWUS" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Desa</th>
                                                <th>Nama WUS</th>
                                                <th>NIK</th>
                                                <th>Tgl Lahir</th>
                                                <th>Riwayat TT</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($wus as $index => $w)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td style="white-space:normal">{{ $w->village_name }}</td>
                                                <td style="white-space:normal">{{ $w->name_wus }}</td>
                                                <td>{{ $w->nik }}</td>
                                                <td>{{ $w->date_birth ? date('d/m/Y', strtotime($w->date_birth)) : '-' }}</td>
                                                <td style="white-space:normal; font-size:0.8rem;">
                                                    @php
                                                        $riwayatWus = [];
                                                        foreach (['t1','t2','t3','t4','t5'] as $v) {
                                                            if ($w->$v) $riwayatWus[] = strtoupper($v) . ' (' . date('d/m/Y', strtotime($w->$v)) . ')';
                                                        }
                                                    @endphp
                                                    {{ implode(', ', $riwayatWus) ?: '-' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('tt-imun.edit', $w->id) }}" title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- ===== TAB BUMIL ===== --}}
                            <div class="tab-pane fade {{ $tab == 'bumil' ? 'show active' : '' }}"
                                 id="pane-bumil" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="tableBumil" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Desa</th>
                                                <th>Nama Bumil</th>
                                                <th>NIK</th>
                                                <th>Tgl Lahir</th>
                                                <th>Riwayat TT</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bumil as $index => $bl)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td style="white-space:normal">{{ $bl->village_name }}</td>
                                                <td style="white-space:normal">{{ $bl->name_wus }}</td>
                                                <td>{{ $bl->nik }}</td>
                                                <td>{{ $bl->date_birth ? date('d/m/Y', strtotime($bl->date_birth)) : '-' }}</td>
                                                <td style="white-space:normal; font-size:0.8rem;">
                                                    @php
                                                        $riwayatBumil = [];
                                                        foreach (['t1','t2','t3','t4','t5'] as $v) {
                                                            if ($bl->$v) $riwayatBumil[] = strtoupper($v) . ' (' . date('d/m/Y', strtotime($bl->$v)) . ')';
                                                        }
                                                    @endphp
                                                    {{ implode(', ', $riwayatBumil) ?: '-' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('tt-imun.edit', $bl->id) }}" title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>{{-- end tab-content --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script>
        $(function () {
            var dtOptions = {
                autoWidth: false,
                language: {
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    zeroRecords: 'Data tidak ditemukan',
                    paginate: { previous: 'Prev', next: 'Next' }
                }
            };

            $('#tableIDL').DataTable(dtOptions);
            $('#tableIBL').DataTable(dtOptions);
            $('#tableBIAS').DataTable(dtOptions);
            $('#tableWUS').DataTable(dtOptions);
            $('#tableBumil').DataTable(dtOptions);

            // Adjust columns when tab becomes visible
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
                // Update hidden input so filter form keeps active tab
                document.getElementById('activeTabInput').value = e.target.getAttribute('data-tab');
                // Re-init feather icons
                if (typeof feather !== 'undefined') feather.replace();
            });
        });
    </script>
@endpush
