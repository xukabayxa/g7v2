<div class="modal fade" id="create-payment-voucher" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="CreatePaymentVoucher">
    <div class="modal-dialog" style="max-width: 850px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="semi-bold">Tạo phiếu chi</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="required-label">Loại phiếu</label>
                                    <ui-select class="" remove-selected="false" ng-model="form.payment_voucher_type_id">
                                        <ui-select-match placeholder="Chọn loại phiếu chi">
                                            <% $select.selected.name %>
                                        </ui-select-match>
                                        <ui-select-choices repeat="t.id as t in (types | filter: $select.search)">
                                            <span ng-bind="t.name"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.payment_voucher_type_id[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-12" ng-if="form.payment_voucher_type_id == 1">
                                <div class="form-group custom-group">
                                    <label class="required-label">Nhà cung cấp</label>
                                    <ui-select class="" remove-selected="false" ng-model="form.supplier_id" ng-change="getWarehouseImports()">
                                        <ui-select-match placeholder="Chọn Nhà cung cấp">
                                            <% $select.selected.name %>
                                        </ui-select-match>
                                        <ui-select-choices repeat="s.id as s in (form.suppliers | filter: $select.search)">
                                            <span ng-bind="s.name"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.supplier_id[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-12" ng-if="form.payment_voucher_type_id == 1">
                                <div class="form-group custom-group">
                                    <label class="required-label">Hóa đơn nhập</label>
                                    <ui-select class="" remove-selected="false" ng-model="form.ware_house_import_id">
                                        <ui-select-match placeholder="Chọn hóa đơn nhập">
                                            <% $select.selected.code %>
                                        </ui-select-match>
                                        <ui-select-choices repeat="w.id as w in (form.warehouse_imports | filter: $select.search)">
                                            <span ng-bind="w.code"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.ware_house_import_id[0] %></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="required-label">Ngày ghi nhận</label>
                                    <input class="form-control " datetime-form type="text" ng-model="form.record_date">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.record_date[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="required-label">Đối tượng nhận phí</label>
                                    <ui-select class="" remove-selected="false" ng-model="form.recipient_type_id" ng-change="getRecipient()">
                                        <ui-select-match placeholder="Đố    i tượng nhận phí">
                                            <% $select.selected.name %>
                                        </ui-select-match>
                                        <ui-select-choices repeat="t.id as t in (form.recipient_types | filter: $select.search)">
                                            <span ng-bind="t.name"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.recipient_type_id[0] %></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-xs-12" ng-if="(form.recipient_type_id == 1 || form.recipient_type_id == 2 || form.recipient_type_id == 3)">
                                <div class="form-group custom-group">
                                    <label class="required-label">Người nhận</label>
                                    <ui-select class="" remove-selected="false" ng-model="form.recipient_id">
                                        <ui-select-match placeholder="Người nhận phí">
                                            <% $select.selected.name %>
                                        </ui-select-match>
                                        <ui-select-choices repeat="r.id as r in (form.recipients | filter: $select.search)">
                                            <span ng-bind="r.name"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.recipient_id[0] %></strong>
                                    </span>

                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12" ng-if="(form.recipient_type_id == 4)">
                                <div class="form-group custom-group">
                                    <label class="form-label required-label">Nhập người nhận phí</label>
                                    <input class="form-control" type="text" ng-model="form.recipient_name">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.recipient_name[0] %></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="form-label required-label">Số tiền</label>
                                    <input class="form-control" type="text" ng-model="form.value">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.value[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="form-label required-label">Hình thức thanh toán</label>
                                    <select class="form-control custom-select" style="width: 100%;" ng-model="form.pay_type">
                                        <option value="1">Tiền mặt</option>
                                        <option value="2">Chuyển khoản</option>
                                    </select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.pay_type[0] %></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12" ng-if="form.payment_voucher_type_id == 5">
                                <div class="form-group custom-group">
                                    <label class="form-label required-label">Số tháng phân bổ</label>
                                    <input class="form-control" type="text" ng-model="form.month">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.month[0] %></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="form-label">Ghi chú</label>
                                    <input class="form-control" type="text" ng-model="form.note">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.note[0] %></strong>
                                    </span>
                                </div>
                            </div>

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
    app.controller('CreatePaymentVoucher', function ($scope, $http) {
        $scope.form = new PaymentVoucher({}, {scope: $scope});
        $scope.types = @json(App\Model\G7\PaymentVoucherType::getForSelect());
        $scope.loading = {};
        @include('g7.funds.payment_vouchers.formJs');
        // Submit Form tạo mới
        $scope.submit = function () {
            let url = "{!! route('PaymentVoucher.store') !!}";;
            $scope.loading.submit = true;
            // return 0;
            $.ajax({
                type: "POST",
                url: url,
                data: $scope.form.submit_data,
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function (response) {
                    if (response.success) {
                        $('#create-payment-voucher').modal('hide');
                        $scope.form = new PaymentVoucher({}, {scope: $scope});
                        toastr.success(response.message);
                        if (datatable) datatable.ajax.reload();
                        $scope.errors = null;
                    } else {
                        $scope.errors = response.errors;
                        console.log( $scope.errors)
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
