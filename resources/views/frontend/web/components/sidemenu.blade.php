  @php
  $feth_category = DB::table('drug_categories')->get();
  @endphp
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

            <li class="menu-item {{ 'cart' === request()->path() ? 'active': '' }}">
                <a href="{{ route('view.cart') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-cart'></i>
                    <div data-i18n="Analytics">Cart <span class="badge bg-primary" id="total_cart_item"></span></div>
                </a>
            </li>

            <!-- Layouts -->

            <li class="menu-header small text-uppercase">
                <i class='menu-icon tf-icons bx bxs-capsule'></i>
                <span
                    class="menu-header-text {{ 'product/list' === request()->path() ? 'btn btn-primary btn-sm': '' }}">Categories</span>
            </li>
            @forelse($feth_category as $cagetgories)
            <li class="menu-item">
                <a href="{{ route('product.list',['category' => $cagetgories->category]) }}" class="menu-link ">
                    <span class="menu-icon tf-icons">💊</span>
                    <div data-i18n="Account Settings">{{ $cagetgories->category}}</div>
                </a>
            </li>
            @empty
            <li class="menu-item {{ 'eda' === request()->path() ? 'active': '' }}">
                <span class="menu-link ">
                    <div data-i18n="Account Settings">Not available</div>
                </span>
            </li>
            @endforelse

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Links</span>
            </li>
            <li class="menu-item {{ 'eda' === request()->path() ? 'active': '' }}">
                <a href="{{ route('first.aid_doctor_assistance') }}" class="menu-link ">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Account Settings">First Aid doctor's assistance</div>
                </a>
            </li>
            <li class="menu-item {{ 'blood-bank' === request()->path() ? 'active': '' }}">
                <a href="{{ route('blood-bank') }}" class="menu-link ">
                    <i class='menu-icon tf-icons  bx bx-donate-blood'></i>
                    <div data-i18n="Account Settings">Blood Bank</div>
                </a>
            </li>
            <li class="menu-item {{ 'find-doctor' === request()->path() ? 'active': '' }}">
                <a href="{{ route('find-doctor') }}" class="menu-link ">
                    <i class='menu-icon tf-icons  bx bx-donate-blood'></i>
                    <div data-i18n="Account Settings">Find Doctors</div>
                </a>
            </li>
        </ul>
    </aside>
    <!-- / Menu -->
<script>
    $(document).ready(function () {
        function CartCount(){
             $.ajax({
                type: "GET",
                url: "{{ route('cart.count') }}",
                success: function (response) {
                   if(parseInt(response.total_count)  > 0){
                     $('#total_cart_item').removeClass('bg-primary');
                     $('#total_cart_item').addClass('bg-success');
                   }else{
                    $('#total_cart_item').removeClass('bg-success');
                    $('#total_cart_item').addClass('bg-primary');
                   }
                   $('#total_cart_item').html(response.total_count);
                }
            });
        }
        CartCount();
    });
</script>
