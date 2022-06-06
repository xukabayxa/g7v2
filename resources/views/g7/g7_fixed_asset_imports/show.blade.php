<div class="modal fade" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1000px">
        <div class="modal-content">
            <div class="modal-body invoice-detail">
				@include('partial.blocks.invoice_header')
                <div class="col-md-12">
                    <h3 class="invoice-title text-uppercase text-center mb-3">Thông tin phiếu nhập tài sản cố định</h3>
                </div>
                <div class="col-md-12 basic-info mb-3">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <p>Mã phiếu: <strong><% form.code %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Ngày tạo: <strong><% form.import_date | toDate | date:'HH:mm dd/MM/yyyy' %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Người tạo: <strong><% form.user_create.name %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Trạng thái phiếu: <strong><% (form.status == 3) ? 'Đang tạo' : 'Đã duyệt' %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Tổng giá trị: <strong><% form.amount | number %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Nhà cung cấp: <strong><% form.supplier.name %></strong></p>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <p>Ghi chú: <strong><% form.note %></strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 detail-info mb-3">
                    <table class="table table-hover table-bordered table-striped" style="width: 100%">
                        <thead>
                            <th>STT</th>
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>DVT</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </thead>
                        <tbody>
                            <tr ng-repeat="p in form.details">
                                <td class="text-center"><% $index + 1 %></td>
                                <td><% p.code %></td>
                                <td><% p.name %></td>
                                <td><% p.unit_name %></td>
                                <td class="text-center"><% p.qty %></td>
                                <td class="text-right"><% p.price | number %></td>
                                <td class="text-right"><% p.total_price | number %></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 sumary-info">
                    <table class="table table-responsive table-hover table-bordered">
                        <tr>
                            <td class="text-left">Tổng tiền hàng:</td>
                            <td class="text-right"><strong><% form.amount | number %></strong></td>
                        </tr>
                        <tr>
                            <td class="text-left">VAT (<% form.vat_percent | number %>%):</td>
                            <td class="text-right"><strong><% form.amount * form.vat_percent / 100  | number%></strong></td>
                        </tr>
                        <tr>
                            <td class="text-left">Tổng giá trị sau VAT (vnđ):</td>
                            <td class="text-right"><strong><% form.amount_after_vat | number %></strong></td>
                        </tr>
                        <tr>
                            <td class="text-left">Đã thanh toán:</td>
                            <td class="text-right"><strong><% form.payed_value | number %></strong></td>
                        </tr>
                        <tr>
                            <td class="text-left">Giá trị chưa thanh toán:</td>
                            <td class="text-right"><strong><% (form.amount_after_vat - form.payed_value) > 0 ? (form.amount_after_vat - form.payed_value) : 0   | number %></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-success" href="/g7/g7_fixed_asset_imports/<% form.id %>/print" title="In phiếu"><i class="fas fa-print"></i> In phiếu</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
