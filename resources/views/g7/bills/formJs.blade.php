$scope.loading = {};

let car_options = {
    title: "Tìm kiếm xe theo biển số",
    ajax: {
        url: "{!! route('Car.searchData') !!}",
        data: function (d, context) {
            DATATABLE.mergeSearch(d, context);
        }
    },
    columns: [
        {{-- {data: 'DT_RowIndex', orderable: false, title: "STT"}, --}}
        {data: 'license_plate', title: "Biển số"},
        {data: 'customers', title: "Chủ sở hữu"},
    ],
    search_columns: [
        {data: 'license_plate', search_type: "text", placeholder: "Biển số"},
        {data: 'customer_mobile', search_type: "text", placeholder: "Tên hoặc sđt chủ xe"},
    ]
  };

{{-- $scope.searchCar = new BaseSearchModal(
	car_options,
	function(obj) {
		$scope.chooseCar(obj);
	}
); --}}


$scope.removeCar = function() {
	$scope.car_id = null;
	$scope.form.car = null;
	$scope.form.list = $scope.form.list_products;
	$scope.form.customer_id = '';
	$scope.getPoints();
	$scope.getServices();
}

$scope.chooseCar = function(obj) {
	if (!obj.id) {
		$scope.form.car = null;
        $scope.removeCar()
        customerCarId = null;
	} else {
		sendRequest({
			type: "GET",
			url: '/common/cars/' + obj.id + '/getData',
			success: function(response) {
				if (response.success) {
					if ($scope.form._vehicle_category_id != response.data.category_id) {
						$scope.form.list = $scope.form.list_products;
					}
					$scope.form.car = response.data;
					$scope.form.car_id = $scope.form.car.id;
                    customerCarId = $scope.form.car.id;
					if ($scope.form.car.customers && $scope.form.car.customers.length) {
						$scope.form.customer_id = $scope.form.car.customers[0].id;
						$scope.form.registration_deadline = $scope.form.car.registration_deadline;
						$scope.form.hull_insurance_deadline = $scope.form.car.hull_insurance_deadline;
						$scope.form.maintenance_dateline = $scope.form.car.maintenance_dateline;
						$scope.form.insurance_deadline = $scope.form.car.insurance_deadline;
						$scope.getPoints(); 
					}
					$scope.getServices();
				}
			}
		}, $scope);
	}
}

$scope.getCar = function() {
	$scope.chooseCar({id: $scope.form.car_id});
}

createCarCallback = function(res) {
	$scope.cars.push(res);
	$scope.chooseCar(res);
}

$scope.getPoints = function() {
	customer_id = $scope.form.customer_id;
	$scope.form.points = '';
	if(customer_id) {
		sendRequest({
			type: "GET",
			url: "/common/customers/" + customer_id + "/getPoints",
			success: function(response) {
				if (response.success) {
					$scope.form.points = response.data;;
				}
			}
		}, $scope);
	}
}

let product_options = {
    title: "Vật tư",
    ajax: {
        url: "{!! route('Product.searchData') !!}",
        data: function (d, context) {
            DATATABLE.mergeSearch(d, context);
            d.status = 1;
        }
    },
    columns: [
        {data: 'DT_RowIndex', orderable: false, title: "STT"},
        {data: 'code', title: "Mã vật tư"},
        {data: 'name', title: "Tên vật tư"},
    ],
    search_columns: [
        {data: 'code', search_type: "text", placeholder: "Mã vật tư"},
        {data: 'name', search_type: "text", placeholder: "Tên vật tư"},
        {
            data: 'product_category_id', search_type: "select", placeholder: "Loại vật tư",
            column_data: @json(\App\Model\Common\ProductCategory::getForSelect())
        }
    ]
};

$scope.searchProduct = new BaseSearchModal(
    product_options,
    function(obj) {
        $scope.chooseProduct(obj);
    }
);

$scope.chooseProduct = function(obj) {
    sendRequest({
        type: 'GET',
        url: `/common/products/${obj.id}/getData`,
        success: function(response) {
            if (response.success) {
                $scope.form.addProduct(response.data);
                toastr.success('Thêm thành công');
                $scope.$applyAsync();
            }
        }
    });
}

let service_options = {
    title: "Tìm kiếm dịch vụ",
    ajax: {
        url: "{!! route('Service.searchDataForBill') !!}",
        data: function (d, context) {
            DATATABLE.mergeSearch(d, context);
            d.vehicle_category_id = $scope.form.vehicle_category_id;
        }
    },
    columns: [
        {data: 'DT_RowIndex', orderable: false, title: "STT"},
        {data: 'name', title: "Tên dịch vụ"},
        {data: 'service_type', orderable: false, title: "Loại dịch vụ"},
        {data: 'group_name', title: "Gói"},
        {data: 'price', title: "Đơn giá"}
    ],
    search_columns: [
        {data: 'name', search_type: "text", placeholder: "Tên dịch vụ"},
        {data: 'code', search_type: "text", placeholder: "Mã dịch vụ"},
        {
            data: 'service_type', search_type: "select", placeholder: "Loại dịch vụ",
            column_data: @json(App\Model\Common\ServiceType::getForSelect())
        },
    ]
};

