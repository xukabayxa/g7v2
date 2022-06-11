<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="#" class="d-block">Xin chào: {{ Auth::user()->name }}</a>
            <p style="color: #F58220">{{ App\Model\Common\User::find(Auth::user()->id)->g7Info->name }}</p>
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
            <li class="nav-item has-treeview {{ Request::routeIs('Booking.index') ? 'active' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fab fa-dropbox"></i>
                    <p>
                        Lịch hẹn & Nhắc lịch
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('Booking.index') }}" class="nav-link {{ Request::routeIs('Booking.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Danh sách lịch hẹn</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('CalendarReminder.index') }}" class="nav-link {{ Request::routeIs('CalendarReminder.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>danh sách nhắc lịch</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Bán hàng --}}
            <li class="nav-item has-treeview {{ request()->is('g7/bills*') ? 'menu-open' : '' }}">
                <a href="{{ route('Bill.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-cart-plus"></i>
                    <p>
                        Bán hàng
                    </p>
                </a>
            </li>

            {{-- Quản lý Quỹ--}}
            <li class="nav-item has-treeview {{ request()->is('g7/funds/payment-vouchers') || request()->is('g7/funds/receipt-vouchers')|| request()->is('g7/funds/fund-reports') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-file-invoice-dollar"></i>
                    <p>
                        Quản lý Quỹ
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    {{-- <li class="nav-item">
                        <a href="{{ route('FundAccount.index') }}" class="nav-link {{ Request::routeIs('FundAccount.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Danh mục tài khoản</p>
                        </a>
                    </li> --}}

                    <li class="nav-item">
                        <a href="{{ route('ReceiptVoucher.index') }}" class="nav-link {{ Request::routeIs('ReceiptVoucher.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Phiếu Thu</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('PaymentVoucher.index') }}" class="nav-link {{ Request::routeIs('PaymentVoucher.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Phiếu chi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('ReceiptVoucherType.index') }}" class="nav-link {{ Request::routeIs('ReceiptVoucherType.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Loại Phiếu Thu</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('PaymentVoucherType.index') }}" class="nav-link {{ Request::routeIs('PaymentVoucherType.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Loại Phiếu Chi</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('WarehouseReport.fundReport') }}" class="nav-link {{ Request::routeIs('WarehouseReport.fundReport') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Sổ quỹ</p>
                        </a>
                    </li>


                </ul>
            </li>

            {{-- Quản lý kho --}}
            <li class="nav-item has-treeview {{ request()->is('g7/warehouse_exports*') || request()->is('g7/warehouse-imports*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-cart-plus"></i>
                    <p>
                        Quản lý kho
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('WarehouseExport.index') }}" class="nav-link {{ Request::routeIs('WarehouseExport.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Phiếu xuất kho</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('WareHouseImport.index') }}" class="nav-link {{ Request::routeIs('WareHouseImport.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Phiếu nhập kho</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Tài sản cố định --}}
            <li class="nav-item has-treeview {{ request()->is('g7/g7_fixed_asset*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fab fa-codepen"></i>
                    <p>
                        Tài sản cố định
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('G7FixedAsset.index') }}" class="nav-link {{ Request::routeIs('G7FixedAsset.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Danh sách tài sản</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('G7FixedAssetImport.index') }}" class="nav-link {{ Request::routeIs('G7FixedAssetImport.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Nhập tài sản</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('G7FixedAsset.report') }}" class="nav-link {{ Request::routeIs('G7FixedAsset.report') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview {{ request()->is('common/services') || request()->is('uptek/services*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fab fa-ups"></i>
                    <p>
                        Danh mục
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="{{ route('Car.index') }}" class="nav-link {{ Request::routeIs('Car.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Danh mục xe</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('G7Service.index') }}" class="nav-link {{ Request::routeIs('G7Service.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Dịch vụ</p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="{{ route('Product.index') }}" class="nav-link {{ Request::routeIs('Product.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Hàng hóa</p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('Product.index') }}" class="nav-link {{ Request::routeIs('Product.index') ? 'active' : '' }}">
                                    <i class="far fas  fa-angle-right nav-icon"></i>
                                    <p>Danh sách Hàng hóa</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('G7Product.editPrice') }}" class="nav-link {{ Request::routeIs('G7Product.editPrice') ? 'active' : '' }}">
                                    <i class="far fas  fa-angle-right nav-icon"></i>
                                    <p>Cập nhật giá hàng hóa</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('Customer.index') }}" class="nav-link {{ Request::routeIs('Customer.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Khách hàng</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('Supplier.index') }}" class="nav-link {{ Request::routeIs('Supplier.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Nhà cung cấp</p>
                        </a>
                    </li>

                </ul>
            </li>
            {{--
            <li class="nav-item has-treeview {{ request()->is('common/services') || request()->is('uptek/services*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fab fa-ups"></i>
                    <p>
                        Dịch vụ
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('Service.index') }}" class="nav-link {{ Request::routeIs('Service.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Danh sách dịch vụ</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo</p>
                        </a>
                    </li>
                </ul>
            </li> --}}

            {{-- <li class="nav-item has-treeview {{ request()->is('common/products') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fab fa-dropbox"></i>
                    <p>
                        Hàng hóa
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('Product.index') }}" class="nav-link {{ Request::routeIs('Product.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Danh sách hàng hóa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('G7Product.editPrice') }}" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Cập nhật giá</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo</p>
                        </a>
                    </li>
                </ul>
            </li> --}}

            {{-- <li class="nav-item has-treeview {{ request()->is('common/customers*') || request()->is('customer-groups') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon far fa-handshake"></i>
                    <p>
                        Khách hàng
                        <i class=" fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('Customer.index') }}" class="nav-link {{ Request::routeIs('Customer.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Danh sách khách</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo</p>
                        </a>
                    </li>
                </ul>
            </li> --}}

            {{-- <li class="nav-item {{ Request::routeIs('Supplier.index') ? 'active' : '' }}">
                <a href="{{ route('Supplier.index') }}" class="nav-link">
                    <i class="fas fa-truck nav-icon"></i>
                    <p>
                        Nhà cung cấp
                    </p>
                </a>
            </li> --}}
            {{-- <li class="nav-item">
                <a href="{{ route('Car.index') }}" class="nav-link {{ Request::routeIs('Car.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p>Danh mục xe</p>
                </a>
            </li> --}}


            {{-- <li class="nav-item has-treeview {{ request()->is('g7/warehouse-imports*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('g7/warehouse-imports*') ? 'active' : '' }}">
                    <i class="fas fa-file-import nav-icon"></i>
                    <p>
                        Nhập hàng
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('WareHouseImport.create') }}" class="nav-link {{ Request::routeIs('WareHouseImport.create') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Tạo phiếu nhập</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{ route('WareHouseImport.index') }}" class="nav-link {{ Request::routeIs('WareHouseImport.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Danh sách phiếu nhập</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo</p>
                        </a>
                    </li>
                </ul>
            </li> --}}

            {{-- CTKM --}}
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-percent"></i>
                    <p>
                        CT Khuyến mãi
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('PromoCampaign.index') }}" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Danh sách chương trình</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('PromoCampaign.create') }}" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Thêm mới chương trình</p>
                        </a>
                    </li>
                </ul>
            </li>
            {{-- Báo cáo --}}
            <li class="nav-item has-treeview {{ request()->is('common/reports/customerSaleReport') || request()->is('common/reports/promoReport') || request()->is('common/reports/promoProductReport') || request()->is('reports/promoProductReport') || request()->is('g7/warehouse_reports*') || request()->is('g7/funds/business-reports*') ? 'menu-open' : '' }}">
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
                        <a href="{{ route('FundReports.index') }} " class="nav-link {{ Request::routeIs('FundReports.index') ? 'active' : '' }}">
                            <i class="far fas fa-angle-right nav-icon"></i>
                            <p>Báo cáo quỹ</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('WarehouseReport.saleReport') }}" class="nav-link {{ Request::routeIs('WarehouseReport.saleReport') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo bán hàng</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('Report.customerSaleReport') }}" class="nav-link {{ Request::routeIs('Report.customerSaleReport') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo bán hàng theo khách</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('Report.promoReport') }}" class="nav-link {{ Request::routeIs('Report.promoReport') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo khuyến mại</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('Report.promoProductReport') }}" class="nav-link {{ Request::routeIs('Report.promoProductReport') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo khuyến mại tặng hàng</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('BusinessReports.index') }}" class="nav-link {{ Request::routeIs('BusinessReports.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Báo cáo kết quả kinh doanh</p>
                        </a>
                    </li>
                </ul>
            </li>
            {{-- Nhân viên --}}
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                        Nhân viên
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('G7User.index') }}" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Tài khoản nhân viên</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('G7Employee.index') }}" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Hồ sơ nhân viên</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('Role.index') }}" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Chức vụ</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview">
                @if(Auth::user()->type == App\Model\Common\User::NHAN_VIEN_G7 || Auth::user()->type == App\Model\Common\User::G7 || Auth::user()->type == App\Model\Common\User::NHOM_G7)
                <a class="nav-link" href="{{ route('G7User.changePass') }}" title="Thay đổi mật khẩu">
                    <i class="fas fa-unlock-alt nav-icon"></i>
                    <p>
                        Thay đổi mật khẩu
                    </p>
                </a>
                @endif
                @if(Auth::user()->type == App\Model\Common\User::UPTEK || Auth::user()->type == App\Model\Common\User::SUPER_ADMIN)
                <a class="nav-link" href="{{ route('User.changePass') }}" title="Thay đổi mật khẩu">
                    <i class="fas fa-unlock-alt nav-icon"></i>
                    <p>
                        Thay đổi mật khẩu
                    </p>
                </a>
                @endif
            </li>
            {{-- Tin tức --}}
            <li class="nav-item has-treeview">
                <a href="{{ route('Post.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-newspaper"></i>
                    <p>
                        Tin tức G7
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
