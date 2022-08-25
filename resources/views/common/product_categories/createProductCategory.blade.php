<div class="modal fade" id="createProductCategory" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="createProductCategory">
    <form method="POST" role="form" id="createProductCategoryForm">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="semi-bold">Thêm mới loại vật tư</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Tên</label>
                        <span class="text-danger">(*)</span>
                        <input class="form-control" type="text" ng-model="form.name">
                        <span class="invalid-feedback d-block" role="alert">
                            <strong><% errors.name[0] %></strong>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
                        <i ng-if="!loading.submit" class="fa fa-save"></i>
                        <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
                        Lưu
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Hủy</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </form>
    <!-- /.modal-dialog -->
</div>
<script>
    let createProductCategoryCallback;

    app.controller('createProductCategory', function ($scope, $rootScope, $http) {
        $scope.form = {};
        $scope.data_loading = {};

        $(document).on('shown.bs.modal', '#createProductCategory', function() {
            document.getElementById("createProductCategoryForm").reset();
        })
        // Submit Form tạo mới
        $scope.submit = function() {
            var url = "{!! route('ProductCategory.store') !!}";
            $scope.form.g7_id = {{ Auth::user()->g7_id }};
            var data = $scope.form;

            $scope.loading = true;
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function(response) {
                    if (response.success) {
                        $('#createProductCategory').modal('hide');
                        $scope.form = {};
                        toastr.success(response.message);
                        if(createProductCategoryCallback) createProductCategoryCallback(response.data);
                        $rootScope.$emit("createdProductCategory", response.data);
                        $scope.errors = null;
                    } else {
                        $scope.errors = response.errors;
                        toastr.warning(response.message);
                    }
                },
                error: function() {
                    toastr.error('Đã có lỗi xảy ra');
                },
                complete: function() {
                    $scope.loading = false;
                    $scope.$applyAsync();
                },
            });
        }
    })
</script>