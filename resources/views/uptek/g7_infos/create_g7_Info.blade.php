<div class="modal fade" id="create-g7-info" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="createG7Info">
    <form method="POST" role="form" id="createCustomerForm">
        @csrf
        <div class="modal-dialog" style="max-width: 960px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="semi-bold">Thêm mới hồ sơ Gara</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 col-sm-12">
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

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group custom-group">
                                        <label class="form-label required-label">Số điện thoại</label>
                                        <input class="form-control" type="text" ng-model="form.mobile">
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong><% errors.mobile[0] %></strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group custom-group">
                                        <label class="form-label">Email</label>
                                        <input class="form-control" type="text" ng-model="form.email">
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong><% errors.email[0] %></strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group custom-group">
                                        <label class="form-label required-label">Tỉnh</label>
                                        <select class="form-control" select2 name="province_id" ng-change="getDistricts(form.province_id, form, '#create_district_id')" ng-model="form.province_id" id="create_province_id">
                                            <option value="">Chọn tỉnh</option>
                                            <option ng-repeat="p in form.provinces" ng-value="p.id"><% p.name_with_type %></option>
                                        </select>
                                        <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.province_id">
                                            <strong><% errors.province_id[0] %></strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group custom-group">
                                        <label class="form-label required-label">Huyện</label>
                                        <select class="form-control" select2 name="district_id" ng-change="getWards(form.district_id, form, '#create_ward_id')" id="create_district_id" ng-model="form.district_id">
                                            <option value="">Chọn huyện</option>
                                            <option ng-repeat="d in districts[form.province_id]" ng-value="d.id"><% d.name_with_type %></option>
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
                                        <select class="form-control" name="ward_id" select2 ng-model="form.ward_id" id="create_ward_id">
                                            <option value="">Chọn xã</option>
                                            <option ng-repeat="w in wards[form.district_id]" ng-value="w.id"><% w.name_with_type %></option>
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
                                        <input class="form-control" type="text" ng-model="form.adress" placeholder="Địa chỉ">
                                        <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.adress">
                                            <strong><% errors.adress[0] %></strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group custom-group">
                                        <label class="form-label required-label">Trạng thái</label>
                                        <select class="form-control" select2 style="width: 100%;" ng-model="form.status">
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
                                        <textarea id="my-textarea" class="form-control" ng-model="form.note" rows="3"></textarea>
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
                                    <img class="thumbnail img-preview" ng-src="<% form.image.path %>">
                                </div>
                                <div class="input-group" style="width: 100%; text-align: center">
                                    <div class="input-group-btn" style="margin: 0 auto">
                                        <div class="fileUpload fake-shadow cursor-pointer">
                                            <label class="mb-0" for="<% form.image.element_id %>">
                                                <i class="glyphicon glyphicon-upload"></i> Chọn ảnh
                                            </label>
                                            <input class="d-none" id="<% form.image.element_id %>" type="file" class="attachment_upload" accept=".jpg,.jpeg,.png">
                                        </div>
                                    </div>
                                </div>
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong><% errors.image[0] %></strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
                        <i ng-if="!loading.submit" class="fa fa-save"></i>
                        <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
                        Lưu
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Hủy</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>
<script>
    app.controller('createG7Info', function ($scope, $http) {
        $scope.form = new G7Info({}, {scope: $scope});
        $scope.loading = {};
        // Submit Form tạo mới
        $scope.submit = function () {
            let url = "{!! route('G7Info.store') !!}";
            $scope.loading.submit = true;
            $.ajax({
                type: "POST",
                url: url,
                data: $scope.form.submit_data,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function (response) {
                    if (response.success) {
                        $('#create-g7-info').modal('hide');
                        $scope.form = new G7Info({}, {scope: $scope});
                        toastr.success(response.message);
                        if (datatable.datatable) datatable.datatable.ajax.reload();
                        $scope.errors = null;
                    } else {
                        $scope.errors = response.errors;
                        toastr.warning(response.message);
                    }
                },
                error: function () {
                    toastr.error('Đã có lỗi xảy ra');
                },
                complete: function () {
                    $scope.loading.submit = false;
                    $scope.$applyAsync();
                },
            });
        }

        @include('partial.modal.locationJs')
    })
</script>