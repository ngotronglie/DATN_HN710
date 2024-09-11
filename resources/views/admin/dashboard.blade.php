@include('admin.include.head')

<body>
    @include('admin.include.aside')

    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        @include('admin.include.header')

        @yield('content')

        <div class="clearfix"></div>
        @include('admin.include.footer')
        <!-- /#right-panel -->
    </div>




    @include('admin.include.script')
    @yield('script')
</body>

</html>