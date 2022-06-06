<div class="modal fade" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="G7" ng-cloak>
    <div class="modal-dialog" style="max-width: 1000px">
        <div class="modal-content">
            <div class="modal-body invoice-detail">
                @include('partial.blocks.invoice_header')
                <div class="col-md-12">
                    <h3 class="invoice-title text-uppercase text-center mb-3">Thông tin hóa đơn dịch vụ</h3>
                </div>
                <div class="col-md-12 basic-info mb-3">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <p>Mã phiếu: <strong><% form.code %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Thời gian ghi nhận: <strong><% dateGetter(form._bill_date, 'YYYY-MM-DD HH:mm', "HH:mm DD/MM/YYYY") %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Người tạo: <strong><% form.creator %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Trạng thái phiếu: <strong><% getStatusText(form.status, form.statuses) %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Biến số xe: <strong><% form.license_plate %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Khách hàng: <strong><% form.customer_name %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Ghi chú: <strong><% form.note %></strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 detail-info mb-3">
                    <table class="table table-bordered table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã</th>
                                <th>Tên</th>
                                <th>ĐVT</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="s in form.list track by $index">
                                <td class="text-center">
                                    <% $index + 1 %>
                                </td>
                                <td>
                                    <% s.code ? s.code : '-' %>
                                </td>
                                <td>
                                    <% s.name %>
                                    <div ng-if="s.is_service"><b>Gói vật tư: </b><% s.group_name %></div>
                                </td>
                                <td><% s.is_service ? 'Gói' : s.unit_name ? s.unit_name : 'Gói' %></td>
                                <td class="text-center">
                                    <% s.qty %>
                                </td>
                                <td class="text-right">
                                    <% s._price | number %>
                                </td>
                                <td class="text-right">
                                    <% s.total_cost | number %>
                                </td>
                            </tr>
                            <tr ng-if="form.promo_products.length">
                                <td colspan="7"><b>Khuyến mãi</b></td>
                            </tr>
                            <tr ng-repeat="s in form.promo_products track by $index">
                                <td class="text-center">
                                    <% form.list.length + $index + 1 %>
                                </td>
                                <td><% s.code %></td>
                                <td><% s.product_name %></td>
                                <td><% s.unit_name %></td>
                                <td class="text-center"><% s.qty | number %></td>
                                <td class="text-right">0</td>
                                <td class="text-right">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 sumary-info">
                    <table class="table table-hover table-bordered" style="width: 100%">
                        <tr>
                            <td class="text-left">Tổng tiền (vnđ):</td>
                            <td class="text-right"><strong><% form.cost_after_sale | number %></strong></td>
                        </tr>
                        <tr ng-if="form.promo_value > 0">
                            <td class="text-left">Tổng tiền sau chiết khấu (vnđ):</td>
                            <td class="text-right"><strong><% form.cost_after_promo | number %></strong></td>
                        </tr>
                        <tr>
                            <td class="text-left">VAT (<% form.vat_percent %>%):</td>
                            <td class="text-right"><strong><% form.vat_cost | number %></td>
                        </tr>
                        <tr>
                            <td class="text-left">Tổng giá trị sau VAT:</td>
                            <td class="text-right"><strong><% form.cost_after_vat | number %></strong></td>
                        </tr>
                        <tr>
                            <td class="text-left">Đã thu <span ng-if="form.point_pay">(Sử dụng: <% form.point_pay | number %>điểm) </span>:</td>
                            <td class="text-right"><strong><% form.payed_value | number %></strong></td>
                        </tr>

                        <tr>
                            <td class="text-left">Công nợ:</td>
                            <td class="text-right"><strong><% form.cost_after_vat - form.payed_value | number %></strong></td>
                        </tr>
                        <tr>
                            <td class="text-left">Giá vốn xuất kho:</td>
                            <td class="text-right"><strong><% form.warehouse_export.export_value | number %></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-success" href="/g7/bills/<% form.id %>/print?type=57" title="In phiếu"><i class="fas fa-print"></i> In 57mm</a>
                <a type="button" class="btn btn-success" href="/g7/bills/<% form.id %>/print" title="In phiếu"><i class="fas fa-print"></i> In phiếu</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
@include('partial.classes.g7.Bill')
<script>
    app.controller('G7', function ($scope, $rootScope, $http) {
      $rootScope.$on("openShowBill", function (event, data){
          $scope.form = new Bill(data, {scope: $scope, mode: "show"});
          console.log($scope.form.list);
      });
  });
</script>