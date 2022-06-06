<div class="modal fade" id="edit-reminder" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="EditReminder">
    <form method="POST" role="form" id="supplier-form">
        @csrf
        <div class="modal-dialog" style="max-width: 650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="semi-bold">Sửa lịch nhắc CSKH</h4>
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
    app.controller('EditReminder', function ($scope, $rootScope, $http) {

        $rootScope.$on("editReminder", function (event, data){
            $('#edit-reminder').modal('show');
           $scope.form = new CalendarReminder(data, {scope: $scope});
           $scope.$applyAsync();
           $scope.loading.submit = false;
        });

        @include('g7.calendar_reminders.formJs')

        $scope.submit = function() {
            $scope.loading.submit = false;
            $.ajax({
                type: 'POST',
                url: "/g7/calendar-reminders/" + $scope.form.id + "/update",
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: $scope.form.submit_data,
                success: function(response) {
                if (response.success) {
                    $('#edit-reminder').modal('hide');
                    toastr.success(response.message);
                    if (datatable) datatable.ajax.reload();
                    $scope.errors = null;
                } else {
                    toastr.warning(response.message);
                    $scope.errors = response.errors;
                }
                },
                error: function(e) {
                    toastr.error('Đã có lỗi xảy ra');
                },
                complete: function() {
                    $scope.loading.submit = false;
                    $scope.$applyAsync();
                }
            });
        }
    })
</script>