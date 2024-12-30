<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
    <meta name="author" content="NobleUI">
    <meta name="keywords"
        content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>Lyan-Imun</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- core:css -->
    <link rel="stylesheet" href="{{ asset('vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('css/demo1/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @stack('style')

</head>

<body>
    <div class="main-wrapper">
        @include('components.sidebar')
        <div class="page-wrapper">
            @include('components.header')
            @yield('main')
            @include('components.footer')
        </div>
    </div>
    <!-- core:js -->
    <script src="{{ asset('vendors/core/core.js') }}"></script>
    <!-- endinject -->

    <!-- Plugin js for this page -->
    <script src="{{ asset('vendors/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('vendors/apexcharts/apexcharts.min.js') }}"></script>
    <!-- End plugin js for this page -->

    <!-- inject:js -->
    <script src="{{ asset('vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <!-- endinject -->

    @stack('scripts')

    <!-- Custom js for this page -->
    <script src="{{ asset('js/dashboard-light.js') }}"></script>
    <!-- End custom js for this page -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const alertElement = document.querySelector('.alert');
            const progressBar = alertElement.querySelector('.progress-bar');
            const alertDuration = 2000;

            if (alertElement && progressBar) {
                let startTime = Date.now();

                function updateProgressBar() {
                    const elapsedTime = Date.now() - startTime;
                    const progress = Math.max(0, 100 - (elapsedTime / alertDuration) * 100);
                    progressBar.style.width = progress + '%';

                    if (progress > 0) {
                        requestAnimationFrame(updateProgressBar);
                    }
                }

                updateProgressBar();

                window.setTimeout(() => {
                    alertElement.classList.add('fade');
                    setTimeout(() => alertElement.remove(), 500);
                }, alertDuration);
            }
        });
    </script>

</body>

</html>
