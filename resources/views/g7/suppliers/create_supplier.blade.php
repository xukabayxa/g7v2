<div class="modal fade" id="create-supplier" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="CreateSupplier">
    <form method="POST" role="form" id="supplier-form">
        @csrf
        <div class="modal-dialog" style="max-width: 650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="semi-bold">Thêm mới Nhà cung cấp</h4>
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
    </form>
    <!-- /.modal-dialog -->
</div>
<script>
    let createSupplierCallBack;
    app.controller('CreateSupplier', function ($scope, $http) {
        $scope.form = new Supplier({}, {scope: $scope});
        $scope.loading = {};
        // Submit Form tạo mới
        $scope.submit = function () {
            let url = "{!! route('Supplier.store') !!}";
            $scope.loading.submit = true;
            $.ajax({
                type: "POST",
                url: url,
                data: $scope.form.submit_data,
                headers: {
                    'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                },
                success: function (response) {
                    if (response.success) {
                        $('#create-supplier').modal('hide');
                        $scope.form = new Supplier({}, {scope: $scope});
                        toastr.success(response.message);
                        if(createSupplierCallBack) createSupplierCallBack(response.data);
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
    })
</script>
