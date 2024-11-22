<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ config('app.url') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Destry - Fashion eCommerce HTML Template</title>
    <!-- Favicons -->
    <link rel="shortcut icon" href=" {{ asset('theme/client/assets/images/favicon.ico') }}">
    <!-- Vendor CSS (Icon Font) -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/vendor/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/vendor/pe-icon-7-stroke.min.css') }}">
    <!-- Plugins CSS (All Plugins Files) -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/plugins/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/plugins/aos.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/plugins/nice-select.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/plugins/jquery-ui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/plugins/lightgallery.min.css') }}" />
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/style.css') }}" />
    <!-- Vendor CSS (Icon Font) -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/vendor/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/vendor/pe-icon-7-stroke.min.css') }}">
    <!-- Plugins CSS (All Plugins Files) -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/plugins/lightgallery.min.css ') }}" />
    <!-- Thêm SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/css/cssClient.css') }}" />


    @yield('style')

    <script>
        var BASE_URL = '{{ config('app.url') }}';
    </script>

</head>
