<!doctype html>
<html class="no-js" lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bảng điều khiển</title>
    <meta name="description" content="Admin Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="{{ asset('theme/admin/images/logo.jpg') }}">
    <link rel="shortcut icon" href="{{ asset('theme/admin/images/logo.png') }}">

    <!-- Vendor CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.css">

    <!-- Admin CSS Local -->
    <link rel="stylesheet" href="{{ asset('theme/admin/assets/css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/admin/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/admin/assets/css/lib/chosen/chosen.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/css/cssAdmin.css') }}">

    @yield('style')

    <script>
        var BASE_URL = "{{ url('/') }}";
    </script>
</head>