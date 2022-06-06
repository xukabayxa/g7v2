<div class="modal fade" id="create-fund-account" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="CreateFundAccount">
    <form method="POST" role="form" id="fund-account-form">
        @csrf
        <div class="modal-dialog" style="max-width: 650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="semi-bold">Thêm mới tài khoản</h4>
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
    app.controller('CreateFundAccount', function ($scope, $http) {
        $scope.form = new FundAccount({}, {scope: $scope});
        $scope.loading = {};
        // Submit Form tạo mới
        $scope.submit = function () {
            let url = "{!! route('FundAccount.store') !!}";
            $scope.loading.submit = true;
            $.ajax({
                type: "POST",
                url: url,
                data: $scope.form.submit_data,
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function (response) {
                    if (response.success) {
                        $('#create-fund-account').modal('hide');
                        $scope.form = new FundAccount({}, {scope: $scope});
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
    })
</script>