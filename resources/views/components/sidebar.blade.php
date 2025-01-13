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
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">Master Data</li>
            <li class="nav-item {{str_contains(Route::currentRouteName(), 'village') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('village.index')}}">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Desa</span>
                </a>
            </li>
            <li class="nav-item {{str_contains(Route::currentRouteName(), 'school') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('school.index')}}">
                    <i class="link-icon" data-feather="map"></i>
                    <span class="link-title">Sekolah</span>
                </a>
            </li>
            <li class="nav-item {{str_contains(Route::currentRouteName(), 'idl-target') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('idl-target.index')}}">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Sasaran Anak IDL</span>
                </a>
            </li>
            <li class="nav-item {{str_contains(Route::currentRouteName(), 'ibl-target') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('ibl-target.index')}}">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">Sasaran Anak IBL</span>
                </a>
            </li>
            <li class="nav-item {{str_contains(Route::currentRouteName(), 'mother-target') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('mother-target.index')}}">
                    <i class="link-icon" data-feather="slack"></i>
                    <span class="link-title">Sasaran WUS</span>
                </a>
            </li>
            <li class="nav-item {{str_contains(Route::currentRouteName(), 'student-target') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('student-target.index')}}">
                    <i class="link-icon" data-feather="sun"></i>
                    <span class="link-title">Sasaran Anak Sekolah</span>
                </a>
            </li>
            <li class="nav-item nav-category">Basis Data</li>
            <li class="nav-item {{str_contains(Route::currentRouteName(), 'children') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('children.index')}}">
                    <i class="link-icon" data-feather="user-check"></i>
                    <span class="link-title">Anak</span>
                </a>
            </li>
            <li class="nav-item {{str_contains(Route::currentRouteName(), 'child-sch') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('child-sch.index')}}">
                    <i class="link-icon" data-feather="user-plus"></i>
                    <span class="link-title">Anak Sekolah</span>
                </a>
            </li>
            <li class="nav-item {{str_contains(Route::currentRouteName(), 'wus') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('wus.index')}}">
                    <i class="link-icon" data-feather="cloud-rain"></i>
                    <span class="link-title">WUS</span>
                </a>
            </li>
            <li class="nav-item nav-category">Input Data</li>
            <li class="nav-item {{str_contains(Route::currentRouteName(), 'idl-imun') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('idl-imun.index')}}">
                    <i class="link-icon" data-feather="droplet"></i>
                    <span class="link-title">IDL</span>
                </a>
            </li>
            <li class="nav-item {{str_contains(Route::currentRouteName(), 'ibl-imun') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('ibl-imun.index')}}">
                    <i class="link-icon" data-feather="aperture"></i>
                    <span class="link-title">IBL</span>
                </a>
            </li>
            <li class="nav-item {{str_contains(Route::currentRouteName(), 'tt-imun') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('tt-imun.index')}}">
                    <i class="link-icon" data-feather="umbrella"></i>
                    <span class="link-title">TT WUS</span>
                </a>
            </li>
            <li class="nav-item {{str_contains(Route::currentRouteName(), 'bias') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('bias.index')}}">
                    <i class="link-icon" data-feather="smile"></i>
                    <span class="link-title">BIAS</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
