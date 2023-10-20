@php
$user_email = Session::get('email');
$user_access_token = Session::get('access_token');
$get_user_details = DB::table('user_admin_employee_accesses')
->where([
['email','=',$user_email],
['access_token','=',$user_access_token],
])
->get();
foreach($get_user_details as $user){
$name = $user->name;
$phone = $user->phone;
$path = $user->path;
}
@endphp
<!DOCTYPE html>
<html lang="en">
    @include('frontend.web.components.head')
 <body>
    @include('frontend.web.pages.page-chunks.location')
    @include('frontend.web.pages.page-chunks.medicine-category')
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        @if((request()->path() === 'cart')||(request()->path() === 'checkout'))
        @include('frontend.web.components.sidemenu')
        @else
        @include('frontend.web.components.dashboard.sidemenu')
        @endif
        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            @include('frontend.web.components.dashboard.navbar')
            <!-- / Navbar -->
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    @if(!empty($user_access_token))
                    @if((empty($name))&&(empty($phone)))
                    <div class="alert alert-primary alert-dismissible" role="alert">
                        Please complete your <a href="{{ route('account.details') }}" class="text-success">account details</a> first
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @endif
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

    <!-- Stripe -->
    <!-- <script src="{{ asset('assets/vendor/js/client.js') }}"></script> -->

 </body>
</html>
