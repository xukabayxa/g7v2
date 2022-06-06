<div class="modal fade" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1000px">
        <div class="modal-content">
            <div class="modal-body invoice-detail">
                <div class="col-md-12 g7-info mb-5">
                    <img class="g7-logo" src="{{ asset('img/logo/g7_logo.png') }}" alt="">
                    <h5 class="g7-name"><strong>G7 Auto Care Cơ sở 189 Phan Trọng Tuệ</strong></h5>
                    <p>Địa chỉ: <strong>189 Phan Trọng Tuệ, Thanh Trì, Hà Nội</strong></p>
                    <p>Số điện thoại: <strong>085.898.3388</strong></p>
                </div>
                <div class="col-md-12">
                    <h3 class="invoice-title text-uppercase text-center mb-3">Thông tin phiếu nhập hàng</h3>
                </div>
                <div class="col-md-12 basic-info mb-3">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <p>Mã phiếu: <strong><% form.data.code %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Ngày tạo: <strong><% form.data.created_format %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Người tạo: <strong><% form.data.user_create.name %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Trạng thái phiếu: <strong><% (form.data.status == 3) ? 'Đang tạo' : 'Đã duyệt' %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Số lượng mặt hàng: <strong><% form.data.qty %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Tổng giá trị: <strong><% form.data.amount | number %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Nhà cung cấp: <strong><% form.data.supplier.name %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Phương thức thanh toán: <strong><% form.data.pay_type == 1 ? "Tiền mặt" : "Chuyển khoản" %></strong></p>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <p>Ghi chú: <strong><% form.data.note %></strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 detail-info mb-3">
                    <table class="table table-responsive table-hover table-bordered table-striped">
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
                            <tr ng-repeat="p in form.data.products">
                                <td class="text-center"><% $index + 1 %></td>
                                <td><% p.product.code %></td>
                                <td><% p.name %></td>
                                <td><% p.unit_name %></td>
                                <td><% p.qty %></td>
                                <td><% p.import_price | number %></td>
                                <td><% p.amount | number %></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 sumary-info">
                    <table class="table table-hover table-bordered" style="width: 100%">
                        <tr>
                            <td class="text-left">Tổng tiền hàng:</td>
                            <td class="text-right"><strong><% form.data.amount | number %></strong></td>
                        </tr>
                        <tr>
                            <td class="text-left">VAT (<% form.data.vat_percent %>%):</td>
                            <td class="text-right"><strong><% form.data.vat_percent %></td>
                        </tr>
                        <tr>
                            <td class="text-left">Tổng VAT:</td>
                            <td class="text-right"><strong><% form.data.amount * form.data.vat_percent / 100  | number%></strong></td>
                        </tr>
                        <tr>
                            <td class="text-left">Tổng giá trị sau VAT (vnđ):</td>
                            <td class="text-right"><strong><% form.data.amount_after_vat | number %></strong></td>
                        </tr>
                        <tr>
                            <td class="text-left">Đã trả:</td>
                            <td class="text-right"><strong><% form.data.payed_value | number %></strong></td>
                        </tr>
                        <tr>
                            <td class="text-left">Còn nợ:</td>
                            <td class="text-right"><strong><% form.data.amount_after_vat - form.data.payed_value | number %></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-success" href="/g7/warehouse-imports/<% form.data.id %>/print" title="In phiếu"><i class="fas fa-print"></i> In phiếu</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
