<div class="modal fade" id="quick-payment-voucher" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="semi-bold">Tạo phiếu chi</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="form-label">Thanh toán cho phiếu</label>
                                    <input class="form-control" type="text" ng-value="form.data.code" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="form-label">Tổng giá trị</label>
                                    <input class="form-control" type="text" ng-value="form.data.amount_after_vat | number" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="form-label">Giá trị chưa thanh toán</label>
                                    <input class="form-control" type="text" ng-value="(form.data.amount_after_vat - form.data.payed_value) | number" disabled>
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
                                    <label class="form-label">Hình thức thanh toán</label>
                                    <select class="form-control custom-select" ng-init="form.pay_type = 0" ng-model="form.pay_type">
                                        <option value="0">Tiền mặt</option>
                                        <option value="1">Chuyển khoản</option>
                                    </select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.pay_type[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group custom-group">
                                    <label class="form-label required-label">Số tiền thanh toán</label>
                                    <input class="form-control" type="text" ng-model="form.value" ng-init="form.value = (form.data.amount_after_vat - form.data.payed_value)">
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