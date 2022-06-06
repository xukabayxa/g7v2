<div class="modal fade" id="edit-customer-level" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="editCustomerLevel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="semi-bold">Sửa level</h4>
            </div>
            <div class="modal-body">
                @include('uptek.customer_levels.form')
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
    app.controller('editCustomerLevel', function ($scope,$rootScope, $http) {
        $scope.loading = {};

        $rootScope.$on("editCustomerLevel", function (event, data){
           $scope.form = new CustomerLevel(data, {scope: $scope});
           $scope.$applyAsync();
           $scope.loading.submit = false;
           $('#edit-customer-level').modal('show');
        });

        // Submit Form sửa
        $scope.submit = function () {
            let url = "/uptek/customer-levels/" + $scope.form.id + "/update";
            $scope.loading.submit = true;
            // return 0;
            $.ajax({
                type: "POST",
                url: url,
                data: $scope.form.submit_data,
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function (response) {
                    if (response.success) {
                        $('#edit-customer-level').modal('hide');
                        $scope.form = new CustomerLevel({}, {scope: $scope});
                        toastr.success(response.message);
                        if (editCustomerLevelCallback) editCustomerLevelCallback(response.data);
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