$scope.searchService = new BaseSearchModal(
    service_options,
    function(obj) {
        $scope.chooseService(obj);
    }
);

$scope.chooseService = function(obj) {
    sendRequest({
        type: 'GET',
        url: `/common/services/getDataForBill?detail_id=${obj.id}`,
        success: function(response) {
            if (response.success) {
            $scope.form.addService(response.data);
            toastr.success('Thêm thành công');
            $scope.$applyAsync();
            } else toastr.warning(response.message);
        }
    });
}

createLicensePlateCallback = (response) => {
    $rootScope.$emit("addLicensePlate", response);
}

createCustomerCallback = (response) => {
    if ($scope.createCustomerType == 'form') {
        if ($scope.form.car) {
            if ($scope.form.car.customers) {
                $scope.form.car.customers.push(response);
            } else {
                $scope.form.car.customers = [response];
            }
        } else {
            $scope.form.car = {
                customers: [response]
            }
        }
        $scope.form.customer_id = response.id;
    } else {
        $rootScope.$emit("addCustomer", response);
    }
}

$(document).on('hide.bs.modal', '#createCustomer', function() {
    $scope.createCustomerType = null;
})

$scope.addCustomerToForm = function() {
    $scope.createCustomerType = 'form';
    $('#createCustomer').modal('show');
}

$scope.filter = {};

$scope.getServices = function() {
	$scope.all_services = [];
	if (!$scope.form.vehicle_category_id) return;
	sendRequest({
        type: "GET",
        url: "{!! route('Service.searchAllForBill') !!}",
		data: {
			vehicle_category_id: $scope.form.vehicle_category_id
		},
        success: function(response) {
            if (response.success) {
                $scope.all_services = response.data;
            }
        }
    }, $scope);
}

$scope.getFilterServices = function() {
    if (!$scope.all_services) return [];
    let result = $scope.all_services;
    if ($scope.fill) {
        if ($scope.fill.service_id) result = result.filter(val => val.service_id == $scope.fill.service_id);
        if ($scope.fill.name) result = result.filter(val => val.name.toLowerCase().includes($scope.fill.name.toLowerCase()) || val.service.name.toLowerCase().includes($scope.fill.name.toLowerCase()));
    }
    return result;
}

let draw = 0;
$scope.getFilterProducts = function() {
    draw++;
	sendRequest({
        type: "GET",
        url: "{!! route('Product.filterDataForBill') !!}",
		data: {
			category_id: $scope.fill.category_id,
            name: $scope.fill.product_name,
            draw: draw
		},
        success: function(response) {
            if (response.success && response.draw == draw) {
                $scope.all_product = response.data;
            }
        }
    }, $scope);
}

$scope.searchPromo = new BaseSearchModal(
    {
		title: "Khuyến mãi",
		ajax: {
			url: "{!! route('PromoCampaign.searchData') !!}",
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
				d.type = 'use';
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT"},
			{data: 'code', title: "Mã"},
			{data: 'name', title: "Tên"},
			{data: 'start_date', title: "Từ ngày"},
			{data: 'end_date', title: "Đến ngày"},
		],
		search_columns: [
			{data: 'code', search_type: "text", placeholder: "Mã"},
			{data: 'name', search_type: "text", placeholder: "Tên"},
		]
	},
    function(obj) {
        $scope.choosePromo(obj);
    }
);

$scope.choosePromo = function(obj) {
    sendRequest({
        type: 'GET',
        url: `/common/promo_campaigns/${obj.id}/getDataForUse`,
        success: function(response) {
            if (response.success) {
                $scope.form.promo = response.data;
                toastr.success('Chọn thành công');
                $scope.$applyAsync();
            }
        }
    });
}

let drawCar = 0;

$scope.searchCar = function(license_plate) {
	drawCar++;
	$.ajax({
		type: 'GET',
		url: "{!! route('Car.searchForSelect') !!}",
		headers: {
			'X-CSRF-TOKEN': CSRF_TOKEN
		},
		data: {
			license_plate,
			draw: drawCar
		},
		success: function(response) {
			if (response.success && response.draw == drawCar) {
				if (response.data) $scope.cars = response.data;
			}
		},
		error: function(e) {
			toastr.error('Đã có lỗi xảy ra');
		},
		complete: function() {
			$scope.$applyAsync();
		}
	});
}
