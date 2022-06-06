<div class="modal fade" id="show-modal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1000px">
        <div class="modal-content">
            <div class="modal-body invoice-detail">
                @include('partial.blocks.invoice_header')
                <hr />
                <div class="col-md-12">
                    <h3 class="invoice-title text-uppercase text-center mb-3">Phiếu thu tiền</h3>
                </div>
                <div class="col-md-12 basic-info mb-3">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <p>Mã phiếu: <strong><% rv.code %></strong></p>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <p>Loại phiếu: <strong><% rv.receipt_voucher_type.name %></strong></p>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <p>Ngày ghi nhận: <strong><% dateGetter(form.record_date, 'YYYY-MM-DD HH:mm', "HH:mm DD/MM/YYYY") %></strong></p>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <p>Người tạo: <strong><%rv.user_create.name %></strong></p>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <p>Trạng thái: <strong><% (rv.status == 1) ? 'Đã duyệt' : 'Hủy' %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Đối tượng trả: <strong><%rv.payer_type_name %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Người trả: <strong><%rv.payer.name ||rv.payer_name %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Tổng giá trị: <strong><%rv.value | number %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Thanh toán cho phiếu: <strong><%rv.bill.code %></strong></p>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <p>Ghi chú: <strong><%rv.note %></strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-success" href="/g7/funds/receipt-vouchers/<%rv.id %>/print" title="In phiếu"><i class="fas fa-print"></i> In phiếu</a>
                <a type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Đóng</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
