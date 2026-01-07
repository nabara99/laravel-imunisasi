@extends('layouts.app')

@section('main')
    <div class="main-content">
        <div class="page-content">
            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                <div>
                    <h4 class="mb-3 mb-md-0">Dashboard Sistem Imunisasi</h4>
                    <p class="text-muted">Monitoring Capaian Program Imunisasi</p>
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0" onclick="window.print()">
                        <i class="btn-icon-prepend" data-feather="printer"></i>
                        Print
                    </button>
                    <a href="{{ route('report.index') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                        <i class="btn-icon-prepend" data-feather="file-text"></i>
                        Lihat Laporan
                    </a>
                </div>
            </div>

            <!-- Statistics Cards Row -->
            <div class="row">
                <!-- 1. IDL Card -->
                <div class="col-12 col-xl-6 col-xxl-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline mb-2">
                                <h6 class="card-title mb-0">Imunisasi Dasar Lengkap (IDL)</h6>
                                <div class="dropdown mb-2">
                                    <a href="{{ route('idl-imun.index') }}" class="text-muted" title="Lihat Detail">
                                        <i data-feather="external-link" class="icon-sm"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="mb-2">
                                        <span class="text-primary">{{ number_format($idlAchievement) }}</span>
                                        <span class="text-muted" style="font-size: 1rem;">/ {{ number_format($idlTargetTotal) }}</span>
                                    </h3>
                                    <div class="d-flex align-items-baseline mb-3">
                                        <p class="text-muted mb-0 me-2">Target Anak 0-24 Bulan</p>
                                        <p class="mb-0 {{ $idlPercentage >= 90 ? 'text-success' : ($idlPercentage >= 75 ? 'text-warning' : 'text-danger') }}">
                                            <span class="fw-bold">{{ $idlPercentage }}%</span>
                                            <i data-feather="{{ $idlPercentage >= 90 ? 'trending-up' : 'trending-down' }}" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="progress mb-2" style="height: 10px;">
                                        <div class="progress-bar {{ $idlPercentage >= 90 ? 'bg-success' : ($idlPercentage >= 75 ? 'bg-warning' : 'bg-danger') }}"
                                             role="progressbar"
                                             style="width: {{ min($idlPercentage, 100) }}%"
                                             aria-valuenow="{{ $idlPercentage }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>

                                    <p class="text-muted tx-12 mb-0">
                                        <i data-feather="info" class="icon-sm me-1"></i>
                                        17 Vaksin: HB0, BCG, Polio, Penta, PCV, Rota, IPV, MR
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. IBL Card -->
                <div class="col-12 col-xl-6 col-xxl-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline mb-2">
                                <h6 class="card-title mb-0">Imunisasi Baduta Lengkap (IBL)</h6>
                                <div class="dropdown mb-2">
                                    <a href="{{ route('ibl-imun.index') }}" class="text-muted" title="Lihat Detail">
                                        <i data-feather="external-link" class="icon-sm"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="mb-2">
                                        <span class="text-info">{{ number_format($iblAchievement) }}</span>
                                        <span class="text-muted" style="font-size: 1rem;">/ {{ number_format($iblTargetTotal) }}</span>
                                    </h3>
                                    <div class="d-flex align-items-baseline mb-3">
                                        <p class="text-muted mb-0 me-2">Target Anak 12-72 Bulan</p>
                                        <p class="mb-0 {{ $iblPercentage >= 90 ? 'text-success' : ($iblPercentage >= 75 ? 'text-warning' : 'text-danger') }}">
                                            <span class="fw-bold">{{ $iblPercentage }}%</span>
                                            <i data-feather="{{ $iblPercentage >= 90 ? 'trending-up' : 'trending-down' }}" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="progress mb-2" style="height: 10px;">
                                        <div class="progress-bar {{ $iblPercentage >= 90 ? 'bg-success' : ($iblPercentage >= 75 ? 'bg-warning' : 'bg-danger') }}"
                                             role="progressbar"
                                             style="width: {{ min($iblPercentage, 100) }}%"
                                             aria-valuenow="{{ $iblPercentage }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>

                                    <p class="text-muted tx-12 mb-0">
                                        <i data-feather="info" class="icon-sm me-1"></i>
                                        3 Vaksin Booster: PCV3, Penta4, MR2
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. WUS/TT Card -->
                <div class="col-12 col-xl-6 col-xxl-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline mb-2">
                                <h6 class="card-title mb-0">Tetanus Toxoid (TT) WUS</h6>
                                <div class="dropdown mb-2">
                                    <a href="{{ route('tt-imun.index') }}" class="text-muted" title="Lihat Detail">
                                        <i data-feather="external-link" class="icon-sm"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="mb-2">
                                        <span class="text-warning">{{ number_format($ttAchievement) }}</span>
                                        <span class="text-muted" style="font-size: 1rem;">/ {{ number_format($wusTargetTotal) }}</span>
                                    </h3>
                                    <div class="d-flex align-items-baseline mb-3">
                                        <p class="text-muted mb-0 me-2">Target Wanita Usia Subur</p>
                                        <p class="mb-0 {{ $ttPercentage >= 90 ? 'text-success' : ($ttPercentage >= 75 ? 'text-warning' : 'text-danger') }}">
                                            <span class="fw-bold">{{ $ttPercentage }}%</span>
                                            <i data-feather="{{ $ttPercentage >= 90 ? 'trending-up' : 'trending-down' }}" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="progress mb-2" style="height: 10px;">
                                        <div class="progress-bar {{ $ttPercentage >= 90 ? 'bg-success' : ($ttPercentage >= 75 ? 'bg-warning' : 'bg-danger') }}"
                                             role="progressbar"
                                             style="width: {{ min($ttPercentage, 100) }}%"
                                             aria-valuenow="{{ $ttPercentage }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>

                                    <p class="text-muted tx-12 mb-0">
                                        <i data-feather="info" class="icon-sm me-1"></i>
                                        5 Dosis TT dengan Tracking Status Hamil
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. BIAS Card -->
                <div class="col-12 col-xl-6 col-xxl-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline mb-2">
                                <h6 class="card-title mb-0">BIAS Anak Sekolah</h6>
                                <div class="dropdown mb-2">
                                    <a href="{{ route('bias.index') }}" class="text-muted" title="Lihat Detail">
                                        <i data-feather="external-link" class="icon-sm"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="mb-2">
                                        <span class="text-success">{{ number_format($biasAchievement) }}</span>
                                        <span class="text-muted" style="font-size: 1rem;">/ {{ number_format($biasTargetTotal) }}</span>
                                    </h3>
                                    <div class="d-flex align-items-baseline mb-3">
                                        <p class="text-muted mb-0 me-2">Target Anak Sekolah</p>
                                        <p class="mb-0 {{ $biasPercentage >= 90 ? 'text-success' : ($biasPercentage >= 75 ? 'text-warning' : 'text-danger') }}">
                                            <span class="fw-bold">{{ $biasPercentage }}%</span>
                                            <i data-feather="{{ $biasPercentage >= 90 ? 'trending-up' : 'trending-down' }}" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="progress mb-2" style="height: 10px;">
                                        <div class="progress-bar {{ $biasPercentage >= 90 ? 'bg-success' : ($biasPercentage >= 75 ? 'bg-warning' : 'bg-danger') }}"
                                             role="progressbar"
                                             style="width: {{ min($biasPercentage, 100) }}%"
                                             aria-valuenow="{{ $biasPercentage }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>

                                    <p class="text-muted tx-12 mb-0">
                                        <i data-feather="info" class="icon-sm me-1"></i>
                                        7 Vaksin: DT, MR, TD, HPV
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Information -->
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline mb-3">
                                <h5 class="card-title mb-0">Ringkasan Capaian Imunisasi</h5>
                                <a href="{{ route('report.index') }}" class="btn btn-sm btn-primary">
                                    <i data-feather="file-text" class="icon-sm me-1"></i>
                                    Unduh Laporan Lengkap
                                </a>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                                        <i data-feather="info" class="me-2"></i>
                                        <div>
                                            <strong>Informasi:</strong> Sistem ini mengelola 4 program imunisasi utama dengan total
                                            <strong>{{ number_format($idlTargetTotal + $iblTargetTotal + $wusTargetTotal + $biasTargetTotal) }}</strong> sasaran
                                            dan telah mencapai <strong>{{ number_format($idlAchievement + $iblAchievement + $ttAchievement + $biasAchievement) }}</strong> capaian imunisasi.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Program</th>
                                            <th class="text-center">Sasaran</th>
                                            <th class="text-center">Capaian</th>
                                            <th class="text-center">Persentase</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong>IDL</strong><br>
                                                <small class="text-muted">Imunisasi Dasar Lengkap</small>
                                            </td>
                                            <td class="text-center">{{ number_format($idlTargetTotal) }}</td>
                                            <td class="text-center">{{ number_format($idlAchievement) }}</td>
                                            <td class="text-center">{{ $idlPercentage }}%</td>
                                            <td class="text-center">
                                                <span class="badge {{ $idlPercentage >= 90 ? 'bg-success' : ($idlPercentage >= 75 ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $idlPercentage >= 90 ? 'Sangat Baik' : ($idlPercentage >= 75 ? 'Baik' : 'Perlu Ditingkatkan') }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>IBL</strong><br>
                                                <small class="text-muted">Imunisasi Baduta Lengkap</small>
                                            </td>
                                            <td class="text-center">{{ number_format($iblTargetTotal) }}</td>
                                            <td class="text-center">{{ number_format($iblAchievement) }}</td>
                                            <td class="text-center">{{ $iblPercentage }}%</td>
                                            <td class="text-center">
                                                <span class="badge {{ $iblPercentage >= 90 ? 'bg-success' : ($iblPercentage >= 75 ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $iblPercentage >= 90 ? 'Sangat Baik' : ($iblPercentage >= 75 ? 'Baik' : 'Perlu Ditingkatkan') }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>TT WUS</strong><br>
                                                <small class="text-muted">Tetanus Toxoid Wanita Usia Subur</small>
                                            </td>
                                            <td class="text-center">{{ number_format($wusTargetTotal) }}</td>
                                            <td class="text-center">{{ number_format($ttAchievement) }}</td>
                                            <td class="text-center">{{ $ttPercentage }}%</td>
                                            <td class="text-center">
                                                <span class="badge {{ $ttPercentage >= 90 ? 'bg-success' : ($ttPercentage >= 75 ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $ttPercentage >= 90 ? 'Sangat Baik' : ($ttPercentage >= 75 ? 'Baik' : 'Perlu Ditingkatkan') }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>BIAS</strong><br>
                                                <small class="text-muted">Bulan Imunisasi Anak Sekolah</small>
                                            </td>
                                            <td class="text-center">{{ number_format($biasTargetTotal) }}</td>
                                            <td class="text-center">{{ number_format($biasAchievement) }}</td>
                                            <td class="text-center">{{ $biasPercentage }}%</td>
                                            <td class="text-center">
                                                <span class="badge {{ $biasPercentage >= 90 ? 'bg-success' : ($biasPercentage >= 75 ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $biasPercentage >= 90 ? 'Sangat Baik' : ($biasPercentage >= 75 ? 'Baik' : 'Perlu Ditingkatkan') }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
