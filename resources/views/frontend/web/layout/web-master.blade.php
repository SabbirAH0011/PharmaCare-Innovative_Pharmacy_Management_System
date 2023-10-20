<!DOCTYPE html>
<html lang="en">
    @include('frontend.web.components.head')
 <body>
    @include('frontend.web.pages.page-chunks.location')
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        @include('frontend.web.components.sidemenu')
        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            @include('frontend.web.components.navbar')
            <!-- / Navbar -->
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">

                <!-- Content -->
                @yield('content')
                <!-- / Content -->
                </div>
            </div>
            <!-- / Content wrapper -->
        </div>
        <!-- End Layout container -->
    </div>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    <!-- End Layout wrapper -->
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

 </body>
</html>
