@extends('layouts.main')

@section('css')
@endsection

@section('title')
Danh mục tài khoản quỹ
@endsection

@section('buttons')
<a href="{{ route('FundAccount.create') }}" class="btn btn-outline-success" data-toggle="modal" href="javascript:void(0)" data-target="#create-fund-account" class="btn btn-info" ng-click="errors = null"><i class="fa fa-plus"></i> Thêm mới</a>
<a href="{{ route('FundAccount.exportExcel') }}" class="btn btn-primary"><i class="fas fa-file-excel"></i> Xuất file excel</a>
<a href="{{ route('FundAccount.create') }}" class="btn btn-primary"><i class="far fa-file-pdf"></i> Xuất file pdf</a>
@endsection
@section('content')
<div ng-cloak>
    <div class="row" ng-controller="FundAccount">
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
                                <h4 class="semi-bold">Sửa tài khoản quỹ</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group custom-group">
                                            <label class="required-label form-label">Loại tài khoản</label>
                                            <select class="form-control" ng-model="form.type">
                                                <option value="">Chọn loại tài khoản</option>
                                                <option value="1">Quỹ tiền mặt</option>
                                                <option value="2">Tài khoản ngân hàng</option>
                                            </select>
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong><% errors.type[0] %></strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                {{-- Tài khoản tiền mặt --}}
                                <div class="row">
                                    <div class="col-md-12 col-sm-12" ng-if="form.type == 1">
                                        <div class="form-group">
                                            <label class="form-label required-label">Tên tài khoản</label>
                                            <input class="form-control" type="text" ng-model="form.name">
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong><% errors.name[0] %></strong>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12" ng-if="form.type == 1 || form.type == 2">
                                        <div class="form-group">
                                            <label class="form-label">Số dư đầu kỳ</label>
                                            <input class="form-control" type="text" ng-model="form.monney">
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong><% errors.monney[0] %></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12" ng-if="form.type == 1 || form.type == 2">
                                        <div class="form-group">
                                            <label class="form-label required-label">Trạng thái</label>
                                            <select class="form-control" name="status" ng-model="form.status">
                                                <option value="">Trạng thái</option>
                                                <option value="1">Hoạt động</option>
                                                <option value="0">Khóa</option>
                                            </select>
                                            <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.status">
                                                <strong><% errors.status[0] %></strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                {{-- Tài khoản ngân hàng --}}
                                <div class="row" ng-if="form.type == 2">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label required-label">Số tài khoản</label>
                                            <input class="form-control" type="text" ng-model="form.acc_num">
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong><% errors.acc_num[0] %></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Chủ tài khoản</label>
                                            <input class="form-control" type="text" ng-model="form.acc_holder">
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong><% errors.acc_holder[0] %></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Ngân hàng</label>
                                            <input class="form-control" type="text" ng-model="form.bank">
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong><% errors.bank[0] %></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Chi nhánh</label>
                                            <input class="form-control" type="text" ng-model="form.branch">
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong><% errors.branch[0] %></strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                {{-- End tài khoản ngân hàng --}}
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Ghi chú</label>
                                            <input class="form-control" type="text" ng-model="form.note">
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong><% errors.note[0] %></strong>
                                            </span>
                                        </div>
                                    </div>
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
    @include('g7.fund_accounts.create_fund_account')
</div>
@endsection

@section('script')
@include('partial.classes.g7.FundAccount')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('FundAccount.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT"},
            {data: 'name', title: 'Tên tài khoản'},
            {data: 'acc_num', title: 'Số tài khoản'},
            {data: 'monney', title: 'Số dư'},
            {data: 'acc_holder', title: 'Chủ tài khoản'},
            {data: 'bank', title: 'Ngân hàng'},
            {
				data: 'status',
				title: "Trạng thái",
				render: function (data) {
					return getStatus(data, @json(App\Model\G7\FundAccount::STATUSES));
				}
			},
			{data: 'updated_by', title: "Người sửa"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: 'name', search_type: "text", placeholder: "Tên tài khoản"},
            {data: 'acc_num', search_type: "text", placeholder: "Số tài khoản"},
			{
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: [{id: 1, name: "Hoạt động"}, {id: 0, name: "Khóa"}]
			}
		],
		search_by_time: false,
	})
    app.controller('FundAccount', function ($scope, $http) {
        $scope.loading = {};
        $('#table-list').on('click', '.edit', function () {
            $scope.data = datatable.getRowData(this, datatable);
            $scope.form = new FundAccount($scope.data, {scope: $scope});
            $scope.errors = null;
            $scope.$apply();
            $('#edit-modal').modal('show');
        });
        // Submit mode mới
        $scope.submit = function() {
            $scope.loading.submit = false;
            $.ajax({
                type: 'POST',
                url: "/g7/fund-accounts/" + $scope.form.id + "/update",
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: $scope.form.submit_data,
                success: function(response) {
                if (response.success) {
                    $('#edit-modal').modal('hide');
                    toastr.success(response.message);
                    if (datatable.datatable) datatable.datatable.ajax.reload();
                    $scope.errors = null;
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
