@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý hồ sơ Gara
@endsection

@section('buttons')
<a href="javascript:void(0)p" class="btn btn-outline-success" data-toggle="modal" href="javascript:void(0)" data-target="#create-g7-info" class="btn btn-info" ng-click="errors = null"><i class="fa fa-plus"></i> Thêm mới</a>
<a href="{{ route('G7Info.exportExcel') }}" class="btn btn-primary"><i class="fas fa-file-excel"></i> Xuất file excel</a>
<a href="{{ route('G7Info.exportPDF') }}" class="btn btn-warning"><i class="far fa-file-pdf"></i> Xuất file pdf</a>
@endsection
@section('content')
<div ng-cloak>
    <div class="row" ng-controller="G7Info">
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
                    <div class="modal-dialog" style="max-width: 850px">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="semi-bold">Sửa hồ sơ gara</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group custom-group">
                                                    <label class="form-label required-label">Tên</label>
                                                    <input class="form-control" type="text" ng-model="formEdit.name">
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong><% errors.name[0] %></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group custom-group">
                                                    <label class="form-label required-label">Số điện thoại</label>
                                                    <input class="form-control" type="text" ng-model="formEdit.mobile">
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong><% errors.mobile[0] %></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group custom-group">
                                                    <label class="form-label">Email</label>
                                                    <input class="form-control" type="text" ng-model="formEdit.email">
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong><% errors.email[0] %></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group custom-group">
                                                    <label class="form-label required-label">Tỉnh</label>
                                                    <select class="form-control" select2 name="province_id" ng-change="getDistricts(formEdit.province_id, formEdit, '#edit_district_id')" ng-model="formEdit.province_id" id="edit_province_id">
                                                        <option value="">Chọn tỉnh</option>
                                                        <option ng-repeat="p in formEdit.provinces" ng-value="p.id" ng-selected="formEdit.province_id == p.id"><% p.name_with_type %></option>
                                                    </select>
                                                    <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.province_id">
                                                        <strong><% errors.province_id[0] %></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group custom-group">
                                                    <label class="form-label required-label">Huyện</label>
                                                    <select class="form-control" select2 name="district_id" ng-change="getWards(formEdit.district_id, formEdit, '#edit_ward_id')" id="edit_district_id" ng-model="formEdit.district_id">
                                                        <option value="">Chọn huyện</option>
                                                        <option ng-repeat="d in districts[formEdit.province_id]" ng-value="d.id" ng-selected="formEdit.district_id == d.id"><% d.name_with_type %></option>
                                                        <option ng-if="data_loading.districts" disabled>
                                                            Đang tải...
                                                        </option>
                                                    </select>
                                                    <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.district_id">
                                                        <strong><% errors.district_id[0] %></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group custom-group">
                                                    <label class="form-label required-label">Xã</label>
                                                    <select class="form-control" select2 ng-model="formEdit.ward_id" id="edit_ward_id">
                                                        <option value="">Chọn xã</option>
                                                        <option ng-repeat="w in wards[formEdit.district_id]" ng-value="w.id" ng-selected="formEdit.ward_id == w.id"><% w.name_with_type %></option>
                                                        <option ng-if="data_loading.wards" disabled>
                                                            Đang tải...
                                                        </option>
                                                    </select>
                                                    <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.ward_id">
                                                        <strong><% errors.ward_id[0] %></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group custom-group">
                                                    <label class="form-label">Địa chỉ</label>
                                                    <input class="form-control" type="text" ng-model="formEdit.adress" placeholder="Địa chỉ">
                                                    <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.adress">
                                                        <strong><% errors.adress[0] %></strong>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group custom-group">
                                                    <label class="form-label required-label">Trạng thái</label>
                                                    <select class="form-control" select2 style="width: 100%;" ng-model="formEdit.status">
                                                        <option value="">Trạng thái</option>
                                                        <option value="1">Hoạt động</option>
                                                        <option value="0">Khóa</option>
                                                    </select>
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong><% errors.status[0] %></strong>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group custom-group">
                                                    <label class="form-label">Ghi chú</label>
                                                    <textarea id="my-textarea" class="form-control" ng-model="formEdit.note" rows="3"></textarea>
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong><% errors.note[0] %></strong>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group text-center">
                                            <div class="main-img-preview">
                                                <p class="help-block-img">* Ảnh định dạng: jpg, png không quá 2MB.</p>
                                                <img class="thumbnail img-preview" ng-src="<% formEdit.image.path %>">
                                            </div>
                                            <div class="input-group" style="width: 100%; text-align: center">
                                                <div class="input-group-btn" style="margin: 0 auto">
                                                    <div class="fileUpload fake-shadow cursor-pointer">
                                                        <label class="mb-0" for="<% formEdit.image.element_id %>">
                                                            <i class="glyphicon glyphicon-upload"></i> Chọn ảnh
                                                        </label>
                                                        <input class="d-none" id="<% formEdit.image.element_id %>" type="file" class="attachment_upload" accept=".jpg,.jpeg,.png">
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong><% errors.image[0] %></strong>
                                            </span>
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
    @include('uptek.g7_infos.create_g7_info')
</div>
@endsection

@section('script')
@include('partial.classes.uptek.G7Info')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('G7Info.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {
                data: 'image', title: "Hình ảnh", orderable: false, className: "text-center",
                render: function (data) {
					return `<img src="${data.path}" style="max-width: 55px !important">`;
				}
            },
            {data: 'name', title: 'Tên'},
            {data: 'mobile', title: 'Điện thoại'},
            {data: 'full_adress', title: 'Địa chỉ'},
            {
				data: 'status',
				title: "Trạng thái",
				render: function (data) {
					return getStatus(data, @json(App\Model\Uptek\G7Info::STATUSES));
				}
			},
			{data: 'updated_by', title: "Người sửa"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: 'name', search_type: "text", placeholder: "Tên Gara"},
            {data: 'mobile', search_type: "text", placeholder: "Số điện thoại"},
			{
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: @json(App\Model\Uptek\G7Info::STATUSES)
			}
		],
		search_by_time: false,
	}).datatable;
    app.controller('G7Info', function ($scope, $http) {
        $scope.loading = {};
        $('#table-list').on('click', '.edit', function () {
            $scope.data = getRowData(this, datatable);
            $scope.formEdit = new G7Info($scope.data, {scope: $scope});
            if ($scope.formEdit && $scope.formEdit.province_id) {
                var url = "/locations/" + $scope.formEdit.province_id + "/districts";
                $scope.data_loading.districts = true;
                $.get(url, function(response) {
                    if (response.success) {
                        $scope.districts[$scope.formEdit.province_id] = response.data;
                        $scope.data_loading.districts = false;
                        $scope.$apply();
                    }
                });
            };
            if ($scope.formEdit && $scope.formEdit.district_id) {
                var url = "/locations/" + $scope.formEdit.district_id + "/wards";
                $scope.data_loading.wards = true;
                $.get(url, function(response) {
                    if (response.success) {
                        $scope.wards[$scope.formEdit.district_id] = response.data;
                        $scope.data_loading.wards = false;
                        $scope.$apply();
                    }
                });
            };
            $scope.errors = null;
            $scope.$apply();
            $('#edit-modal').modal('show');
        });
        // Submit mode mới
        $scope.submit = function() {
            $scope.loading.submit = false;
            $.ajax({
                type: 'POST',
                url: "/common/g7-infos/" + $scope.formEdit.id + "/update",
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                processData: false,
                contentType: false,
                data: $scope.formEdit.submit_data,
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
        @include('partial.modal.locationJs')
    })
</script>
@include('partial.confirm')
@endsection
