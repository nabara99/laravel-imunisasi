<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            Lyan<span>Imun</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{(str_contains(Route::currentRouteName(), 'village') || str_contains(Route::currentRouteName(), 'school') || str_contains(Route::currentRouteName(), 'idl-target') || str_contains(Route::currentRouteName(), 'ibl-target') || str_contains(Route::currentRouteName(), 'mother-target') || str_contains(Route::currentRouteName(), 'student-target')) ? 'active' : ''}}">
                <a class="nav-link" data-bs-toggle="collapse" href="#masterData" role="button" aria-expanded="false" aria-controls="masterData">
                    <i class="link-icon" data-feather="database"></i>
                    <span class="link-title">Master Data</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{(str_contains(Route::currentRouteName(), 'village') || str_contains(Route::currentRouteName(), 'school') || str_contains(Route::currentRouteName(), 'idl-target') || str_contains(Route::currentRouteName(), 'ibl-target') || str_contains(Route::currentRouteName(), 'mother-target') || str_contains(Route::currentRouteName(), 'student-target')) ? 'show' : ''}}" id="masterData">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('village.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'village') ? 'active' : ''}}">Desa</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('school.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'school') ? 'active' : ''}}">Sekolah</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('idl-target.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'idl-target') ? 'active' : ''}}">Sasaran Anak IDL</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('ibl-target.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'ibl-target') ? 'active' : ''}}">Sasaran Anak IBL</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('mother-target.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'mother-target') ? 'active' : ''}}">Sasaran WUS</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('student-target.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'student-target') ? 'active' : ''}}">Sasaran Anak Sekolah</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{(str_contains(Route::currentRouteName(), 'children') || str_contains(Route::currentRouteName(), 'child-sch') || str_contains(Route::currentRouteName(), 'wus')) ? 'active' : ''}}">
                <a class="nav-link" data-bs-toggle="collapse" href="#basisData" role="button" aria-expanded="false" aria-controls="basisData">
                    <i class="link-icon" data-feather="folder"></i>
                    <span class="link-title">Basis Data</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{(str_contains(Route::currentRouteName(), 'children') || str_contains(Route::currentRouteName(), 'child-sch') || str_contains(Route::currentRouteName(), 'wus')) ? 'show' : ''}}" id="basisData">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('children.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'children') ? 'active' : ''}}">Anak</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('child-sch.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'child-sch') ? 'active' : ''}}">Anak Sekolah</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('wus.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'wus') ? 'active' : ''}}">WUS</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{(str_contains(Route::currentRouteName(), 'idl-imun') || str_contains(Route::currentRouteName(), 'ibl-imun') || str_contains(Route::currentRouteName(), 'tt-imun') || str_contains(Route::currentRouteName(), 'bias')) ? 'active' : ''}}">
                <a class="nav-link" data-bs-toggle="collapse" href="#inputData" role="button" aria-expanded="false" aria-controls="inputData">
                    <i class="link-icon" data-feather="edit"></i>
                    <span class="link-title">Input Imunisasi</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{(str_contains(Route::currentRouteName(), 'idl-imun') || str_contains(Route::currentRouteName(), 'ibl-imun') || str_contains(Route::currentRouteName(), 'tt-imun') || str_contains(Route::currentRouteName(), 'bias')) ? 'show' : ''}}" id="inputData">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('idl-imun.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'idl-imun') ? 'active' : ''}}">IDL</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('ibl-imun.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'ibl-imun') ? 'active' : ''}}">IBL</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tt-imun.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'tt-imun') ? 'active' : ''}}">TT WUS</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('bias.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'bias') ? 'active' : ''}}">BIAS</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{(str_contains(Route::currentRouteName(), 'vaccine-category') || Route::currentRouteName() == 'vaccines.index' || str_contains(Route::currentRouteName(), 'vaccine-in') || str_contains(Route::currentRouteName(), 'vaccine-out')) ? 'active' : ''}}">
                <a class="nav-link" data-bs-toggle="collapse" href="#inventoriVaksin" role="button" aria-expanded="false" aria-controls="inventoriVaksin">
                    <i class="link-icon" data-feather="package"></i>
                    <span class="link-title">Inventori Vaksin</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{(str_contains(Route::currentRouteName(), 'vaccine-category') || Route::currentRouteName() == 'vaccines.index' || str_contains(Route::currentRouteName(), 'vaccine-in') || str_contains(Route::currentRouteName(), 'vaccine-out')) ? 'show' : ''}}" id="inventoriVaksin">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('vaccine-category.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'vaccine-category') ? 'active' : ''}}">Kategori Vaksin</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('vaccines.index')}}" class="nav-link {{Route::currentRouteName() == 'vaccines.index' ? 'active' : ''}}">Daftar Vaksin</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('vaccine-in.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'vaccine-in') ? 'active' : ''}}">Vaksin Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('vaccine-out.index')}}" class="nav-link {{str_contains(Route::currentRouteName(), 'vaccine-out') ? 'active' : ''}}">Vaksin Keluar</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{(Route::currentRouteName() == 'report.index' || Route::currentRouteName() == 'report-idl' || Route::currentRouteName() == 'report-idl-excel' || Route::currentRouteName() == 'report-ibl' || Route::currentRouteName() == 'report-ibl-excel' || Route::currentRouteName() == 'report-tt' || Route::currentRouteName() == 'report-bias') ? 'active' : ''}}" id="menu-rekapitulasi">
                <a class="nav-link" href="{{route('report.index')}}">
                    <i class="link-icon" data-feather="printer"></i>
                    <span class="link-title">Laporan Imunisasi</span>
                </a>
            </li>
            <li class="nav-item {{(Route::currentRouteName() == 'vaccine-report.index' || Route::currentRouteName() == 'vaccine-report.in' || Route::currentRouteName() == 'vaccine-report.out' || Route::currentRouteName() == 'vaccine-report.stock') ? 'active' : ''}}" id="menu-vaccine-report">
                <a class="nav-link" href="{{route('vaccine-report.index')}}">
                    <i class="link-icon" data-feather="archive"></i>
                    <span class="link-title">Laporan Inventori Vaksin</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
