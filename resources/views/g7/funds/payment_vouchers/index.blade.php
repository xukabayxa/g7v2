@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý phiếu chi
@endsection

@section('buttons')
<a href="{{ route('PaymentVoucher.create') }}" class="btn btn-outline-success" data-toggle="modal" href="javascript:void(0)" data-target="#create-payment-voucher" class="btn btn-info" ng-click="errors = null"><i class="fa fa-plus"></i> Thêm mới</a>
<a href="{{ route('PaymentVoucher.exportExcel') }}" class="btn btn-primary"><i class="fas fa-file-excel"></i> Xuất file excel</a>
<a href="{{ route('PaymentVoucher.create') }}" class="btn btn-primary"><i class="far fa-file-pdf"></i> Xuất file pdf</a>
@endsection
@section('content')
<div ng-cloak>
    <div class="row" ng-controller="PaymentVoucher">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table-list">
                    </table>
                </div>
            </div>
        </div>
        @include('g7.funds.payment_vouchers.show')
    </div>
    {{-- Form tạo mới --}}
    @include('g7.funds.payment_vouchers.create_payment_voucher')

</div>
@endsection

@section('script')
@include('partial.classes.g7.PaymentVoucher')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('PaymentVoucher.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {data: 'code', title: 'Mã phiếu'},
            {data: 'value', title: 'Giá trị'},
            {data: 'payment_voucher_type_id', title: 'Loại phiếu'},
            {data: 'recipient_type_id', title: 'Đối tượng'},
            {data: 'recipient_name', title: 'Người nhận phí'},
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
					return getStatus(data, @json(App\Model\G7\PaymentVoucher::STATUSES));
				}
			},
			{data: 'updated_by', title: "Người sửa"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: 'code', search_type: "text", placeholder: "Mã phiếu"},
			{
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: @json(App\Model\G7\PaymentVoucher::STATUSES)
			},
            {
                data: "payment_voucher_type", search_type: "select", placeholder: "Loại phiếu",
                column_data: @json(App\Model\G7\PaymentVoucherType::getForSelect())
            },
            {
                data: "object", search_type: "select", placeholder: "Đối tượng",
                column_data: @json(App\Model\G7\ReceiptVoucher::PAYER_TYPES)
            },
            {
                data: "payer_name", search_type: "select", placeholder: "Người nhận phí",
                column_data: []
            },
            {
                data: 'updated_by', search_type: "select", placeholder: "Người sửa",
                column_data: USERS
            },
		],
		search_by_time: true,
	}).datatable;

    createQuickPaymentCallback = (response) => {
        datatable.ajax.reload();
    }

    app.controller('PaymentVoucher', function ($scope, $http) {
        $scope.types = @json(App\Model\G7\PaymentVoucherType::getForSelect());
        $scope.loading = {};
        $scope.form = {}
        // show phiếu chi
        $('#table-list').on('click', '.show', function () {
            $scope.data = getRowData(this, datatable);
            sendRequest({
                type: "GET",
                url: "/g7/funds/payment-vouchers/" + $scope.data.id + "/show",
                success: function(response) {
                    if (response.success) {
                        $scope.form = response.data;
                        console.log($scope.form);
                        $scope.form.recipient_type_name = response.recipient_type_name;
                        $('#show-modal').modal('show');
                    }
                }
            }, $scope);
        });
    })
</script>
@include('partial.confirm')
@endsection
