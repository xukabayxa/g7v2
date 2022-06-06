<div class="modal fade" id="quick-receipt-voucher" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="QuickReceiptVoucher">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="semi-bold">Tạo phiếu thu</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="form-label">Thu cho hóa đơn</label>
                                    <input class="form-control" type="text" ng-value="form.code" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="form-label">Tổng giá trị</label>
                                    <input class="form-control" type="text" ng-value="form.cost_after_vat | number" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="form-label">Giá trị đã thanh toán</label>
                                    <input class="form-control" type="text" ng-value="form.payed_value | number" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="form-label required-label">Ngày ghi nhận</label>
                                    <input class="form-control" type="text" date ng-model="form.record_date">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.record_date[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="form-label required-label">Hình thức thanh toán</label>
                                    <select class="form-control custom-select" ng-model="form.pay_type">
                                        <option ng-repeat="m in PAYMENT_METHODS" value="<% m.id %>" ng-selected="form.pay_type == m.id">
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
                                    <label class="form-label required-label">Số tiền thanh toán</label>
                                    <input class="form-control" type="text" ng-model="form.value">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.value[0] %></strong>
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
@include('partial.classes.g7.ReceiptVoucher')
<script>
    let createQuickReceiptCallback;
    app.controller('QuickReceiptVoucher', function ($rootScope, $scope, $http) {
        $scope.loading = {};

        $rootScope.$on("openQuickReceipt", function (event, data){
           $scope.form = new ReceiptVoucher(data, {scope: $scope});
           console.log($scope.form);
           $scope.$applyAsync();
           $scope.loading.submit = false;
        });

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
                        $('#quick-receipt-voucher').modal('hide');
                        toastr.success(response.message);
                        if(createQuickReceiptCallback) createQuickReceiptCallback(response.data);
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