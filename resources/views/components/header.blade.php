<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <ul class="navbar-nav">
            @if (request()->routeIs('dashboard'))
                <li class="nav-item d-flex align-items-center me-3">
                    <form id="dashboard-year-form" action="{{ route('dashboard') }}" method="GET" class="d-flex align-items-center gap-2">
                        <label for="dashboard-year" class="mb-0">Tahun</label>
                        <select id="dashboard-year" name="year" class="form-select form-select-sm" style="width: 90px;">
                            @foreach ($dashboardYears as $availableYear)
                                <option value="{{ $availableYear }}" @selected($dashboardYear === $availableYear)>{{ $availableYear }}</option>
                            @endforeach
                        </select>
                        <noscript><button type="submit" class="btn btn-sm btn-primary">Terapkan</button></noscript>
                    </form>
                </li>
            @endif
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="wd-30 ht-30 rounded-circle" src="{{ asset('images/working.png') }}" alt="profile">
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        <div class="mb-3">
                            <img class="wd-80 ht-80 rounded-circle" src="{{ asset('images/working.png') }}"
                                alt="">
                        </div>
                        <div class="text-center">
                            <p class="tx-16 fw-bolder">{{ auth()->user()->name }}</p>
                            <p class="tx-12 text-muted">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <ul class="list-unstyled p-1">
                        <li class="dropdown-item py-2">
                            <a href="#" class="text-body ms-0" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                                <i class="me-2 icon-md" data-feather="log-out"></i>
                                <span>Log Out</span>
                            </a>
                            <form id="logout-form" action="{{route('logout')}}" method="POST">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
