@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý phiếu thu
@endsection

@section('buttons')
<a href="{{ route('ReceiptVoucher.create') }}" class="btn btn-outline-success" data-toggle="modal" href="javascript:void(0)" data-target="#create-receipt-voucher" class="btn btn-info" ng-click="errors = null"><i class="fa fa-plus"></i> Thêm mới</a>
<a href="{{ route('ReceiptVoucher.exportExcel') }}" class="btn btn-primary"><i class="fas fa-file-excel"></i> Xuất file excel</a>
<a href="{{ route('ReceiptVoucher.create') }}" class="btn btn-primary"><i class="far fa-file-pdf"></i> Xuất file pdf</a>
@endsection
@section('content')
<div ng-cloak>
    <div class="row" ng-controller="ReceiptVoucher">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table-list">
                    </table>
                </div>
            </div>
        </div>
        @include('g7.funds.receipt_vouchers.show')
    </div>
    {{-- Form tạo mới --}}
    @include('g7.funds.receipt_vouchers.create_receipt_voucher')

</div>
@endsection

@section('script')
@include('partial.classes.g7.ReceiptVoucher')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('ReceiptVoucher.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {data: 'code', title: 'Mã phiếu'},
            {data: 'value', title: 'Giá trị'},
            {data: 'payer_type_id', title: 'Đối tượng'},
            {data: 'payer_name', title: 'Người nộp phí'},
            {
                data: 'record_date',
                title: 'Ngày ghi nhận',
                render: function (data) {
                    return dateGetter(data, 'YYYY-MM-DD HH:mm', "HH:mm DD/MM/YYYY")
                }
            },
            {
				data: 'status',
				title: "Trạng thái",
				render: function (data) {
					return getStatus(data, @json(App\Model\G7\ReceiptVoucher::STATUSES));
				}
			},
			{data: 'updated_by', title: "Người sửa"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: 'code', search_type: "text", placeholder: "Mã phiếu"},
			{
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: @json(App\Model\G7\ReceiptVoucher::STATUSES)
			},
            {
                data: "object", search_type: "select", placeholder: "Đối tượng",
                column_data: @json(App\Model\G7\ReceiptVoucher::PAYER_TYPES)
            },

		],
		search_by_time: true,
	}).datatable;

    createQuickReceiptCallback = (response) => {
        datatable.ajax.reload();
    }
    app.controller('ReceiptVoucher', function ($scope, $http) {
        $scope.types = @json(App\Model\G7\ReceiptVoucherType::getForSelect());
        $scope.loading = {};
        $scope.form = {}
        // show phiếu chi
        $('#table-list').on('click', '.show', function () {
            $scope.data = getRowData(this, datatable);
			$.ajax({
                type: 'GET',
                url: "/g7/funds/receipt-vouchers/" + $scope.data.id + "/show",
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: $scope.data.id,
                success: function(response) {
                if (response.success) {
					$scope.form.data = response.data;
                    $scope.form.payer_type_name = response.payer_type_name;
                    console.log($scope.form);
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
