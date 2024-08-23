@include('layouts.auth.includes.head')

<body>

    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            @yield('content')
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>

    @include('layouts.auth.includes.plugin')

</body>

</html>
