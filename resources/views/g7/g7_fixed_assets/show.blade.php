<div class="modal fade" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="showG7FixedAsset">
    <form method="POST" role="form" id="show-g7-employee-form">
        @csrf
        <div class="modal-dialog" style="max-width: 960px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="semi-bold"><% form.name %></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 col-sm-12">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group custom-group">
                                        <label class="form-label required-label">Tên</label>
                                        <input class="form-control" type="text" ng-model="form.name" disabled="disabled">

                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group custom-group">
                                                <label class="form-label required-label">Mã</label>
                                                <input class="form-control" type="text" ng-model="form.code" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group custom-group">
                                                <label class="form-label">Giá nhập định mức</label>
                                                <input class="form-control" type="text" ng-model="form.import_price_quota" disabled="disabled">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group custom-group">
                                                <label class="form-label">Đơn vị tính</label>
                                                <input class="form-control" type="text" ng-model="form.unit_name" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group custom-group">
                                                <label class="form-label required-label">Trạng thái</label>
                                                <select class="form-control custom-select" style="width: 100%;" ng-model="form.status" disabled="disabled">
                                                    <option value="">Trạng thái</option>
                                                    <option value="1">Hoạt động</option>
                                                    <option value="0">Khóa</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group custom-group">
                                        <label class="form-label required-label">Ghi chú</label>
                                        <textarea rows="3" class="form-control" ng-model="form.note" disabled="disabled"></textarea>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group text-center">
                                <div class="main-img-preview">
                                    <p class="help-block-img">* Ảnh định dạng: jpg, png không quá 2MB.</p>
                                    <img class="thumbnail img-preview" ng-src="<% form.image.path %>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Hủy</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>
<script>
    app.controller('showG7FixedAsset', function ($scope,$rootScope, $http) {
        $rootScope.$on("showG7FixedAsset", function (event, data){
           $scope.form = new G7FixedAsset(data, {scope: $scope});

           console.log($scope.form);
           $scope.$applyAsync();
           $('#show-modal').modal('show');
        });
    })
</script>
@include('partial.classes.g7.G7FixedAsset')