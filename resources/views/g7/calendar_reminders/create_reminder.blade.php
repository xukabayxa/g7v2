<div class="modal fade" id="create-reminder" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="CreateReminder">
    <form method="POST" role="form" id="supplier-form">
        @csrf
        <div class="modal-dialog" style="max-width: 650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="semi-bold">Tạo lịch nhắc CSKH</h4>
                </div>
                <div class="modal-body">
                    @include('g7.calendar_reminders.form')
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
    </form>
    <!-- /.modal-dialog -->
</div>
<script>
    let createReminderCallback;
    app.controller('CreateReminder', function ($scope, $rootScope, $http) {
        $scope.form = new CalendarReminder({}, {scope: $scope});

        $rootScope.$on("createReminder", function (event, data){
            $('#create-reminder').modal('show');
           $scope.form.customer_id = data.customer_id;
           $scope.form.car_id = data.car_id;
           $scope.$applyAsync();
           $scope.loading.submit = false;
        });

        @include('g7.calendar_reminders.formJs')
        // Submit Form tạo mới
        $scope.submit = function () {
            let url = "{!! route('CalendarReminder.store') !!}";
            $scope.loading.submit = true;

            $.ajax({
                type: "POST",
                url: url,
                data: $scope.form.submit_data,
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function (response) {
                    if (response.success) {
                        $('#create-reminder').modal('hide');
                        $scope.form = new CalendarReminder({}, {scope: $scope});
                        toastr.success(response.message);
                        if (createReminderCallback) createReminderCallback(response.data);
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