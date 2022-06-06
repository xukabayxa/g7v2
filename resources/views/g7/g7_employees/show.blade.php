<div class="modal fade" id="show-g7-employee" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="showG7Employee">
    <form method="POST" role="form" id="show-g7-employee-form">
        @csrf
        <div class="modal-dialog" style="max-width: 960px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="semi-bold">Xem hồ sơ nhân viên</h4>
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
                                                <label class="form-label required-label">Số điện thoại</label>
                                                <input class="form-control" type="text" ng-model="form.mobile" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group custom-group">
                                                <label class="form-label">Email</label>
                                                <input class="form-control" type="text" ng-model="form.email" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group custom-group">
                                                <label class="form-label required-label">Giới tính</label>
                                                <select class="form-control custom-select" style="width: 100%;" ng-model="form.gender" disabled="disabled">
                                                    <option value="">Giới tính</option>
                                                    <option value="1">Nam</option>
                                                    <option value="0">Nữ</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group custom-group">
                                                <label class="form-label required-label">Ngày sinh</label>
                                                <input class="form-control" type="text" date ng-model="form.birth_day" disabled="disabled">
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group custom-group">
                                                <label class="form-label required-label">Ngày vào làm việc</label>
                                                <input class="form-control" type="text" date ng-model="form.start_date" disabled="disabled">
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
                                        <label class="form-label required-label">Địa chỉ</label>
                                        <input class="form-control" type="text" ng-model="form.address" placeholder="Địa chỉ" disabled="disabled">
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
    app.controller('showG7Employee', function ($scope,$rootScope, $http) {
        $rootScope.$on("showG7Employee", function (event, data){
           $scope.form = new G7Employee(data, {scope: $scope});
           $scope.$applyAsync();
           $('#show-g7-employee').modal('show');
        });
    })
</script>