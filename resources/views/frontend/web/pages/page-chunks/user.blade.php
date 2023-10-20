<li class="nav-item navbar-dropdown dropdown-user dropdown">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
            <p>Profile</p>
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <span class="dropdown-item" >
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <span class="fw-semibold d-block">Statu:</span>
                        <small class="text-muted">{{ session()->get('path') }}</small>
                    </div>
                </div>
            </span>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('account.details') }}">
                <i class="bx bx-cog me-2"></i>
                <span class="align-middle">Account Details</span>
            </a>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('log.out') }}">
                <i class="bx bx-power-off me-2"></i>
                <span class="align-middle">Log Out</span>
            </a>
        </li>
    </ul>
</li>
