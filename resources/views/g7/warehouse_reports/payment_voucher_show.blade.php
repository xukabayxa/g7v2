<div class="modal fade" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1000px">
        <div class="modal-content">
            <div class="modal-body invoice-detail">
                @include('partial.blocks.invoice_header')
                <hr />
                <div class="col-md-12">
                    <h3 class="invoice-title text-uppercase text-center mb-3">PHIẾU CHI TIỀN</h3>
                </div>
                <div class="col-md-12 basic-info mb-3">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <p>Mã phiếu: <strong><% pv.code %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Loại phiếu: <strong><% pv.payment_voucher_type.name %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Ngày ghi nhận: <strong><% dateGetter(pv.record_date, 'YYYY-MM-DD HH:mm', "HH:mm DD/MM/YYYY") %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Người tạo: <strong><% pv.user_create.name %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Trạng thái: <strong><% (pv.status == 1) ? 'Đã duyệt' : 'Hủy' %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Đối tượng nhận: <strong><% pv.recipient_type_name %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Người nhận: <strong><% pv.recipientale.name || pv.recipient_name %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Tổng giá trị: <strong><% pv.value | number %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6" ng-if="pv.payment_voucher_type_id == 1">
                            <p>Thanh toán cho phiếu: <strong><% pv.ware_house_import.code %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6" ng-if="pv.payment_voucher_type_id == 2">
                            <p>Thanh toán cho phiếu: <strong><% pv.g7_fixed_asset_import.code %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6" ng-if="pv.payment_voucher_type_id == 5">
                            <p>Số tháng phân bổ: <strong><% pv.month %></strong></p>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <p>Ghi chú: <strong><% pv.note %></strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-print"></i> In phiếu</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
