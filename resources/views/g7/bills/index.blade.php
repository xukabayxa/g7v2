@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý hóa đơn
@endsection

@section('buttons')
@endsection

@section('content')
<div ng-cloak ng-controller="Bill">
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
    @include('g7.funds.receipt_vouchers.quick_receipt')
</div>
@include('g7.bills.show')

@endsection

@section('script')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('Bill.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {data: 'code', title: 'Số hóa đơn'},
			{data: 'license_plate', title: "Biển số xe"},
			{data: 'customer_name', title: "Khách hàng"},
			{data: 'cost_after_vat', title: 'Tổng thanh toán'},
			{data: 'pay_status', title: 'Thanh toán'},
			{data: 'created_by', title: "Người lập"},
			{data: 'bill_date', title: "Thời gian ghi nhận"},
			{data: 'status', title: "Trạng thái"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
            {data: 'code', search_type: "text", placeholder: "Số hóa đơn"},
			{data: 'license_plate', search_type: "text", placeholder: "Biển số xe"},
			{data: 'customer_name', search_type: "text", placeholder: "Khách hàng"},
            {
				data: 'created_by', search_type: "select", placeholder: "Người lập",
				column_data: USERS
			},
			{
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: @json(\App\Model\G7\Bill::STATUSES)
			}
		],
		create_link: "{{ route('Bill.create') }}"
	}).datatable;

	createQuickReceiptCallback = (response) => {
        datatable.ajax.reload();

    }

    app.controller('Bill', function ($scope, $rootScope, $http) {
        $scope.loading = {};
		$scope.form = {};
		// Thanh toán nhanh
		$('#table-list').on('click', '.quick-receipt', function () {
            $scope.data = getRowData(this, datatable);
			$.ajax({
                type: 'GET',
                url: "/g7/bills/" + $scope.data.id + "/receipt",
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: $scope.data.id,
                success: function(response) {
                if (response.success) {
                    let data = response.data;
                    data.receipt_voucher_type_id = 1;
                    data.payer_type_id = 1;
                    data.payer_id = response.data.customer_id;
                    data.bill_id = response.data.id;
                    console.log(data);
                    $rootScope.$emit("openQuickReceipt", data);
                    $("#quick-receipt-voucher").modal('show');
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

        $scope.showBillDetail = function(obj) {
            sendRequest({
                type: 'GET',
                url: "/g7/bills/" + obj.id + "/getDataForShow",
                success: function(response) {
                    if (response.success) {
                        $('#show-modal').modal('show');
                        let data = response.data;
                        $rootScope.$emit("openShowBill", data);
                        $scope.$applyAsync();
                    }
                }
            });
        }

		// Chi tiết hóa đơn bán
        $('#table-list').on('click', '.show', function () {
            $scope.data = getRowData(this, datatable);
            $scope.showBillDetail({id: $scope.data.id});
        });

        if (getParam('bill_id')) {
            $scope.showBillDetail({id: getParam('bill_id')});
        }
    })

</script>
@include('partial.confirm')
@endsection
