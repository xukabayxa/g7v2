<?php

use App\Model\Common\User;
Route::get('/dang-nhap', 'Auth\LoginController@showLoginForm');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('dang-xuat','Auth\LoginController@logout')->name('logout');
    Route::get('/login-page',function() {
        return view('layouts.login');
    });
    Route::get('/home', 'HomeController@index')->name('home');
    Route::group(['prefix' => 'admin', 'middleware' => 'checkType:'.User::SUPER_ADMIN], function () {

    });

    Route::get('/', function () {
        if(!Auth::guest()) {
            return redirect()->route('dash');
        } else {
            return redirect()->route('login');
        }

    })->name('index');

    Route::group(['prefix' => 'common'], function () {
        Route::get('/dashboard', 'Common\DashboardController@index')->name('dash');

        Route::get('/{id}/checkprint','G7\BillController@checkPrint');

        // Danh mục điểm gara G7 - Hồ sơ G7
        Route::group(['prefix' => 'g7-infos', 'middleware' => 'checkType:'.User::UPTEK], function () {
            Route::get('/create', 'Uptek\G7InfoController@create')->name('G7Info.create')->middleware('checkPermission:Thêm điểm G7');
            Route::post('/', 'Uptek\G7InfoController@store')->name('G7Info.store')->middleware('checkPermission:Thêm điểm G7');
            Route::post('/{id}/update', 'Uptek\G7InfoController@update')->name('G7Info.update')->middleware('checkPermission:Sửa điểm G7');
            Route::get('/{id}/edit', 'Uptek\G7InfoController@edit')->name('G7Info.edit')->middleware('checkPermission:Sửa điểm G7');
            Route::get('/{id}/delete', 'Uptek\G7InfoController@delete')->name('G7Info.delete')->middleware('checkPermission:Xóa điểm G7');
            Route::get('/', 'Uptek\G7InfoController@index')->name('G7Info.index');
            Route::get('/searchData', 'Uptek\G7InfoController@searchData')->name('G7Info.searchData');
            Route::get('/exportExcel','Uptek\G7InfoController@exportExcel')->name('G7Info.exportExcel');
            Route::get('/exportPdf','Uptek\G7InfoController@exportPDF')->name('G7Info.exportPDF');
        });

        // Role Uptek
        Route::group(['prefix' => 'roles', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::UPTEK.','.User::G7], function () {
            Route::get('/create', 'Common\RoleController@create')->name('Role.create')->middleware('checkPermission:Quản lý chức vụ');
            Route::post('/', 'Common\RoleController@store')->name('Role.store')->middleware('checkPermission:Quản lý chức vụ');
            Route::get('/', 'Common\RoleController@index')->name('Role.index');
            Route::get('/{id}/edit', 'Common\RoleController@edit')->name('Role.edit')->middleware('checkPermission:Quản lý chức vụ');
            Route::get('/{id}/delete', 'Common\RoleController@delete')->name('Role.delete')->middleware('checkPermission:Quản lý chức vụ');
            Route::post('/{id}/update', 'Common\RoleController@update')->name('Role.update')->middleware('checkPermission:Quản lý chức vụ');
            Route::get('/searchData', 'Common\RoleController@searchData')->name('Role.searchData');
        });

        Route::group(['prefix' => 'users', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::UPTEK.','.User::G7], function () {
            Route::get('/create', 'Common\UserController@create')->name('User.create')->middleware('checkPermission:Quản lý người dùng');
            Route::post('/', 'Common\UserController@store')->name('User.store')->middleware('checkPermission:Quản lý người dùng');
            Route::get('/', 'Common\UserController@index')->name('User.index')->middleware('checkPermission:Quản lý người dùng');
            Route::get('/{id}/edit', 'Common\UserController@edit')->name('User.edit')->middleware('checkPermission:Quản lý người dùng');
            Route::get('/{id}/delete', 'Common\UserController@delete')->name('User.delete')->middleware('checkPermission:Quản lý người dùng');
            Route::post('/{id}/update', 'Common\UserController@update')->name('User.update')->middleware('checkPermission:Quản lý người dùng');
            Route::get('/searchData', 'Common\UserController@searchData')->name('User.searchData');
            Route::get('/exportExcel','Common\UserController@exportExcel')->name('User.exportExcel')->middleware('checkPermission:Quản lý người dùng');
            Route::get('/exportPdf','Common\UserController@exportPDF')->name('User.exportPDF')->middleware('checkPermission:Quản lý người dùng');
            Route::get('/change-password','Common\UserController@changePass')->name('User.changePass');
            Route::post('/update-password','Common\UserController@updatePass')->name('User.updatePass');
        });

        // Đặt lịch
        Route::group(['prefix' => 'bookings'], function () {
            Route::get('/create', 'Common\BookingController@create')->name('Booking.create');
            Route::get('/searchData', 'Common\BookingController@searchData')->name('Booking.searchData');
            Route::post('/{id}/update', 'Common\BookingController@update')->name('Booking.update');
            Route::post('/', 'Common\BookingController@store')->name('Booking.store');
            Route::get('/', 'Common\BookingController@index')->name('Booking.index');
            Route::get('/{id}/getDataForEdit', 'Common\BookingController@getDataForEdit')->name('Booking.getDataForEdit');
            Route::get('/{id}/delete', 'Common\BookingController@delete')->name('Booking.delete');
            Route::get('/exportExcel','Common\BookingController@exportExcel')->name('Booking.exportExcel');
            Route::get('/exportPDF','Common\BookingController@exportPDF')->name('Booking.exportPDF');
            Route::get('{id}/show','Common\BookingController@show')->name('Booking.show');
        });

        Route::group(['prefix' => 'notifications'], function () {
            Route::get('/', 'Common\NotificationsController@index')->name('Notification.index');
            Route::get('/{id}/read', 'Common\NotificationsController@read')->name('Notification.read');
            Route::get('/searchData', 'Common\NotificationsController@searchData')->name('Notification.searchData');
        });

		Route::group(['prefix' => 'promo_campaigns', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::UPTEK.','.User::G7], function () {
            Route::get('/create', 'Common\PromoCampaignController@create')->name('PromoCampaign.create')->middleware('checkPermission:Quản lý CTKM');
            Route::post('/', 'Common\PromoCampaignController@store')->name('PromoCampaign.store')->middleware('checkPermission:Quản lý CTKM');
            Route::get('/', 'Common\PromoCampaignController@index')->name('PromoCampaign.index')->middleware('checkPermission:Quản lý CTKM');
            Route::get('/{id}/edit', 'Common\PromoCampaignController@edit')->name('PromoCampaign.edit');
            Route::get('/{id}/lock', 'Common\PromoCampaignController@lock')->name('PromoCampaign.lock')->middleware('checkPermission:Quản lý CTKM');
			Route::get('/{id}/unlock', 'Common\PromoCampaignController@unlock')->name('PromoCampaign.unlock')->middleware('checkPermission:Quản lý CTKM');
            Route::post('/{id}/update', 'Common\PromoCampaignController@update')->name('PromoCampaign.update')->middleware('checkPermission:Quản lý CTKM');
            Route::get('/searchData', 'Common\PromoCampaignController@searchData')->name('PromoCampaign.searchData');
			Route::get('/{id}/getDataForUse', 'Common\PromoCampaignController@getDataForUse')->name('PromoCampaign.getDataForUse');
        });

		Route::group(['prefix' => 'reports', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::UPTEK.','.User::G7], function () {
            Route::get('/promoReport', 'Common\ReportController@promoReport')->name('Report.promoReport')->middleware('checkPermission:Xem báo cáo khuyến mãi chiết khấu');
            Route::get('/promoReportSearchData', 'Common\ReportController@promoReportSearchData')->name('Report.promoReportSearchData');
			Route::get('/promoReportPrint', 'Common\ReportController@promoReportPrint')->name('Report.promoReportPrint');
			Route::get('/promoProductReport', 'Common\ReportController@promoProductReport')->name('Report.promoProductReport')->middleware('checkPermission:Xem báo cáo khuyến mãi theo hàng hóa');
            Route::get('/promoProductReportSearchData', 'Common\ReportController@promoProductReportSearchData')->name('Report.promoProductReportSearchData');
			Route::get('/promoProductReportPrint', 'Common\ReportController@promoProductReportPrint')->name('Report.promoProductReportPrint');
			Route::get('/customerSaleReport', 'Common\ReportController@customerSaleReport')->name('Report.customerSaleReport')->middleware('checkPermission:Xem báo cáo kinh doanh theo khách hàng');;
            Route::get('/customerSaleReportSearchData', 'Common\ReportController@customerSaleReportSearchData')->name('Report.customerSaleReportSearchData');
			Route::get('/customerSaleReportPrint', 'Common\ReportController@customerSaleReportPrint')->name('Report.customerSaleReportPrint');
		});

        // Phân loại vật tư
        Route::group(['prefix' => 'product-categories', 'middleware' => 'checkType:'.User::UPTEK], function () {
            Route::get('/create', 'Common\ProductCategoryController@create')->name('ProductCategory.create')->middleware('checkPermission:Thêm loại hàng hóa');
            Route::post('/', 'Common\ProductCategoryController@store')->name('ProductCategory.store')->middleware('checkPermission:Thêm loại hàng hóa');
            Route::post('/{id}/update', 'Common\ProductCategoryController@update')->name('ProductCategory.update')->middleware('checkPermission:Cập nhật loại hàng hóa');
            Route::get('/{id}/edit', 'Common\ProductCategoryController@edit')->name('ProductCategory.edit')->middleware('checkPermission:Cập nhật loại hàng hóa');
            Route::get('/{id}/delete', 'Common\ProductCategoryController@delete')->name('ProductCategory.delete')->middleware('checkPermission:Xóa loại hàng hóa');
            Route::get('/', 'Common\ProductCategoryController@index')->name('ProductCategory.index');
            Route::get('/searchData', 'Common\ProductCategoryController@searchData')->name('ProductCategory.searchData');
            Route::get('/exportExcel','Common\ProductCategoryController@exportExcel')->name('ProductCategory.exportExcel');
        });

        // Phân loại dịch vụ
        Route::group(['prefix' => 'service-types', 'middleware' =>'checkType:'.User::SUPER_ADMIN.','.User::UPTEK.','.User::G7], function () {
            Route::get('/create', 'Common\ServiceTypeController@create')->name('ServiceType.create')->middleware('checkPermission:Thêm loại dịch vụ');
            Route::post('/', 'Common\ServiceTypeController@store')->name('ServiceType.store')->middleware('checkPermission:Thêm loại dịch vụ');
            Route::post('/{id}/update', 'Common\ServiceTypeController@update')->name('ServiceType.update')->middleware('checkPermission:Cập nhật loại dịch vụ');
            Route::get('/{id}/edit', 'Common\ServiceTypeController@edit')->name('ServiceType.edit')->middleware('checkPermission:Cập nhật loại dịch vụ');
            Route::get('/{id}/delete', 'Common\ServiceTypeController@delete')->name('ServiceType.delete')->middleware('checkPermission:Xóa loại dịch vụ');
            Route::get('/', 'Common\ServiceTypeController@index')->name('ServiceType.index');
            Route::get('/searchData', 'Common\ServiceTypeController@searchData')->name('ServiceType.searchData');
            Route::get('/exportExcel','Common\ServiceTypeController@exportExcel')->name('ServiceType.exportExcel');
        });

        // Danh mục đơn vị
        Route::group(['prefix' => 'units', 'middleware' => 'checkType:'.User::UPTEK.','.User::G7], function () {
            Route::get('/create', 'Common\UnitController@create')->name('Unit.create')->middleware('checkPermission:Thêm mới đơn vị');
            Route::post('/{id}/update', 'Common\UnitController@update')->name('Unit.update')->middleware('checkPermission:Cập nhật đơn vị');
            Route::post('/', 'Common\UnitController@store')->name('Unit.store')->middleware('checkPermission:Thêm mới đơn vị');
            Route::get('/', 'Common\UnitController@index')->name('Unit.index');
            Route::get('/{id}/edit', 'Common\UnitController@edit')->name('Unit.edit')->middleware('checkPermission:Cập nhật đơn vị tính');
            Route::get('/{id}/delete', 'Common\UnitController@delete')->name('Unit.delete')->middleware('checkPermission:Xóa đơn vị tính');
            Route::get('/searchData', 'Common\UnitController@searchData')->name('Unit.searchData');
            Route::get('/exportExcel','Common\UnitController@exportExcel')->name('Unit.exportExcel');
        });


        Route::group(['prefix' => 'products'], function () {
            Route::get('/', 'Uptek\ProductController@index')->name('Product.index');
            Route::get('/searchData', 'Uptek\ProductController@searchData')->name('Product.searchData');
            Route::get('/filterDataForBill', 'Uptek\ProductController@filterDataForBill')->name('Product.filterDataForBill');
            Route::get('/{id}/getData', 'Uptek\ProductController@getData')->name('Product.getData');
            Route::get('/exportExcel','Uptek\ProductController@exportExcel')->name('Product.exportExcel')->middleware('checkPermission:Xuất excel sản phẩm');
            Route::get('/exportPDF','Uptek\ProductController@exportPDF')->name('Product.exportPDF')->middleware('checkPermission:Xuất pdf sản phẩm');
        });

        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', 'Uptek\PostController@index')->name('Post.index');
            Route::get('/searchData', 'Uptek\PostController@searchData')->name('Post.searchData');
            Route::get('/{id}/show', 'Uptek\PostController@show')->name('Post.show');
        });

        Route::group(['prefix' => 'fixed-assets'], function () {
            Route::get('/searchData', 'Uptek\FixedAssetController@searchData')->name('FixedAsset.searchData');
            Route::get('/{id}/getDataForG7', 'Uptek\FixedAssetController@getDataForG7')->name('FixedAsset.getDataForG7');
            Route::get('/exportExcel','Uptek\FixedAssetController@exportExcel')->name('FixedAsset.exportExcel');
            Route::get('/exportPDF','Uptek\FixedAssetController@exportPDF')->name('FixedAsset.exportPDF');
        });

        // chuyển sang g7service-controller
        Route::group(['prefix' => 'services'], function () {
            Route::get('/', 'Uptek\ServiceController@index')->name('Service.index');
            Route::get('/searchData', 'Uptek\ServiceController@searchData')->name('Service.searchData');
            // Route::get('/{id}/getDataForG7Service', 'Uptek\ServiceController@getDataForG7Service')->name('Service.getDataForG7Service');
			Route::get('/searchDataForBill', 'Uptek\ServiceController@searchDataForBill')->name('Service.searchDataForBill');
			Route::get('/getDataForBill', 'Uptek\ServiceController@getDataForBill')->name('Service.getDataForBill');
			Route::get('/searchAllForBill', 'Uptek\ServiceController@searchAllForBill')->name('Service.searchAllForBill');
            Route::get('/{id}/show', 'Uptek\ServiceController@show')->name('Service.show');
		});

        Route::group(['prefix' => 'license-plates'], function () {
            Route::get('/create', 'Common\LicensePlateController@create')->name('LicensePlate.create')->middleware('checkPermission:Thêm mới biển số xe');
            Route::post('/', 'Common\LicensePlateController@store')->name('LicensePlate.store')->middleware('checkPermission:Thêm mới biển số xe');
            Route::get('/', 'Common\LicensePlateController@index')->name('LicensePlate.index');
            Route::get('/{id}/edit', 'Common\LicensePlateController@edit')->name('LicensePlate.edit')->middleware('checkPermission:Cập nhật biển số xe');
            Route::get('/{id}/delete', 'Common\LicensePlateController@delete')->name('LicensePlate.delete')->middleware('checkPermission:Xóa biển số xe');
            Route::post('/{id}/update', 'Common\LicensePlateController@update')->name('LicensePlate.update')->middleware('checkPermission:Cập nhật biển số xe');
            Route::get('/searchData', 'Common\LicensePlateController@searchData')->name('LicensePlate.searchData');
            Route::get('/exportExcel','Common\LicensePlateController@exportExcel')->name('LicensePlate.exportExcel');
        });

        // Xe
        Route::group(['prefix' => 'cars'], function (   ) {
            Route::get('/create', 'Common\CarController@create')->name('Car.create')->middleware('checkPermission:Thêm mới xe');
            Route::post('/', 'Common\CarController@store')->name('Car.store')->middleware('checkPermission:Thêm mới xe');
            Route::get('/', 'Common\CarController@index')->name('Car.index');
            Route::get('/{id}/edit', 'Common\CarController@edit')->name('Car.edit')->middleware('checkPermission:Cập nhật xe');
            Route::get('/{id}/delete', 'Common\CarController@delete')->name('Car.delete')->middleware('checkPermission:Xóa xe');
            Route::post('/{id}/update', 'Common\CarController@update')->name('Car.update')->middleware('checkPermission:Cập nhật xe');
            Route::get('/searchData', 'Common\CarController@searchData')->name('Car.searchData');
			Route::get('/searchForSelect', 'Common\CarController@searchForSelect')->name('Car.searchForSelect');
            Route::get('/exportExcel','Common\CarController@exportExcel')->name('Car.exportExcel');
            Route::get('/{id}/getData', 'Common\CarController@getData')->name('Car.getData');
            Route::get('/{id}/getCustomers', 'Common\CarController@getCustomers')->name('Car.getCustomers');
            Route::get('/{id}/getDataForShow', 'Common\CarController@getDataForShow')->name('Car.getDataForShow');
            Route::get('/exportExcel','Common\CarController@exportExcel')->name('Car.exportExcel');
            Route::get('/exportPDF','Common\CarController@exportPDF')->name('Car.exportPDF');
        });

        // Khách hàng
        Route::group(['prefix' => 'customers'], function () {
            Route::get('/create', 'Common\CustomerController@create')->name('Customer.create')->middleware('checkPermission:Thêm mới khách hàng');
            Route::post('/', 'Common\CustomerController@store')->name('Customer.store')->middleware('checkPermission:Thêm mới khách hàng');
            Route::get('/', 'Common\CustomerController@index')->name('Customer.index');
            Route::get('/{id}/edit', 'Common\CustomerController@edit')->name('Customer.edit')->middleware('checkPermission:Cập nhật khách hàng');
            Route::get('/{id}/delete', 'Common\CustomerController@delete')->name('Customer.delete')->middleware('checkPermission:Xóa khách hàng');
            Route::post('/{id}/update', 'Common\CustomerController@update')->name('Customer.update')->middleware('checkPermission:Cập nhật khách hàng');
            Route::get('/{id}/getDataForShow', 'Common\CustomerController@getDataForShow')->name('Customer.getDataForShow');
            Route::get('/{id}/getPoints', 'Common\CustomerController@getPoints')->name('Customer.getPoints');
            Route::get('/searchData', 'Common\CustomerController@searchData')->name('Customer.searchData');
            Route::get('/exportExcel','Common\CustomerController@exportExcel')->name('Customer.exportExcel');
            Route::get('/exportPDF','Common\CustomerController@exportPDF')->name('Customer.exportPDF');
        });

        Route::group(['prefix' => 'vehicle-manufacts'], function () {
            Route::get('/{id}/vehicle-types','Common\VehicleManufactController@getVehicleTypes')->name('VehicleManufact.getVehicleTypes');
            Route::get('/exportExcel','Common\VehicleManufactController@exportExcel')->name('VehicleManufact.exportExcel');
            Route::get('/exportPDF','Common\VehicleManufactController@exportPDF')->name('VehicleManufact.exportPDF');
        });
    });

    Route::group(['prefix' => 'uptek', 'middleware' => 'checkType:'.User::UPTEK.','.User::SUPER_ADMIN.','.User::G7], function () {
        // Service
        Route::group(['prefix' => 'services'], function () {
            Route::get('/', 'Uptek\UptekServiceController@index')->name('UptekService.index');
            Route::get('/searchData', 'Uptek\UptekServiceController@searchData')->name('UptekService.searchData');
            Route::get('/create', 'Uptek\UptekServiceController@create')->name('UptekService.create')->middleware('checkPermission:Thêm dịch vụ');
            Route::post('/', 'Uptek\UptekServiceController@store')->name('UptekService.store')->middleware('checkPermission:Thêm dịch vụ');
            Route::get('/{id}/edit', 'Uptek\UptekServiceController@edit')->name('UptekService.edit')->middleware('checkPermission:Sửa dịch vụ');
            Route::post('/{id}/update', 'Uptek\UptekServiceController@update')->name('UptekService.update')->middleware('checkPermission:Sửa dịch vụ');
            Route::get('/{id}/delete', 'Uptek\UptekServiceController@delete')->name('UptekService.delete')->middleware('checkPermission:Xóa dịch vụ');
        });

        // Vật tư
        Route::group(['prefix' => 'products'], function () {
            Route::get('/create', 'Uptek\ProductController@create')->name('Product.create')->middleware('checkPermission:Thêm hàng hóa');
            Route::post('/', 'Uptek\ProductController@store')->name('Product.store')->middleware('checkPermission:Thêm hàng hóa');
            Route::post('/{id}/update', 'Uptek\ProductController@update')->name('Product.update')->middleware('checkPermission:Sửa hàng hóa');
            Route::get('/{id}/edit', 'Uptek\ProductController@edit')->name('Product.edit')->middleware('checkPermission:Sửa hàng hóa');
            Route::get('/{id}/delete', 'Uptek\ProductController@delete')->name('Product.delete')->middleware('checkPermission:Xóa hàng hóa');
        });

        // Bài viết
        Route::group(['prefix' => 'posts'], function () {
            Route::get('/create', 'Uptek\PostController@create')->name('Post.create')->middleware('checkPermission:Thêm bài viết');
            Route::post('/', 'Uptek\PostController@store')->name('Post.store')->middleware('checkPermission:Thêm bài viết');
            Route::post('/{id}/update', 'Uptek\PostController@update')->name('Post.update')->middleware('checkPermission:Sửa bài viết');
            Route::get('/{id}/edit', 'Uptek\PostController@edit')->name('Post.edit')->middleware('checkPermission:Sửa bài viết');
            Route::get('/{id}/delete', 'Uptek\PostController@delete')->name('Post.delete')->middleware('checkPermission:Xóa bài viết');

            Route::get('/exportExcel','Uptek\PostController@exportExcel')->name('Post.exportExcel');
            // Route::get('{id}/show','Uptek\PostController@show')->name('Post.show');
        });

        Route::group(['prefix' => 'print-templates', 'middleware' => 'checkPermission:Cấu hình mẫu in'], function () {
            Route::post('/{id}/update', 'Uptek\PrintTemplateController@update')->name('PrintTemplate.update');
            Route::get('/', 'Uptek\PrintTemplateController@index')->name('PrintTemplate.index');
            Route::get('/{id}/edit', 'Uptek\PrintTemplateController@edit')->name('PrintTemplate.edit');
            Route::get('/searchData', 'Uptek\PrintTemplateController@searchData')->name('PrintTemplate.searchData');
        });
        // Danh mục tài sản cố định
        Route::group(['prefix' => 'fixed-assets'], function () {
            Route::get('/create', 'Uptek\FixedAssetController@create')->name('FixedAsset.create')->middleware('checkPermission:Thêm tài sản cố định');
            Route::post('/', 'Uptek\FixedAssetController@store')->name('FixedAsset.store')->middleware('checkPermission:Thêm tài sản cố định');
            Route::post('/{id}/update', 'Uptek\FixedAssetController@update')->name('FixedAsset.update')->middleware('checkPermission:Sửa tài sản cố định');
            Route::get('/{id}/edit', 'Uptek\FixedAssetController@edit')->name('FixedAsset.edit')->middleware('checkPermission:Sửa tài sản cố định');
            Route::get('/{id}/delete', 'Uptek\FixedAssetController@delete')->name('FixedAsset.delete')->middleware('checkPermission:Xóa tài sản cố định');
            Route::get('/', 'Uptek\FixedAssetController@index')->name('FixedAsset.index');
            Route::get('/exportExcel','Uptek\FixedAssetController@exportExcel')->name('FixedAsset.exportExcel');
        });

    });

    Route::group(['prefix' => 'g7', 'middleware' => 'checkType:'.User::G7.','.User::NHAN_VIEN_G7], function () {
        // Cấu hình chung
        Route::group(['prefix' => 'configs', 'middleware' => 'checkPermission:Cập nhật cấu hình'], function () {
            Route::get('/', 'G7\ConfigController@edit')->name('Config.edit')->middleware('checkPermission:Cập nhật cấu hình');
            Route::post('/update', 'G7\ConfigController@update')->name('Config.update')->middleware('checkPermission:Cập nhật cấu hình');
        });

        //  Cấu hình level khách hàng
        Route::group(['prefix' => 'customer-levels', 'middleware' => 'checkPermission:Cấu hình level khách hàng'], function () {
            Route::get('/', 'G7\CustomerLevelController@index')->name('CustomerLevel.index');
            Route::get('/searchData', 'G7\CustomerLevelController@searchData')->name('CustomerLevel.searchData');
            Route::get('/create', 'G7\CustomerLevelController@create')->name('CustomerLevel.create');
            Route::post('/{id}/update', 'G7\CustomerLevelController@update')->name('CustomerLevel.update');
            Route::post('/', 'G7\CustomerLevelController@store')->name('CustomerLevel.store');
            Route::get('/{id}/getDataForEdit', 'G7\CustomerLevelController@getDataForEdit');
            Route::get('/{id}/delete', 'G7\CustomerLevelController@delete')->name('CustomerLevel.delete');
            Route::get('/exportExcel','G7\CustomerLevelController@exportExcel')->name('CustomerLevel.exportExcel');
        });

        // Cấu hình tích điểm
        Route::group(['prefix' => 'accumulate-point', 'middleware' => 'checkPermission:Cấu hình tích điểm'], function () {
            Route::get('config', 'G7\AccumulatePointController@edit')->name('AccumulatePoint.edit');
            Route::post('/update', 'G7\AccumulatePointController@update')->name('AccumulatePoint.update');
        });

        // Hồ sơ nhân viên G7
        Route::group(['prefix' => 'g7-employees'], function () {
            Route::get('/create', 'G7\G7EmployeeController@create')->name('G7Employee.create')->middleware('checkPermission:Thêm hồ sơ nhân viên');
            Route::post('/{id}/update', 'G7\G7EmployeeController@update')->name('G7Employee.update')->middleware('checkPermission:Sửa hồ sơ nhân viên');
            Route::post('/', 'G7\G7EmployeeController@store')->name('G7Employee.store')->middleware('checkPermission:Thêm hồ sơ nhân viên');
            Route::get('/', 'G7\G7EmployeeController@index')->name('G7Employee.index');
            Route::get('/{id}/edit', 'G7\G7EmployeeController@edit')->name('G7Employee.edit')->middleware('checkPermission:Sửa hồ sơ nhân viên');
            Route::get('/{id}/delete', 'G7\G7EmployeeController@delete')->name('G7Employee.delete')->middleware('checkPermission:Xóa hồ sơ nhân viên');
            Route::get('/exportExcel','G7\G7EmployeeController@exportExcel')->name('G7Employee.exportExcel');
            Route::get('/searchData', 'G7\G7EmployeeController@searchData')->name('G7Employee.searchData');
            Route::get('/{id}/getData', 'G7\G7EmployeeController@getData')->name('G7Employee.getData');
        });
        // Tài khoản nhân viên G7
        Route::group(['prefix' => 'users'], function () {
            Route::get('/create', 'G7\G7UserController@create')->name('G7User.create')->middleware('checkPermission:Thêm mới tài khoản nhân viên G7');
            Route::post('/', 'G7\G7UserController@store')->name('G7User.store')->middleware('checkPermission:Thêm mới tài khoản nhân viên G7');
            Route::get('/', 'G7\G7UserController@index')->name('G7User.index');
            Route::get('/{id}/edit', 'G7\G7UserController@edit')->name('G7User.edit')->middleware('checkPermission:Cập nhật tài khoản nhân viên G7');
            Route::get('/{id}/delete', 'G7\G7UserController@delete')->name('G7User.delete')->middleware('checkPermission:Xóa tài khoản nhân viên G7');
            Route::post('/{id}/update', 'G7\G7UserController@update')->name('G7User.update')->middleware('checkPermission:Cập nhật tài khoản nhân viên G7');
            Route::get('/searchData', 'G7\G7UserController@searchData')->name('G7User.searchData');
            Route::get('/change-password','G7\G7UserController@changePass')->name('G7User.changePass');
            Route::post('/update-password','G7\G7UserController@updatePass')->name('G7User.updatePass');
        });
        // Đặt lịch
        Route::group(['prefix' => 'bookings'], function () {
            Route::get('/', 'Uptek\BookingController@index')->name('G7Booking.index');
        });
    // Nhắc lịch
        Route::group(['prefix' => 'calendar-reminders'], function () {
            Route::get('/create', 'G7\CalendarReminderController@create')->name('CalendarReminder.create')->middleware('checkPermission:Thêm nhắc lịch');
            Route::post('/{id}/update', 'G7\CalendarReminderController@update')->name('CalendarReminder.update')->middleware('checkPermission:Sửa nhắc lịch');
            Route::post('/', 'G7\CalendarReminderController@store')->name('CalendarReminder.store')->middleware('checkPermission:Thêm nhắc lịch');
            Route::get('/', 'G7\CalendarReminderController@index')->name('CalendarReminder.index');
            Route::get('/{id}/delete', 'G7\CalendarReminderController@delete')->name('CalendarReminder.delete')->middleware('checkPermission:Xóa nhắc lịch');
            Route::get('/searchData', 'G7\CalendarReminderController@searchData')->name('CalendarReminder.searchData');
            Route::get('/{id}/getDataForEdit', 'G7\CalendarReminderController@getDataForEdit')->name('CalendarReminder.getDataForEdit');
            Route::get('/{id}/conFirmed', 'G7\CalendarReminderController@conFirmed')->name('CalendarReminder.conFirmed');
            Route::get('/exportExcel','G7\CalendarReminderController@exportExcel')->name('CalendarReminder.exportExcel');
            Route::get('/exportPDF','G7\CalendarReminderController@exportPDF')->name('CalendarReminder.exportPDF');
        });

        Route::group(['prefix' => 'products'], function () {
            Route::get('/create', 'G7\G7ProductController@create')->name('G7Product.create');
            Route::post('/{id}/update', 'G7\G7ProductController@update')->name('G7Product.update');
            Route::post('/', 'G7\G7ProductController@store')->name('G7Product.store');
            Route::get('/', 'G7\G7ProductController@index')->name('G7Product.index');
            Route::get('/editPrice', 'G7\G7ProductController@editPrice')->name('G7Product.editPrice')->middleware('checkPermission:Cập nhật giá hàng hóa');
            Route::post('/updatePrice', 'G7\G7ProductController@updatePrice')->name('G7Product.updatePrice')->middleware('checkPermission:Cập nhật giá hàng hóa');
            Route::get('/{id}/edit', 'G7\G7ProductController@edit')->name('G7Product.edit');
            Route::get('/{id}/delete', 'G7\G7ProductController@delete')->name('G7Product.delete');
            Route::get('/exportExcel','G7\G7ProductController@exportExcel')->name('G7Product.exportExcel');
            Route::get('/searchData', 'G7\G7ProductController@searchData')->name('G7Product.searchData');
            Route::get('/{id}/getData', 'G7\G7ProductController@getData')->name('G7Product.getData');
        });

        Route::group(['prefix' => 'g7_fixed_assets'], function () {
            Route::get('/create', 'G7\G7FixedAssetController@create')->name('G7FixedAsset.create')->middleware('checkPermission:Thêm tài sản cố định');
            Route::post('/{id}/update', 'G7\G7FixedAssetController@update')->name('G7FixedAsset.update')->middleware('checkPermission:Sửa tài sản cố định');
            Route::post('/', 'G7\G7FixedAssetController@store')->name('G7FixedAsset.store')->middleware('checkPermission:Thêm tài sản cố định');
            Route::get('/', 'G7\G7FixedAssetController@index')->name('G7FixedAsset.index');
            Route::get('/{id}/edit', 'G7\G7FixedAssetController@edit')->name('G7FixedAsset.edit')->middleware('checkPermission:Sửa tài sản cố định');
            Route::get('/{id}/delete', 'G7\G7FixedAssetController@delete')->name('G7FixedAsset.delete')->middleware('checkPermission:Xóa tài sản cố định');
			Route::get('/{id}/getData', 'G7\G7FixedAssetController@getData')->name('G7FixedAsset.getData');
            Route::get('/exportExcel','G7\G7FixedAssetController@exportExcel')->name('G7FixedAsset.exportExcel');
            Route::get('/searchData', 'G7\G7FixedAssetController@searchData')->name('G7FixedAsset.searchData');
            Route::get('/report', 'G7\G7FixedAssetController@report')->name('G7FixedAsset.report')->middleware('checkPermission:Xem báo cáo tài sản cố định');;
            Route::get('/searchReportData', 'G7\G7FixedAssetController@searchReportData')->name('G7FixedAsset.searchReportData');
        });

		Route::group(['prefix' => 'g7_fixed_asset_imports'], function () {
            Route::get('/create', 'G7\G7FixedAssetImportController@create')->name('G7FixedAssetImport.create')->middleware('checkPermission:Tạo phiếu nhập TSCD');
            Route::post('/{id}/update', 'G7\G7FixedAssetImportController@update')->name('G7FixedAssetImport.update')->middleware('checkPermission:Cập nhật phiếu nhập TSCD');
            Route::post('/', 'G7\G7FixedAssetImportController@store')->name('G7FixedAssetImport.store')->middleware('checkPermission:Tạo phiếu nhập TSCD');
            Route::get('/', 'G7\G7FixedAssetImportController@index')->name('G7FixedAssetImport.index');
            Route::get('/{id}/edit', 'G7\G7FixedAssetImportController@edit')->name('G7FixedAssetImport.edit')->middleware('checkPermission:Cập nhật phiếu nhập TSCD');
			Route::get('/{id}/getDataForShow', 'G7\G7FixedAssetImportController@getDataForShow')->name('G7FixedAssetImport.getDataForShow');
            Route::get('/{id}/delete', 'G7\G7FixedAssetImportController@delete')->name('G7FixedAssetImport.delete')->middleware('checkPermission:Hủy phiếu nhập TSCD');
            Route::get('/searchData', 'G7\G7FixedAssetImportController@searchData')->name('G7FixedAssetImport.searchData');
            Route::get('/{id}/print', 'G7\G7FixedAssetImportController@print')->name('G7FixedAssetImport.print');
        });

        Route::group(['prefix' => 'services'], function () {
            Route::get('/create', 'G7\G7ServiceController@create')->name('G7Service.create');
            Route::post('/{id}/update', 'G7\G7ServiceController@update')->name('G7Service.update');
            Route::post('/', 'G7\G7ServiceController@store')->name('G7Service.store');
            Route::get('/', 'G7\G7ServiceController@index')->name('G7Service.index');
            Route::get('/{id}/edit', 'G7\G7ServiceController@edit')->name('G7Service.edit');
            Route::get('/{id}/delete', 'G7\G7ServiceController@delete')->name('G7Service.delete');
            Route::get('/searchData', 'G7\G7ServiceController@searchData')->name('G7Service.searchData');
            Route::get('/searchDataForBill', 'G7\G7ServiceController@searchDataForBill')->name('G7Service.searchDataForBill');
            Route::get('/getDataForBill', 'G7\G7ServiceController@getDataForBill')->name('G7Service.getDataForBill');
            Route::get('/getServiceUptek', 'G7\G7ServiceController@getServiceUptek')->name('G7Service.getServiceUptek');
        });

        Route::group(['prefix' => 'fund-accounts'], function () {
            Route::get('/create', 'G7\FundAccountController@create')->name('FundAccount.create');
            Route::post('/{id}/update', 'G7\FundAccountController@update')->name('FundAccount.update');
            Route::post('/', 'G7\FundAccountController@store')->name('FundAccount.store');
            Route::get('/', 'G7\FundAccountController@index')->name('FundAccount.index');
            Route::get('/{id}/edit', 'G7\FundAccountController@edit')->name('FundAccount.edit');
            Route::get('/{id}/delete', 'G7\FundAccountController@delete')->name('FundAccount.delete');
            Route::get('/exportExcel','G7\FundAccountController@exportExcel')->name('FundAccount.exportExcel');
            Route::get('/searchData', 'G7\FundAccountController@searchData')->name('FundAccount.searchData');
        });

        Route::group(['prefix' => 'suppliers'], function () {
            Route::get('/create', 'G7\SupplierController@create')->name('Supplier.create')->middleware('checkPermission:Tạo nhà cung cấp');
            Route::post('/{id}/update', 'G7\SupplierController@update')->name('Supplier.update')->middleware('checkPermission:Cập nhật nhà cung cấp');
            Route::post('/', 'G7\SupplierController@store')->name('Supplier.store')->middleware('checkPermission:Tạo nhà cung cấp');
            Route::get('/', 'G7\SupplierController@index')->name('Supplier.index');
            Route::get('/{id}/edit', 'G7\SupplierController@edit')->name('Supplier.edit')->middleware('checkPermission:Cập nhật nhà cung cấp');
            Route::get('/{id}/delete', 'G7\SupplierController@delete')->name('Supplier.delete')->middleware('checkPermission:Xóa nhà cung cấp');
            Route::get('/exportExcel','G7\SupplierController@exportExcel')->name('Supplier.exportExcel');
            Route::get('/searchData', 'G7\SupplierController@searchData')->name('Supplier.searchData');
            Route::get('/{id}/getDataForEdit', 'G7\SupplierController@getDataForEdit')->name('Supplier.getDataForEdit');
            Route::get('/exportExcel','G7\SupplierController@exportExcel')->name('Supplier.exportExcel');
            Route::get('/exportPDF','G7\SupplierController@exportPDF')->name('Supplier.exportPDF');
        });

        Route::group(['prefix' => 'warehouse-imports'], function () {
            Route::get('/create', 'G7\WareHouseImportController@create')->name('WareHouseImport.create')->middleware('checkPermission:Tạo phiếu nhập kho');
            Route::post('/{id}/update', 'G7\WareHouseImportController@update')->name('WareHouseImport.update')->middleware('checkPermission:Cập nhật phiếu nhập kho');
            Route::post('/', 'G7\WareHouseImportController@store')->name('WareHouseImport.store')->middleware('checkPermission:Tạo phiếu nhập kho');
            Route::get('/', 'G7\WareHouseImportController@index')->name('WareHouseImport.index');
            Route::get('/{id}/edit', 'G7\WareHouseImportController@edit')->name('WareHouseImport.edit')->middleware('checkPermission:Cập nhật phiếu nhập kho');
            Route::get('/{id}/delete', 'G7\WareHouseImportController@delete')->name('WareHouseImport.delete')->middleware('checkPermission:Cập nhật phiếu nhập kho');
            Route::get('/exportExcel','G7\WareHouseImportController@exportExcel')->name('WareHouseImport.exportExcel');
            Route::get('/searchData', 'G7\WareHouseImportController@searchData')->name('WareHouseImport.searchData');
            Route::get('/{id}/payment', 'G7\WareHouseImportController@getDataForPay')->name('WareHouseImport.getDataForPay');
            Route::get('/{id}/show', 'G7\WareHouseImportController@getDataForShow')->name('WareHouseImport.getDataForShow');
            Route::get('/{id}/getDataBySupplier', 'G7\WareHouseImportController@getDataBySupplier')->name('WareHouseImport.getDataBySupplier');
            Route::get('/{id}/print', 'G7\WareHouseImportController@print')->name('WareHouseImport.print');
        });

        Route::group(['prefix' => 'funds'], function () {
            Route::group(['prefix' => 'payment-voucher-types'], function () {
                Route::get('/create', 'G7\PaymentVoucherTypeController@create')->name('PaymentVoucherType.create');
                Route::post('/{id}/update', 'G7\PaymentVoucherTypeController@update')->name('PaymentVoucherType.update');
                Route::post('/', 'G7\PaymentVoucherTypeController@store')->name('PaymentVoucherType.store');
                Route::get('/', 'G7\PaymentVoucherTypeController@index')->name('PaymentVoucherType.index');
                Route::get('/{id}/edit', 'G7\PaymentVoucherTypeController@edit')->name('PaymentVoucherType.edit');
                Route::get('/{id}/delete', 'G7\PaymentVoucherTypeController@delete')->name('PaymentVoucherType.delete');
                Route::get('/exportExcel','G7\PaymentVoucherTypeController@exportExcel')->name('PaymentVoucherType.exportExcel');
                Route::get('/searchData', 'G7\PaymentVoucherTypeController@searchData')->name('PaymentVoucherType.searchData');
                Route::get('/{id}/show', 'G7\PaymentVoucherTypeController@getDataForShow')->name('PaymentVoucherType.getDataForShow');
            });

            Route::group(['prefix' => 'payment-vouchers'], function () {
                Route::get('/create', 'G7\PaymentVoucherController@create')->name('PaymentVoucher.create')->middleware('checkPermission:Tạo phiếu chi');
                Route::post('/', 'G7\PaymentVoucherController@store')->name('PaymentVoucher.store')->middleware('checkPermission:Tạo phiếu chi');
                Route::get('/', 'G7\PaymentVoucherController@index')->name('PaymentVoucher.index');
                Route::get('/{id}/delete', 'G7\PaymentVoucherController@delete')->name('PaymentVoucher.delete');
                Route::get('/exportExcel','G7\PaymentVoucherController@exportExcel')->name('PaymentVoucher.exportExcel');
                Route::get('/searchData', 'G7\PaymentVoucherController@searchData')->name('PaymentVoucher.searchData');
                Route::get('/{id}/show', 'G7\PaymentVoucherController@getDataForShow')->name('PaymentVoucher.getDataForShow');
                Route::get('{type_id}/getRecipient', 'G7\PaymentVoucherController@getRecipient')->name('PaymentVoucher.getRecipient');
            });

            Route::group(['prefix' => 'receipt-voucher-types'], function () {
                Route::get('/create', 'G7\ReceiptVoucherTypeController@create')->name('ReceiptVoucherType.create');
                Route::post('/{id}/update', 'G7\ReceiptVoucherTypeController@update')->name('ReceiptVoucherType.update');
                Route::post('/', 'G7\ReceiptVoucherTypeController@store')->name('ReceiptVoucherType.store');
                Route::get('/', 'G7\ReceiptVoucherTypeController@index')->name('ReceiptVoucherType.index');
                Route::get('/{id}/edit', 'G7\ReceiptVoucherTypeController@edit')->name('ReceiptVoucherType.edit');
                Route::get('/{id}/delete', 'G7\ReceiptVoucherTypeController@delete')->name('ReceiptVoucherType.delete');
                Route::get('/exportExcel','G7\ReceiptVoucherTypeController@exportExcel')->name('ReceiptVoucherType.exportExcel');
                Route::get('/searchData', 'G7\ReceiptVoucherTypeController@searchData')->name('ReceiptVoucherType.searchData');
                Route::get('/{id}/getDataForShow', 'G7\ReceiptVoucherTypeController@getDataForShow')->name('ReceiptVoucherType.getDataForShow');

            });

            Route::group(['prefix' => 'receipt-vouchers'], function () {
                Route::get('/create', 'G7\ReceiptVoucherController@create')->name('ReceiptVoucher.create')->middleware('checkPermission:Tạo phiếu thu');
                Route::post('/', 'G7\ReceiptVoucherController@store')->name('ReceiptVoucher.store')->middleware('checkPermission:Tạo phiếu thu');
                Route::get('/', 'G7\ReceiptVoucherController@index')->name('ReceiptVoucher.index');
                Route::get('/{id}/delete', 'G7\ReceiptVoucherController@delete')->name('ReceiptVoucher.delete')->middleware('checkPermission:Hủy phiếu thu');
                Route::get('/exportExcel','G7\ReceiptVoucherController@exportExcel')->name('ReceiptVoucher.exportExcel');
                Route::get('/searchData', 'G7\ReceiptVoucherController@searchData')->name('ReceiptVoucher.searchData');
                Route::get('/{id}/show', 'G7\ReceiptVoucherController@getDataForShow')->name('ReceiptVoucher.getDataForShow');
                Route::get('{type_id}/get-payer', 'G7\ReceiptVoucherController@getPayer')->name('ReceiptVoucher.getPayer');
                Route::get('/{id}/print', 'G7\ReceiptVoucherController@print')->name('ReceiptVoucher.print');
            });

            Route::group(['prefix' => 'fund-reports'], function () {
                Route::get('/', 'G7\FundReportsController@index')->name('FundReports.index');
            });

            Route::group(['prefix' => 'business-reports'], function () {
                Route::get('/', 'G7\BusinessReportsController@index')->name('BusinessReports.index');
            });
        });

        Route::group(['prefix' => 'bills'], function () {
            Route::get('/create', 'G7\BillController@create')->name('Bill.create')->middleware('checkPermission:Tạo hóa đơn bán hàng');
            Route::post('/{id}/update', 'G7\BillController@update')->name('Bill.update')->middleware('checkPermission:Cập nhật hóa đơn bán hàng');
            Route::post('/', 'G7\BillController@store')->name('Bill.store')->middleware('checkPermission:Tạo hóa đơn bán hàng');
            Route::get('/', 'G7\BillController@index')->name('Bill.index');
            Route::get('/searchData', 'G7\BillController@searchData')->name('Bill.searchData');
            Route::get('/{id}/edit', 'G7\BillController@edit')->name('Bill.edit')->middleware('checkPermission:Cập nhật hóa đơn bán hàng');
            Route::get('/{id}/show', 'G7\BillController@show')->name('Bill.show')->middleware('checkPermission:Xem hóa đơn bán');
            Route::get('/{id}/delete', 'G7\BillController@delete')->name('Bill.delete')->middleware('checkPermission:Hủy hóa đơn bán');
            Route::get('/{id}/getDataByCustomer', 'G7\BillController@getDataByCustomer')->name('Bill.getDataByCustomer');
            Route::get('/{id}/receipt', 'G7\BillController@getDataForReceipt')->name('Bill.getDataForReceipt');
            Route::get('/{id}/getDataForShow', 'G7\BillController@getDataForShow')->name('Bill.getDataForShow');
            Route::get('/{id}/getDataForShow2', 'G7\BillController@getDataForShow2')->name('Bill.getDataForShow2');
			Route::get('/{id}/getDataForWarehouseExport', 'G7\BillController@getDataForWarehouseExport')->name('Bill.getDataForWarehouseExport');
            Route::get('/getDataForFinalAdjust', 'G7\BillController@getDataForFinalAdjust')->name('Bill.getDataForFinalAdjust');
            Route::get('/{id}/print', 'G7\BillController@print')->name('Bill.print');
			Route::get('/{id}/getDataForReturn', 'G7\BillController@getDataForReturn')->name('Bill.getDataForReturn');
        });

		Route::group(['prefix' => 'bill_returns'], function () {
            Route::get('/create', 'G7\BillReturnController@create')->name('BillReturn.create');
            Route::post('/{id}/update', 'G7\BillReturnController@update')->name('BillReturn.update');
            Route::post('/', 'G7\BillReturnController@store')->name('BillReturn.store');
            Route::get('/', 'G7\BillReturnController@index')->name('BillReturn.index');
            Route::get('/searchData', 'G7\BillReturnController@searchData')->name('BillReturn.searchData');
            Route::get('/{id}/edit', 'G7\BillReturnController@edit')->name('BillReturn.edit');
            Route::get('/{id}/show', 'G7\BillReturnController@show')->name('BillReturn.show');
            Route::get('/{id}/delete', 'G7\BillReturnController@delete')->name('BillReturn.delete');
            Route::get('/{id}/getDataForShow', 'G7\BillReturnController@getDataForShow')->name('BillReturn.getDataForShow');
            Route::get('/{id}/print', 'G7\BillReturnController@print')->name('BillReturn.print');
        });

		Route::group(['prefix' => 'warehouse_exports'], function () {
            Route::get('/create', 'G7\WarehouseExportController@create')->name('WarehouseExport.create')->middleware('checkPermission:Tạo phiếu xuất kho');
            Route::post('/', 'G7\WarehouseExportController@store')->name('WarehouseExport.store')->middleware('checkPermission:Tạo phiếu xuất kho');
            Route::get('/', 'G7\WarehouseExportController@index')->name('WarehouseExport.index');
            Route::get('/searchData', 'G7\WarehouseExportController@searchData')->name('WarehouseExport.searchData');
            Route::get('/{id}/show', 'G7\WarehouseExportController@show')->name('WarehouseExport.show');
            Route::get('/{id}/getDataForShow', 'G7\WarehouseExportController@getDataForShow')->name('WarehouseExport.getDataForShow');
            Route::get('/{id}/print', 'G7\WarehouseExportController@print')->name('WarehouseExport.print');
        });

        // Route::group(['prefix' => 'final_warehouse_adjust'], function () {
        //     Route::get('/create', 'G7\FinalWarehouseAdjustController@create')->name('FinalWarehouseAdjust.create');
        //     Route::post('/', 'G7\FinalWarehouseAdjustController@store')->name('FinalWarehouseAdjust.store');
        //     Route::get('/', 'G7\FinalWarehouseAdjustController@index')->name('FinalWarehouseAdjust.index');
        //     Route::get('/searchData', 'G7\FinalWarehouseAdjustController@searchData')->name('FinalWarehouseAdjust.searchData');
        //     Route::get('/{id}/show', 'G7\FinalWarehouseAdjustController@show')->name('FinalWarehouseAdjust.show');
        // });

		Route::group(['prefix' => 'warehouse_reports'], function () {
            Route::get('/stockReport', 'G7\WarehouseReportController@stockReport')->name('WarehouseReport.stockReport')->middleware('checkPermission:Xem báo cáo kho');
			Route::get('/stockReportSearchData', 'G7\WarehouseReportController@stockReportSearchData')->name('WarehouseReport.stockReportSearchData');
			Route::get('/stockReportExcel', 'G7\WarehouseReportController@stockReportExcel')->name('WarehouseReport.stockReportExcel')->middleware('checkPermission:Xem báo cáo kho');
			Route::get('/saleReport', 'G7\WarehouseReportController@saleReport')->name('WarehouseReport.saleReport')->middleware('checkPermission:Xem báo cáo bán hàng');
			Route::get('/saleReportSearchData', 'G7\WarehouseReportController@saleReportSearchData')->name('WarehouseReport.saleReportSearchData');
			Route::get('/saleReportExcel', 'G7\WarehouseReportController@saleReportExcel')->name('WarehouseReport.saleReportExcel')->middleware('checkPermission:Xem báo cáo bán hàng');
			Route::get('/fundReport', 'G7\WarehouseReportController@fundReport')->name('WarehouseReport.fundReport')->middleware('checkPermission:Xem báo cáo quỹ');
			Route::get('/fundReportSearchData', 'G7\WarehouseReportController@fundReportSearchData')->name('WarehouseReport.fundReportSearchData');
			Route::get('/fundReportExcel', 'G7\WarehouseReportController@fundReportExcel')->name('WarehouseReport.fundReportExcel')->middleware('checkPermission:Xem báo cáo quỹ');
		});
    });


    Route::group(['prefix' => 'g7_employee', 'middleware' => 'checkType:'.User::NHAN_VIEN_G7], function () {

    });
