  <!-- Menu -->
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
            <a href="{{ route('welcome') }}" class="app-brand-link">
                <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ env('APP_NAME') }}</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item {{ '/' === request()->path() ? 'active': '' }}">
                <a href="{{ route('welcome') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Home</div>
                </a>
            </li>
            <li class="menu-item {{ 'product/list' === request()->path() ? 'active': '' }}">
                <a href="{{ route('product.list') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-list-ul"></i>
                    <div data-i18n="Analytics">Store</div>
                </a>
            </li>


            @if(session()->get('path') === 'Admin')
            <li class="menu-item {{ 'dashboard/admin' === request()->path() ? 'active': '' }}">
                <a href="{{ route('admin.dashboard') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-dashboard'></i>
                    <div data-i18n="Analytics">Admin dashboard</div>
                </a>
            </li>
            @elseif(session()->get('path') === 'User')
            <li class="menu-item {{ 'dashboard/user' === request()->path() ? 'active': '' }}">
                <a href="{{ route('user.dashboard') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-dashboard'></i>
                    <div data-i18n="Analytics">User dashboard</div>
                </a>
            </li>
            @elseif(session()->get('path') === 'Ambulance-driver')
            <li class="menu-item {{ 'dashboard/ambulance' === request()->path() ? 'active': '' }}">
                <a href="{{ route('ambulance.dashboard') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-dashboard'></i>
                    <div data-i18n="Analytics">Ambulance dashboard</div>
                </a>
            </li>
            @elseif(session()->get('path') === 'Vendor')
            <li class="menu-item {{ 'dashboard/vendor' === request()->path() ? 'active': '' }}">
                <a href="{{ route('vendor.dashboard') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-dashboard'></i>
                    <div data-i18n="Analytics">Vendor</div>
                </a>
            </li>
            @elseif(session()->get('path') === 'Rider')
            <li class="menu-item {{ 'dashboard/rider' === request()->path() ? 'active': '' }}">
                <a href="{{ route('rider.dashboard') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-dashboard'></i>
                    <div data-i18n="Analytics">Rider</div>
                </a>
            </li>
            @endif

            <!-- Layouts -->
            @if(!empty(session()->get('path')))
            @if(session()->get('path') === 'Admin')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Admin Function</span>
            </li>
            <li class="menu-item {{ 'eda' === request()->path() ? 'active': '' }}">
                <a href="#" class="menu-link " data-bs-toggle="modal" data-bs-target="#storeLocation">
                    <i class='menu-icon tf-icons bx bx-location-plus'></i>
                    <div data-i18n="Account Settings">Set Zone</div>
                </a>
            </li>
            <li class="menu-item ">
                <a href="{{ route('first.aid_doctor_assistance') }}" class="menu-link " data-bs-toggle="modal"
                    data-bs-target="#storeCategory">
                    <i class='menu-icon tf-icons bx bxs-capsule'></i>
                    <div data-i18n="Account Settings">Set Medicine Categroy</div>
                </a>
            </li>
            <li
                class="menu-item {{ 'dashboard/admin/function/ambulance/booking/table' === request()->path() ? 'active': '' }}">
                <a href="{{ route('admbulance.booking_table') }}" class="menu-link ">
                    <i class='menu-icon tf-icons bx bxs-ambulance'></i>
                    <div data-i18n="Account Settings">Ambulance</div>
                </a>
            </li>
            <li
                class="menu-item {{ 'dashboard/admin/function/ambulance-driver/rider/registration' === request()->path() ? 'active': '' }}">
                <a href="{{ route('admbulance.driver_rider') }}" class="menu-link ">
                    <i class='menu-icon tf-icons bx bx-user'></i>
                    <div data-i18n="Account Settings">Ambulance driver and rider</div>
                </a>
            </li>
            <li
                class="menu-item {{ 'dashboard/admin/function/blood-donation/registration' === request()->path() ? 'active': '' }}">
                <a href="{{ route('bload.donation_registration') }}" class="menu-link ">
                    <i class='menu-icon tf-icons  bx bx-donate-blood'></i>
                    <div data-i18n="Account Settings">Blood Donation Registration</div>
                </a>
            </li>
            <li class="menu-item {{ 'dashboard/admin/function/doctor/registration' === request()->path() ? 'active': '' }}">
                <a href="{{ route('doctor.registration') }}" class="menu-link ">
                    <i class='menu-icon tf-icons bx bx-plus-medical'></i>
                    <div data-i18n="Account Settings">Doctor Registration</div>
                </a>
            </li>
            @endif
            @endif
        </ul>
    </aside>
    <!-- / Menu -->
