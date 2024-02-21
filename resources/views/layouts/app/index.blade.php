@include('layouts.app.includes.head')

<body data-sidebar="dark">

    <!-- Loader -->
    @include('layouts.app.includes.preloader')

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('layouts.app.includes.header')

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                @include('layouts.app.includes.sidebar')
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    @yield('content')

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('layouts.app.includes.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    {{-- @include('layouts.app.includes.rightbar') --}}
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    @include('layouts.app.includes.plugin')
</body>

<!-- Mirrored from themesbrand.com/skote/layouts/layouts-preloader.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 15 Nov 2022 07:57:46 GMT -->

</html>
