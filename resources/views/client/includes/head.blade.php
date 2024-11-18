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

    <link rel="stylesheet" href="{{ asset('theme/client/css/vendor/fontawesome.min.cs') }}">
    <link rel="stylesheet" href="{{ asset('theme/client/css/vendor/pe-icon-7-stroke.min.cs') }}">


    <!-- Plugins CSS (All Plugins Files) -->

    <link rel="stylesheet" href="{{ asset('theme/client/css/plugins/lightgallery.min.css ') }}" />

    <!-- Thêm SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.css">

    @yield('style')
    <style>
        .swal-title {
            font-size: 1.5rem;
            /* Điều chỉnh kích cỡ chữ */
        }

        .size-buttons {
            display: flex;

            flex-wrap: wrap;
            gap: 8px;
            padding: 8px 0;
        }

        .size-buttons li {
            list-style: none;
            margin: 0;
        }

        .size-btn {
            display: inline-block;
            padding: 0 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            flex: 1 1 auto;
        }

        .size-btn:hover {
            background-color: #f0f0f0;
        }

        .size-btn.active {
            background-color: #3498db;
            color: white;
            border-color: #2980b9;
        }

        .color-buttons {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 10px;
        }

        .color-buttons li {
            display: inline-block;
        }

        .color-btn {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            margin-left:7px ;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.3s;
        }

        .color-btn.active {
            width: 22px;
            height: 22px;
            border-color: #040f1a;
            background-color: #ffffff;
            transform: scale(1.1);
            transition: all 0.3s ease-in-out;
        }

        .color-btn:hover {
            border-color: #040f1a;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
            background-color: #f8f9fa;
        }



        .price {
            color: #333;
            font-weight: bold;
        }

        .show-price {
            color: #dc3545;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .price span {
            padding: 0 2px;
        }

        .price {
            display: flex;
            align-items: center;
            gap: 6px;
        }
    </style>
    <script>
        var BASE_URL = '{{ config('app.url') }}';
    </script>

</head>
