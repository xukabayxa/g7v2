@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý hóa đơn nhập nhập tài sản cố định
@endsection

@section('content')
<div ng-cloak ng-controller="G7FixedAssetImport">
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
    @include('g7.g7_fixed_asset_imports.show')
</div>
@include('g7.funds.payment_vouchers.quick_payment')
@endsection

@section('script')
@include('partial.classes.g7.G7FixedAssetImport')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('G7FixedAssetImport.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {data: 'code', title: 'Mã'},
            {data: 'supplier', title: 'NCC'},
            {data: 'amount', title: 'Tổng tiền'},
            {data: 'vat_cost', title: 'VAT'},
            {data: 'amount_after_vat', title: 'Tổng sau VAT'},
            {data: 'status',title: "Trạng thái"},
            {data: 'created_at', title: 'Ngày tạo'},
			{data: 'created_by', title: "Người tạo"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
            {data: 'code', search_type: "text", placeholder: "Mã phiếu nhập"},
            {
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: @json(\App\Model\G7\G7FixedAssetImport::STATUSES)
			}
		],
		search_by_time: true,
        create_link: "{{ route('G7FixedAssetImport.create') }}"
	}).datatable;

	app.controller('G7FixedAssetImport', function ($rootScope, $scope, $http) {
        $scope.loading = {};
		$scope.form = {};

        // Thanh toán nhanh
		$('#table-list').on('click', '.quick-pay', function () {
            $scope.data = getRowData(this, datatable);

            sendRequest({
                type: "GET",
                url: "/g7/g7_fixed_asset_imports/" + $scope.data.id + "/getDataForShow",
                success: function(response) {
                    if (response.success) {
                        if (response.success) {
                            let data = response.data;
                            data.payment_voucher_type_id = 6;
                            data.recipient_type_id = 3;
                            data.recipient_id = response.data.supplier_id;
                            data.g7_fixed_asset_import_id = data.id;
                            $rootScope.$emit("openQuickPayment", data);
                            $("#quick-payment-voucher").modal('show');
                        } else {
                            toastr.warning(response.message);
                            $scope.errors = response.errors;
                        }
                    }
                }
            }, $scope);

        });

		// Chi tiết phiếu nhập
        $('#table-list').on('click', '.show', function () {
            $scope.data = getRowData(this, datatable);
			sendRequest({
                type: 'GET',
                url: "/g7/g7_fixed_asset_imports/" + $scope.data.id + "/getDataForShow",
                success: function(response) {
					if (response.success) {
						$scope.form = new G7FixedAssetImport(response.data, {});
						$('#show-modal').modal('show');
					} else {
						toastr.warning(response.message);
						$scope.errors = response.errors;
					}
                },
            }, $scope);
        });
    })

</script>
@include('partial.confirm')
@endsection
