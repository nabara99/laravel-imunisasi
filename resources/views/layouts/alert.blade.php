@if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        <i class="link-icon" data-feather="smile"></i> {{ $message }}
        <div class="progress-bar" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 5px; background-color: rgba(124, 159, 235, 0.5);"></div>
    </div>
@endif

