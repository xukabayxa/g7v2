@extends('layouts.main')

@section('css')
@endsection

@section('title')
Danh mục Nhà cung cấp
@endsection

@section('buttons')
<a href="javascript:void(0)" class="btn btn-outline-success" data-toggle="modal" href="javascript:void(0)" data-target="#create-supplier" class="btn btn-info" ng-click="errors = null"><i class="fa fa-plus"></i> Thêm mới</a>
<a href="javascript:void(0)" target="_blank" data-href="{{ route('Supplier.exportExcel') }}" class="btn btn-info export-button"><i class="fas fa-file-excel"></i> Xuất file excel</a>
<a href="javascript:void(0)" target="_blank" data-href="{{ route('Supplier.exportPDF') }}" class="btn btn-warning export-button"><i class="far fa-file-pdf"></i> Xuất file pdf</a>
@endsection
@section('content')
<div ng-cloak>
    <div class="row" ng-controller="Supplier">
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
                                <h4 class="semi-bold">Sửa nhà cung cấp</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group custom-group">
                                            <label class="form-label required-label">Tên</label>
                                            <input class="form-control" type="text" ng-model="form.name">
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong><% errors.name[0] %></strong>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group custom-group">
                                            <label class="form-label required-label">Số điện thoại</label>
                                            <input class="form-control" type="text" ng-model="form.mobile">
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong><% errors.mobile[0] %></strong>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group custom-group">
                                            <label class="form-label">Địa chỉ</label>
                                            <input class="form-control" type="text" ng-model="form.address">
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong><% errors.address[0] %></strong>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group custom-group">
                                            <label class="form-label required-label">Trạng thái</label>
                                            <select class="form-control custom-select" name="status" ng-model="form.status">
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
            {{-- Form show --}}
            @include('g7.suppliers.show')
        </div>
    </div>
    {{-- Form tạo mới --}}
    @include('g7.suppliers.create_supplier')
</div>
@endsection

@section('script')
@include('partial.classes.g7.Supplier')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('Supplier.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT"},
			{data: 'code', orderable: false, title: "Mã"},
            {data: 'name', title: 'Tên'},
            {data: 'mobile', title: 'Số điện thoại'},
            {data: 'address', title: 'Địa chỉ'},
            {
				data: 'status',
				title: "Trạng thái",
				render: function (data) {
					return getStatus(data, @json(App\Model\G7\Supplier::STATUSES));
				}
			},
			{data: 'updated_by', title: "Người tạo"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: 'name', search_type: "text", placeholder: "Tên"},
            {data: 'mobile', search_type: "text", placeholder: "Số điện thoại"},
            {
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: @json(\App\Model\G7\Supplier::STATUSES)
			}
		],
		search_by_time: false,
	}).datatable;

    createSupplierCallBack = (response) => {
        datatable.ajax.reload();
    }

    app.controller('Supplier', function ($scope, $http) {
        $scope.loading = {};
        // Chi tiết NCC
        $('#table-list').on('click', '.show', function () {
            $scope.data = datatable.row($(this).parents('tr')).data();sendRequest({
                type: "GET",
                url: "/g7/suppliers/"+$scope.data.id+"/getDataForEdit",
                success: function(response) {
                    if (response.success) {
                        $scope.form = new Supplier(response.data, {scope: $scope});
                        $scope.errors = null;
                        $scope.$apply();
                        $('#show-modal').modal('show');
                    }
                }
            }, $scope);

        });
        // Sửa NCC
        $('#table-list').on('click', '.edit', function () {
            $scope.data = datatable.row($(this).parents('tr')).data();

            sendRequest({
                type: "GET",
                url: "/g7/suppliers/"+$scope.data.id+"/getDataForEdit",
                success: function(response) {
                    if (response.success) {
                        $scope.form = new Supplier($scope.data, {scope: $scope});
                            $scope.errors = null;
                            $scope.$apply();
                            $('#edit-modal').modal('show');
                        }
                }
            }, $scope);


        });
        // Submit mode mới
        $scope.submit = function() {
            $scope.loading.submit = false;
            $.ajax({
                type: 'POST',
                url: "/g7/suppliers/" + $scope.form.id + "/update",
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: $scope.form.submit_data,
                success: function(response) {
                if (response.success) {
                    $('#edit-modal').modal('hide');
                    toastr.success(response.message);
                    if (datatable) datatable.ajax.reload();
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

    $(document).on('click', '.export-button', function(event) {
        event.preventDefault();
        let data = {};
        mergeSearch(data, datatable.context[0]);
        window.location.href = $(this).data('href') + "?" + $.param(data);
    })
</script>
@include('partial.confirm')
@endsection
