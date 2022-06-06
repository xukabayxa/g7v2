<div class="modal fade" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="G7" ng-cloak>
    <div class="modal-dialog" style="max-width: 1000px">
        <div class="modal-content">
            <div class="modal-body invoice-detail">
                @include('partial.blocks.invoice_header')
                <div class="col-md-12">
                    <h3 class="invoice-title text-uppercase text-center mb-3">PHIẾU XUẤT KHO</h3>
                </div>
                <div class="col-md-12 basic-info mb-3">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <p>Mã phiếu: <strong><% form.code %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Ngày xuất: <strong><% dateGetter(form.created_at, 'YYYY-MM-DD HH:mm', "HH:mm DD/MM/YYYY") %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Người tạo: <strong><% form.creator %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Số hóa đơn bán: <strong><% form.bill.code %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Khách hàng: <strong><% form.bill.customer_name %></strong></p>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <p>Ghi chú: <strong><% form.note %></strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 detail-info mb-3">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên hàng</th>
                                <th>ĐVT</th>
                                <th>Số lượng</th>
                                <th>Giá xuất kho</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="p in form.details track by $index">
                                <td class="text-center">
                                    <% $index + 1 %>
                                </td>
                                <td><% p.product_name %></td>
                                <td><% p.unit_name %></td>
                                <td class="text-center"><% p.qty | number %></td>
                                <td class="text-right"> <% p.export_price | number %></td>
                                <td class="text-right"> <% p.export_price * p.qty | number %></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 sumary-info">
                    <table class="table table-hover table-bordered" style="width: 100%">
                        <tr>
                            <td class="text-left">Tổng số lượng xuất kho:</td>
                            <td class="text-right"><strong><% form.total_qty | number %></strong></td>
                        </tr>
                        <tr>
                            <td class="text-left">Tổng giá trị xuất kho:</td>
                            <td class="text-right"><strong><% form.export_value | number %></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-success" href="/g7/warehouse_exports/<% form.id %>/print" title="In phiếu"><i class="fas fa-print"></i> In phiếu</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
@include('partial.classes.g7.WarehouseExport')
<script>
    app.controller('G7', function ($scope, $rootScope, $http) {
      $rootScope.$on("openShowWarehouseExport", function (event, data){
          $scope.form = new WarehouseExport(data, {scope: $scope, mode: "show"});
          console.log($scope.form);
      });
  });
</script>