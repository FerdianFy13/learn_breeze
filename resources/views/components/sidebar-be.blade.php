<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="text-nowrap logo-img">
                <img src="{{ asset('dist/images/logos/dark-logo.svg') }}" width="180" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                @role('Administrator|Super Administrator|Contributor|Member|Super Administrator|Partner|Agency')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/dashboard" aria-expanded="false">
                            <span>
                                <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                @endrole
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Post</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('product*') ? 'sidebar-link active' : '' }}" href="/product"
                        aria-expanded="false">
                        <span>
                            <i class="ti ti-shopping-cart"></i>
                        </span>
                        <span class="hide-menu">Product</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('category*') ? 'sidebar-link active' : '' }}" href="/category"
                        aria-expanded="false">
                        <span>
                            <i class="ti ti-topology-star-3"></i>
                        </span>
                        <span class="hide-menu">Category</span>
                    </a>
                </li>
                @role('Administrator|Super Administrator')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Management</span>
                    </li>
                @endrole
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('permission*') ? 'sidebar-link active' : '' }}"
                        href="/permission" aria-expanded="false">
                        <span>
                            <i class="ti ti-shield-check"></i>
                        </span>
                        <span class="hide-menu">Permission</span>
                    </a>
                </li> --}}
                @role('Super Administrator')
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ Request::is('role*') ? 'sidebar-link active' : '' }}" href="/role"
                            aria-expanded="false">
                            <span>
                                <i class="ti ti-wind"></i>
                            </span>
                            <span class="hide-menu">Role</span>
                        </a>
                    </li>
                @endrole
                @role('Administrator|Super Administrator')
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ Request::is('user*') ? 'sidebar-link active' : '' }}" href="/user"
                            aria-expanded="false">
                            <span>
                                <i class="ti ti-users"></i>
                            </span>
                            <span class="hide-menu">User</span>
                        </a>
                    </li>
                @endrole
            </ul>
        </nav>
    </div>
</aside>