// Hãng xe
    Route::group(['prefix' => 'vehicle-manufacts', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::UPTEK], function () {
		Route::get('/create', 'Common\VehicleManufactController@create')->name('VehicleManufact.create')->middleware('checkPermission:Thêm mới hãng xe');
		Route::post('/', 'Common\VehicleManufactController@store')->name('VehicleManufact.store')->middleware('checkPermission:Thêm mới hãng xe');
		Route::get('/', 'Common\VehicleManufactController@index')->name('VehicleManufact.index');
		Route::get('/{id}/edit', 'Common\VehicleManufactController@edit')->name('VehicleManufact.edit')->middleware('checkPermission:Cập nhật hãng xe');
		Route::get('/{id}/delete', 'Common\VehicleManufactController@delete')->name('VehicleManufact.delete')->middleware('checkPermission:Xóa hãng xe');
        Route::post('/{id}/update', 'Common\VehicleManufactController@update')->name('VehicleManufact.update')->middleware('checkPermission:Cập nhật hãng xe');
        Route::get('/searchData', 'Common\VehicleManufactController@searchData')->name('VehicleManufact.searchData');
        Route::get('/exportExcel','Common\VehicleManufactController@exportExcel')->name('VehicleManufact.exportExcel');
    });
    // Loại xe
    Route::group(['prefix' => 'vehicle-types', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::UPTEK], function () {
		Route::get('/create', 'Common\VehicleTypeController@create')->name('VehicleType.create')->middleware('checkPermission:Thêm mới loại xe');
		Route::post('/', 'Common\VehicleTypeController@store')->name('VehicleType.store')->middleware('checkPermission:Thêm mới loại xe');
		Route::get('/', 'Common\VehicleTypeController@index')->name('VehicleType.index');
		Route::get('/{id}/edit', 'Common\VehicleTypeController@edit')->name('VehicleType.edit')->middleware('checkPermission:Cập nhật loại xe');
		Route::get('/{id}/delete', 'Common\VehicleTypeController@delete')->name('VehicleType.delete')->middleware('checkPermission:Xóa loại xe');
        Route::post('/{id}/update', 'Common\VehicleTypeController@update')->name('VehicleType.update')->middleware('checkPermission:Cập nhật loại xe');
        Route::get('/searchData', 'Common\VehicleTypeController@searchData')->name('VehicleType.searchData');
        Route::get('{id}/getDataForEdit', 'Common\VehicleTypeController@getDataForEdit')->name('VehicleType.getDataForEdit');
        Route::get('/exportExcel','Common\VehicleTypeController@exportExcel')->name('VehicleType.exportExcel');
        Route::get('/exportPDF','Common\VehicleTypeController@exportPDF')->name('VehicleType.exportPDF');
    });
    // Dòng xe
    Route::group(['prefix' => 'vehicle-categories', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::UPTEK], function () {
		Route::get('/create', 'Common\VehicleCategoryController@create')->name('VehicleCategory.create')->middleware('checkPermission:Thêm mới dòng xe');
		Route::post('/', 'Common\VehicleCategoryController@store')->name('VehicleCategory.store')->middleware('checkPermission:Thêm mới dòng xe');
		Route::get('/', 'Common\VehicleCategoryController@index')->name('VehicleCategory.index');
		Route::get('/{id}/edit', 'Common\VehicleCategoryController@edit')->name('VehicleCategory.edit')->middleware('checkPermission:Cập nhật dòng xe');
		Route::get('/{id}/delete', 'Common\VehicleCategoryController@delete')->name('VehicleCategory.delete')->middleware('checkPermission:Xóa dòng xe');
        Route::post('/{id}/update', 'Common\VehicleCategoryController@update')->name('VehicleCategory.update')->middleware('checkPermission:Cập nhật dòng xe');
        Route::get('/searchData', 'Common\VehicleCategoryController@searchData')->name('VehicleCategory.searchData');
        Route::get('/exportExcel','Common\VehicleCategoryController@exportExcel')->name('VehicleCategory.exportExcel');
        Route::get('/exportPDF','Common\VehicleCategoryController@exportPDF')->name('VehicleCategory.exportPDF');
    });

    // Nhóm khách hàng
    Route::group(['prefix' => 'customer-groups', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::UPTEK], function () {
		Route::get('/create', 'Common\CustomerGroupController@create')->name('CustomerGroup.create')->middleware('checkPermission:Thêm mới nhóm khách hàng');
		Route::post('/', 'Common\CustomerGroupController@store')->name('CustomerGroup.store')->middleware('checkPermission:Thêm mới nhóm khách hàng');
		Route::get('/', 'Common\CustomerGroupController@index')->name('CustomerGroup.index');
		Route::get('/{id}/edit', 'Common\CustomerGroupController@edit')->name('CustomerGroup.edit')->middleware('checkPermission:Cập nhật nhóm khách hàng');
		Route::get('/{id}/delete', 'Common\CustomerGroupController@delete')->name('CustomerGroup.delete')->middleware('checkPermission:Xóa nhóm khách hàng');
        Route::post('/{id}/update', 'Common\CustomerGroupController@update')->name('CustomerGroup.update')->middleware('checkPermission:Cập nhật nhóm khách hàng');
        Route::get('/searchData', 'Common\CustomerGroupController@searchData')->name('CustomerGroup.searchData');
        Route::get('/exportExcel','Common\CustomerGroupController@exportExcel')->name('CustomerGroup.exportExcel');
        Route::get('/exportPDF','Common\CustomerGroupController@exportPDF')->name('CustomerGroup.exportPDF');
    });

    // Route Tỉnh >> Huyện >> Xã
    Route::group(['prefix' => 'locations'], function () {
        Route::get('/{id}/districts', 'Common\LocationController@getDistricts')->name('getDistricts');
        Route::get('/{id}/wards', 'Common\LocationController@getWards')->name('getWards');
    });

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
