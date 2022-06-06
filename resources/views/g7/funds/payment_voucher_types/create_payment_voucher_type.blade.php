<div class="modal fade" id="create-payment-voucher-type" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="createPaymentVoucherType">
    <form method="POST" role="form" id="payment-voucher-type-form">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="semi-bold">Thêm mới loại phiếu chi</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group custom-group">
                        <label class="form-label required-label">Tên</label>
                        <input class="form-control" type="text" ng-model="form.name">
                        <span class="invalid-feedback d-block" role="alert">
                            <strong><% errors.name[0] %></strong>
                        </span>
                    </div>

                    <div class="form-group custom-group">
                        <label class="required-label form-label">Trạng thái</label>
                        <select class="form-control custom-select" ng-model="form.status">
                            <option value="">Trạng thái</option>
                            <option value="1">Hoạt động</option>
                            <option value="0">Khóa</option>
                        </select>
                        <span class="invalid-feedback d-block" role="alert">
                            <strong><% errors.status[0] %></strong>
                        </span>
                    </div>

                    <div class="form-group custom-group">
                        <label class="form-label">Ghi chú</label>
                        <textarea id="my-textarea" class="form-control" name="" rows="5" ng-model="form.note"></textarea>
                        <span class="invalid-feedback d-block" role="alert">
                            <strong><% errors.note[0] %></strong>
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
    app.controller('createPaymentVoucherType', function ($scope, $http) {
        $scope.form = {};
        $scope.data_loading = {};
        // Submit Form tạo mới
        $scope.submit = function() {
            var url = "{!! route('PaymentVoucherType.store') !!}";
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
                        $('#create-payment-voucher-type').modal('hide');
                        $('select[name="payment_voucher_id"]').append('<option value="' + response.data.id + '">' + response.data.name + '</option>');
                        $scope.form = {};
                        toastr.success(response.message);
                        if (datatable.datatable) datatable.datatable.ajax.reload();
                        $scope.errors = null;
                        document.getElementById("payment-voucher-type-form").reset();
                        $('select[name="payment_voucher_id"]').val(response.data.id).trigger('change');
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