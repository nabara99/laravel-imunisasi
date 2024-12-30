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
            <li class="nav-item {{str_contains(Route::currentRouteName(), 'children') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('children.index')}}">
                    <i class="link-icon" data-feather="user-check"></i>
                    <span class="link-title">Anak</span>
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
        </ul>
    </div>
</nav>
