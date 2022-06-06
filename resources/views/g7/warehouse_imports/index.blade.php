@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý hóa đơn nhập hàng
@endsection

@section('buttons')
<a href="{{ route('WareHouseImport.create') }}" class="btn btn-outline-success"><i class="fa fa-plus"></i> Thêm mới</a>
<a href="{{ route('WareHouseImport.exportExcel') }}" class="btn btn-primary"><i class="fas fa-file-excel"></i> Xuất file excel</a>
<a href="{{ route('WareHouseImport.create') }}" class="btn btn-primary"><i class="far fa-file-pdf"></i> Xuất file pdf</a>
@endsection

@section('content')
<div ng-cloak ng-controller="WareHouseImportIndex">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table-list">
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Form Show phiếu nhập --}}
    @include('g7.warehouse_imports.show')
    @include('g7.funds.payment_vouchers.quick_payment')
</div>
@endsection

@section('script')
{{-- @include('partial.classes.g7.PaymentVoucher') --}}
@include('partial.classes.g7.WareHouseImport')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('WareHouseImport.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {data: 'code', title: 'Mã'},
            {data: 'supplier', title: 'NCC'},
            {data: 'pay_status', title: 'Thanh toán'},
            {data: 'amount', title: 'Tổng tiền'},
            {data: 'vat', title: 'VAT'},
            {data: 'amount_after_vat', title: 'Tổng sau VAT'},
            {
				data: 'status',
				title: "Trạng thái",
				render: function (data) {
					return getStatus(data, @json(App\Model\G7\WareHouseImport::STATUSES));
				}
			},
            {data: 'created_at', title: 'Ngày tạo'},
			{data: 'created_by', title: "Người tạo"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
            {data: 'code', search_type: "text", placeholder: "Mã phiếu nhập"},
            {data: 'product', search_type: "text", placeholder: "Tên hoặc mã hàng hóa"},
            {
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: @json(\App\Model\G7\WareHouseImport::STATUSES)
			},
            {
                data: 'created_by', search_type: "select", placeholder: "Người lập",
                column_data: USERS
            },
            {
                data: 'supplier', search_type: "select", placeholder: "Nhà cung cấp",
                column_data: SUPPLIER
            },
		],
		search_by_time: true,
	}).datatable

    createQuickPaymentCallback = (response) => {
        datatable.ajax.reload();
    }

	app.controller('WareHouseImportIndex', function ($rootScope, $scope, $http) {
        $scope.loading = {};
		$scope.form = {};
		// Thanh toán nhanh
		$('#table-list').on('click', '.quick-pay', function () {
            $scope.data = getRowData(this, datatable);
			$.ajax({
                type: 'GET',
                url: "/g7/warehouse-imports/" + $scope.data.id + "/payment",
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: $scope.data.id,
                success: function(response) {
                if (response.success) {

                    let data = response.data;
                    data.payment_voucher_type_id = 1;
                    data.recipient_type_id = 3;
                    data.recipient_id = response.data.supplier_id;
                    data.ware_house_import_id = response.data.id;
                    $rootScope.$emit("openQuickPayment", data);
                    $("#quick-payment-voucher").modal('show');
                } else {
                    toastr.warning(response.message);
                    $scope.errors = response.errors;
                }
                },
                error: function(e) {
                    toastr.error('Đã có lỗi xảy ra');
                },
                complete: function() {
                    $scope.loading.submit = false;
                    $scope.$applyAsync();
                }
            });
        });

		// Chi tiết phiếu nhập
        $('#table-list').on('click', '.show', function () {
            $scope.data = getRowData(this, datatable);
			$.ajax({
                type: 'GET',
                url: "/g7/warehouse-imports/" + $scope.data.id + "/show",
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: $scope.data.id,
                success: function(response) {
                if (response.success) {
					$scope.form.data = response.data;
                    $('#show-modal').modal('show');
                } else {
                    toastr.warning(response.message);
                    $scope.errors = response.errors;
                }
                },
                error: function(e) {
                    toastr.error('Đã có lỗi xảy ra');
                },
                complete: function() {
                    $scope.loading.submit = false;
                    $scope.$applyAsync();
                }
            });
        });
    })

</script>
@include('partial.confirm')
@endsection
