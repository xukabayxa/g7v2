<div class="modal fade" id="createProduct" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="createProduct">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="semi-bold">Thêm mới vật tư</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group custom-group">
                                    <label class="required-label form-label">Tên hàng hóa</label>
                                    <input class="form-control" type="text" ng-model="form.name" placeholder="Tên hàng hóa (*)">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.name[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group custom-group">
                                    <label class="form-label">Mã vạch</label>
                                    <input class="form-control" type="text" ng-model="form.barcode" placeholder="Mã vạch">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.barcode[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group custom-group">
                                    <label class="required-label form-label">Loại hàng hóa</label>
                                    <div class="input-group mb-3">
                                        <ui-select remove-selected="false" ng-model="form.product_category_id">
                                            <ui-select-match placeholder="Chọn nhóm vật tư">
                                                <% $select.selected.name %>
                                            </ui-select-match>
                                            <ui-select-choices repeat="item.id as item in (form.all_categories | filter: $select.search)">
                                                <span ng-bind="item.name"></span>
                                            </ui-select-choices>
                                        </ui-select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-success" type="button" data-toggle="modal" data-target="#createProductCategory">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.product_category_id[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group custom-group">
                                    <label class="required-label form-label">Đơn giá bán</label>
                                    <input class="form-control" type="text" ng-model="form.price" placeholder="Đơn giá bán (*)">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.price[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group custom-group">
                                    <label class="required-label form-label">Đơn vị tính</label>
                                    <div class="input-group mb-3">
                                        <ui-select remove-selected="false" ng-model="form.unit_id">
                                            <ui-select-match placeholder="Chọn đơn vị tính">
                                                <% $select.selected.name %>
                                            </ui-select-match>
                                            <ui-select-choices repeat="item.id as item in (form.all_units | filter: $select.search)">
                                                <span ng-bind="item.name"></span>
                                            </ui-select-choices>
                                        </ui-select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-success" type="button" data-toggle="modal" data-target="#createUnit">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.unit_id[0] %></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group custom-group">
                                    <label class="form-label">Tích điểm</label>
                                    <input class="form-control" type="text" ng-model="form.points" placeholder="Tích điểm">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.points[0] %></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <div class="form-group custom-group">
                                    <label class="form-label">Ghi chú</label>
                                    <textarea class="form-control" ng-model="form.note" rows="3"></textarea>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.note[0] %></strong>
                                    </span>
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
                            <div class="input-group" style="width: 100%; text-align: center">
                                <div class="input-group-btn" style="margin: 0 auto">
                                    <div class="fileUpload fake-shadow cursor-pointer">
                                        <label class="mb-0" for="<% form.image.element_id %>">
                                            <i class="glyphicon glyphicon-upload"></i> Chọn ảnh
                                        </label>
                                        <input class="d-none" id="<% form.image.element_id %>" type="file" class="attachment_upload" accept=".jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                            <span class="invalid-feedback d-block" role="alert">
                                <strong><% errors.image[0] %></strong>
                            </span>
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
<script>
    app.controller('createProduct', function ($scope, $rootScope, $http) {
        $scope.form = new Product({}, {scope: $scope});
        $scope.loading = {};

        createUnitCallback = (response) => {
            $scope.form.all_units.push(response);
            $scope.form.unit_id = response.id;
        }

        $rootScope.$on("createdProductCategory", function (event, data){
            $scope.form.all_categories.push(data);
            $scope.form.product_category_id = data.id;
        });

        // Submit Form tạo mới
        $scope.submit = function () {
            let url = "{!! route('Product.store') !!}";
            let data = $scope.form;
            $scope.loading.submit = true;
            $.ajax({
                type: "POST",
                url: url,
                data: $scope.form.submit_data,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function (response) {
                    if (response.success) {
                        $('#createProduct').modal('hide');
						$scope.form.clearImage();
                        $scope.form = new Product({}, {scope: $scope});
                        toastr.success(response.message);
                        if (datatable) datatable.ajax.reload();
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
