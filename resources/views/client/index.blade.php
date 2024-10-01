<!DOCTYPE html>
<html lang="en">

@include('client.includes.head')

<body>
    @include('client.includes.header')

    {{-- ------------------------------------------------ --}}

    {{-- @include('client.includes.main') --}}
    @yield('main')

    {{-- ------------------------------------------------ --}}

    <!-- Footer Section Start -->
    @include('client.includes.footer')
    <!-- Footer Section End -->

    @include('client.includes.index-modal')


    @include('client.includes.script')


</body>

</html>
