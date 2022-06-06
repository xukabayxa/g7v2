<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="#" class="d-block" style="color: #fd7e14">Xin chào: {{ App\Model\Common\User::find(Auth::user()->id)->name }}</a>
        </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('dash') }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Trang chủ
                    </p>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('Booking.index') ? 'active' : '' }}">
                <a href="{{ route('Booking.index') }}" class="nav-link {{ Request::routeIs('Booking.index') ? 'active' : '' }}">
                    <i class="nav-icon far fa-calendar-check"></i>
                    <p>
                        Lịch đặt trước
                    </p>
                </a>
            </li>
            <li class="nav-item has-treeview {{ request()->is('g7/warehouse_reports*') || request()->is('g7/funds/business-reports*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('g7/warehouse_reports*') || request()->is('g7/funds/business-reports*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>
                        Báo cáo thống kê
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('WarehouseReport.stockReport') }}" class="nav-link {{ Request::routeIs('WarehouseReport.stockReport') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo tồn kho</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('WarehouseReport.saleReport') }}" class="nav-link {{ Request::routeIs('WarehouseReport.saleReport') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo bán hàng</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('Report.promoReport') }}" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo khuyến mại</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('Report.promoProductReport') }}" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo khuyến mại tặng hàng</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('Report.customerSaleReport') }}" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo bán hàng theo khách</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('WarehouseReport.fundReport') }}" class="nav-link {{ Request::routeIs('WarehouseReport.fundReport') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Sổ quỹ</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('BusinessReports.index') }}" class="nav-link {{ Request::routeIs('BusinessReports.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo kinh doanh</p>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>