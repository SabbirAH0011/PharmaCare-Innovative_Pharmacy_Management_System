<div class="sticky-top">
    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme fixed-top"
        id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                    <form action="{{ route('product.list') }}" method="GET">
                        <div class="row ">
                            <div class="col-sm-10">
                                <input type="text" class="form-control border-0 shadow-none search" placeholder="Search..."
                                    name="name" aria-label="Search..." value="{{ request()->name }}" />
                            </div>
                            <div class="col-sm-2 col-form-label" for="basic-default-name">
                                <button type="submit" class="btn btn-success btn-sm"><i
                                        class="bx bx-search fs-4 lh-0"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <li class="nav-item lh-1 me-3">
                    @if(session()->has('user_location'))
                    <a href="{{ route('set.user_location') }}">Current Location: <span class="text-success">{{
                            session()->get('user_location') }}</span></a>
                    @else
                    <a href="{{ route('set.user_location') }}">Current Location: <span class="text-success">Select
                            here</span></a>
                    @endif
                </li>
                <li class="nav-item lh-1 me-3">
                    {{ str_replace(array("/","-",".","_") , "
                    ",strtoupper(request()->route()->getName())) }}
                </li>


                <li class="nav-item lh-1 me-3">
                <!-- User -->
                @if(session()->has('access_token'))
                @if(session()->get('path') === 'Admin')
                <a href="{{ route('admin.dashboard') }}" type="button" class="btn btn-xs btn-outline-primary">Admin</a>
                @elseif(session()->get('path') === 'User')
                <a href="{{ route('user.dashboard') }}" type="button" class="btn btn-xs btn-outline-secondary">User</a>
                @elseif(session()->get('path') === 'Ambulance-driver')
                <a href="{{ route('ambulance.dashboard') }}" type="button"
                    class="btn btn-xs btn-outline-secondary">Ambulance</a>
                @elseif(session()->get('path') === 'Vendor')
                <a href="{{ route('vendor.dashboard') }}" type="button" class="btn btn-xs btn-outline-secondary">Vendor</a>
                @elseif(session()->get('path') === 'Rider')
                <a href="{{ route('rider.dashboard') }}" type="button" class="btn btn-xs btn-outline-secondary">Rider</a>
                @endif
                @else
                <a href="{{ route('get.otp') }}" type="button" class="btn btn-xs btn-primary">Log in</a>
                @endif
                <!--/ User -->
                </li>
            </ul>
        </div>
    </nav>
    <div class="content-wrapper" id="search_suggestion" style="display: none;">
        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Content -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="suggetion_loading"></div>
                            <div class="suggetion_details"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Content -->
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var placeholder_loader = '<div class="d-flex justify-content-center"><div class="spinner-border text-success" role="status"><span class="sr-only"></span></div><span class="ps-2">Loading Plase wait</span></div>';
            var timer;
            $('.search').on('keyup', function (e) {
                e.preventDefault;
                const search_element = $('.search').val();
                if ($('.search').val()) {
                    $('#search_suggestion').css('display', 'block');
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('fetch.searched_product') }}",
                            data: { 'search_element': search_element },
                            dataType: "json",
                            beforeSend: function () {
                                $('.suggetion_loading').html(placeholder_loader);
                                $('.suggetion_details').html('');
                            },
                            success: function (response) {
                                $('.suggetion_loading').html('');
                                if (response.query == 'exists') {
                                    $('.suggetion_details').html('');
                                    $('.suggetion_details').html(response.html);
                                } else if (response.query == 'not exists') {
                                    $('suggetion_details').html('');
                                    $('.suggetion_loading').html('');
                                    $('#search_suggestion').css('display', 'none');
                                }
                            }
                        });
                    }, 500);
                } else {
                    $('.suggetion_loading').html('');
                    $('#search_suggestion').css('display', 'none');
                }
            });
        });
    </script>
</div>