<script>
    // Fix untuk mencegah double active karena indexOf di template.js
    (function() {
        var currentRoute = '{{ Route::currentRouteName() }}';
        var reportRoutes = ['report.index', 'report-idl', 'report-idl-excel', 'report-ibl', 'report-ibl-excel', 'report-tt', 'report-bias'];
        var vaccineReportRoutes = ['vaccine-report.index', 'vaccine-report.in', 'vaccine-report.out', 'vaccine-report.stock'];

        function fixActiveState() {
            // Jika sedang di halaman report (bukan vaccine-report), hapus active dari vaccine-report menu
            if (reportRoutes.includes(currentRoute)) {
                var vaccineReportMenu = document.getElementById('menu-vaccine-report');
                var vaccineReportLink = document.querySelector('#menu-vaccine-report .nav-link');
                if (vaccineReportMenu) vaccineReportMenu.classList.remove('active');
                if (vaccineReportLink) vaccineReportLink.classList.remove('active');
            }

            // Jika sedang di halaman vaccine-report, hapus active dari report menu
            if (vaccineReportRoutes.includes(currentRoute)) {
                var rekapMenu = document.getElementById('menu-rekapitulasi');
                var rekapLink = document.querySelector('#menu-rekapitulasi .nav-link');
                if (rekapMenu) rekapMenu.classList.remove('active');
                if (rekapLink) rekapLink.classList.remove('active');
            }
        }

        // Jalankan segera
        fixActiveState();

        // Jalankan setelah DOMContentLoaded
        document.addEventListener('DOMContentLoaded', fixActiveState);

        // Jalankan setelah window load (untuk memastikan template.js sudah selesai)
        window.addEventListener('load', function() {
            setTimeout(fixActiveState, 100);
            setTimeout(fixActiveState, 300);
            setTimeout(fixActiveState, 500);
        });
    })();
</script>
