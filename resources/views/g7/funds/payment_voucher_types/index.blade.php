@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý loại phiếu chi
@endsection

@section('buttons')
<a href="{{ route('PaymentVoucherType.create') }}" class="btn btn-outline-success" data-toggle="modal" href="javascript:void(0)" data-target="#create-payment-voucher-type" class="btn btn-info" ng-click="errors = null"><i class="fa fa-plus"></i> Thêm mới</a>
<a href="{{ route('PaymentVoucherType.exportExcel') }}" class="btn btn-primary"><i class="fas fa-file-excel"></i> Xuất file excel</a>
<a href="{{ route('PaymentVoucherType.create') }}" class="btn btn-primary"><i class="far fa-file-pdf"></i> Xuất file pdf</a>
@endsection
@section('content')
<div ng-cloak>
    <div class="row" ng-controller="PaymentVoucherType">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table-list">
                    </table>
                </div>
            </div>
            {{-- Form sửa --}}
            <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <form method="POST" role="form" id="edit-modal-form">
                    @csrf
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="semi-bold">Sửa loại phiếu chi</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group custom-group">
                                    <label class="form-label required-label">Tên</label>
                                    <input class="form-control" type="text" ng-model="form.name">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.name[0] %></strong>
                                    </span>
                                </div>

                                <div class="form-group custom-group">
                                    <label class="required-label form-label">Trạng thái</label>
                                    <select class="form-control custom-select" ng-model="form.status">
                                        <option value="">Trạng thái</option>
                                        <option value="1">Hoạt động</option>
                                        <option value="0">Khóa</option>
                                    </select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.status[0] %></strong>
                                    </span>
                                </div>

                                <div class="form-group custom-group">
                                    <label class="form-label">Ghi chú</label>
                                    <textarea id="my-textarea" class="form-control" name="" rows="5" ng-model="form.note"></textarea>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.note[0] %></strong>
                                    </span>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
                                    <i ng-if="!loading.submit" class="fa fa-save"></i>
                                    <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
                                    Lưu
                                </button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Hủy</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Form tạo mới --}}
    @include('g7.funds.payment_voucher_types.create_payment_voucher_type')
</div>
@endsection

@section('script')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('PaymentVoucherType.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT"},
            {data: 'name', title: 'Tên'},
            {
				data: 'status',
				title: "Trạng thái",
				render: function (data) {
					return getStatus(data, @json(App\Model\Common\LicensePlate::STATUSES));
				}
			},
			{data: 'updated_by', title: "Người tạo"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: 'name', search_type: "text", placeholder: "Tên"},
			{
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: [{id: 1, name: "Hoạt động"}, {id: 0, name: "Khóa"}]
			}
		],
		search_by_time: false,
	})
    app.controller('PaymentVoucherType', function ($scope, $http) {
        $scope.form = {};
        $scope.loading = {};

        $('#table-list').on('click', '.edit', function () {
            $scope.form = datatable.getRowData(this, datatable);
            $scope.errors = null;
            $scope.$apply();
            $('#edit-modal').modal('show');
        });
        // Submit mode mới
        $scope.submit = function() {
            $scope.loading.submit = true;
            let url = "/g7/funds/payment-voucher-types/" + $scope.form.id + "/update";
            let data = $scope.form;
            $.ajax({
                type: 'POST',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: data,
                success: function(response) {
                    if (response.success) {
                        $('#edit-modal').modal('hide');
                        datatable.datatable.ajax.reload();

                        toastr.success(response.message);
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
        }
    })
</script>
@include('partial.confirm')
@endsection
