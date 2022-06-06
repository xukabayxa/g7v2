<div class="modal fade" id="create-receipt-voucher" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="CreateReceiptVoucher">
    <div class="modal-dialog" style="max-width: 850px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="semi-bold">Tạo phiếu thu</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="required-label">Loại phiếu</label>
                                    <ui-select class="" remove-selected="false" ng-model="form.receipt_voucher_type_id">
                                        <ui-select-match placeholder="Chọn loại phiếu thu">
                                            <% $select.selected.name %>
                                        </ui-select-match>
                                        <ui-select-choices repeat="t.id as t in (types | filter: $select.search)">
                                            <span ng-bind="t.name"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.record_date[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-12" ng-if="form.receipt_voucher_type_id == 1">
                                <div class="form-group custom-group">
                                    <label class="required-label">Khách hàng</label>
                                    <ui-select class="" remove-selected="false" ng-model="form.customer_id" ng-change="getBills()">
                                        <ui-select-match placeholder="Chọn khách hàng">
                                            <% $select.selected.name %>
                                        </ui-select-match>
                                        <ui-select-choices repeat="c.id as c in (form.customers | filter: $select.search)">
                                            <span ng-bind="c.name"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.payer_type_id[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-12" ng-if="form.receipt_voucher_type_id == 1">
                                <div class="form-group custom-group">
                                    <label class="required-label">Hóa đơn</label>
                                    <ui-select class="" remove-selected="false" ng-model="form.bill_id" ng-change="getBillDetail()">
                                        <ui-select-match placeholder="Chọn hóa đơn bán">
                                            <% $select.selected.code %>
                                        </ui-select-match>
                                        <ui-select-choices repeat="b.id as b in (form.bills | filter: $select.search)">
                                            <span ng-bind="b.code"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.bill_id[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="required-label">Ngày ghi nhận</label>
                                    <input class="form-control " datetime type="text" ng-model="form.record_date">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.record_date[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="required-label">Đối tượng nộp</label>
                                    <ui-select class="" remove-selected="false" ng-model="form.payer_type_id" ng-change="getPayer()">
                                        <ui-select-match placeholder="Đối tượng nộp phí">
                                            <% $select.selected.name %>
                                        </ui-select-match>
                                        <ui-select-choices repeat="p.id as p in (form.payer_types | filter: $select.search)">
                                            <span ng-bind="p.name"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.payer_type_id[0] %></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-xs-12" ng-if="(form.payer_type_id == 1 || form.payer_type_id == 2 || form.payer_type_id == 3)">
                                <div class="form-group custom-group">
                                    <label class="required-label">Người nộp</label>
                                    <ui-select class="" remove-selected="false" ng-model="form.payer_id">
                                        <ui-select-match placeholder="Người nộp">
                                            <% $select.selected.name %>
                                        </ui-select-match>
                                        <ui-select-choices repeat="r.id as r in (form.payers | filter: $select.search)">
                                            <span ng-bind="r.name"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.payer_id[0] %></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12" ng-if="(form.payer_type_id == 4)">
                                <div class="form-group custom-group">
                                    <label class="form-label required-label">Nhập nộp phí</label>
                                    <input class="form-control" type="text" ng-model="form.payer_name">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.payer_name[0] %></strong>
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
                                    <label class="form-label">Hình thức thanh toán</label>
                                    <select class="form-control custom-select" ng-model="form.pay_type">
                                        <option ng-repeat="m in PAYMENT_METHODS" value="<% m.id %>">
                                            <% m.name %>
                                        </option>
                                    </select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.pay_type[0] %></strong>
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
    app.controller('CreateReceiptVoucher', function ($scope, $http) {
        $scope.form = new ReceiptVoucher({}, {scope: $scope});
        $scope.types = @json(App\Model\G7\ReceiptVoucherType::getForSelect());
        $scope.loading = {};

        @include('g7.funds.receipt_vouchers.formJs');

        // Submit Form tạo mới
        $scope.submit = function () {
            let url = "{!! route('ReceiptVoucher.store') !!}";;
            $scope.loading.submit = true;
            console.log($scope.form.submit_data);
            $.ajax({
                type: "POST",
                url: url,
                data: $scope.form.submit_data,
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function (response) {
                    if (response.success) {
                        $('#create-receipt-voucher').modal('hide');
                        $scope.form = new ReceiptVoucher({}, {scope: $scope});
                        toastr.success(response.message);
                        if (datatable) datatable.ajax.reload();
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
