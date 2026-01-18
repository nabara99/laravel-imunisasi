@if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        <i class="link-icon" data-feather="smile"></i> {{ $message }}
        <div class="progress-bar" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 5px; background-color: rgba(124, 159, 235, 0.5);"></div>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger" role="alert">
        <i class="link-icon" data-feather="alert-circle"></i> {{ $message }}
        <div class="progress-bar" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 5px; background-color: rgba(220, 53, 69, 0.5);"></div>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <i class="link-icon" data-feather="alert-circle"></i>
        <strong>Terjadi kesalahan validasi:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <div class="progress-bar" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 5px; background-color: rgba(220, 53, 69, 0.5);"></div>
    </div>
@endif

