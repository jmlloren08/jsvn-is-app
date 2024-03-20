<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>
            <!-- Navigation -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">NAVIGATION</li>
                <li>
                    <a href="{{ route('admin.transaction') }}" class=" waves-effect">
                        <i class="ri-money-dollar-box-line"></i>
                        <span>Transaction</span>
                    </a>
                </li>
            </ul>
            <!-- End of navigation -->
            <!-- Management -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">MANAGEMENT</li>
                <li>
                    <a href="{{ route('admin.company') }}" class=" waves-effect">
                        <i class="ri-building-2-line"></i>
                        <span>Company</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.outlet') }}" class=" waves-effect">
                        <i class="ri-community-line"></i>
                        <span>Outlet</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products') }}" class=" waves-effect">
                        <i class="ri-folder-add-line"></i>
                        <span>Products</span>
                    </a>
                </li>
            </ul>
            <!-- End of management -->
            <!-- Admin Panel -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">ADMIN PANEL</li>
                <li>
                    <a href="{{ route('admin.users') }}" class=" waves-effect">
                        <i class="ri-account-box-line"></i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>
            <!-- End of admin panel -->
        </div>
        <!-- Sidebar -->
    </div>
</div>