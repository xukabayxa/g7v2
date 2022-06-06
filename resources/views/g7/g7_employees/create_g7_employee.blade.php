<div class="modal fade" id="create-g7-employee" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="createG7Employee">
    <form method="POST" role="form" id="create-g7-employee-form">
        @csrf
        <div class="modal-dialog" style="max-width: 960px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="semi-bold">Thêm mới hồ sơ nhân viên</h4>
                </div>
                <div class="modal-body">
                    @include('g7.g7_employees.form')
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
    app.controller('createG7Employee', function ($scope, $http) {
        $scope.form = new G7Employee({}, {scope: $scope});
        $scope.loading = {};
        // Submit Form tạo mới
        $scope.submit = function () {
            let url = "{!! route('G7Employee.store') !!}";
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
                        $('#create-g7-employee').modal('hide');
                        $scope.form = new G7Employee({}, {scope: $scope});
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

        @include('partial.modal.locationJs')
    })
</script>