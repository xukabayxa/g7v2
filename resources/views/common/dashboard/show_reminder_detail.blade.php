<div class="modal fade" id="show-reminder" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="POST" role="form" id="show-modal-form">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="semi-bold">Chi tiết nhắc lịch</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="mr-3">- Biến số xe:</label> <strong><% form.license_plate.license_plate %></strong>
                        </div>
                        <div class="col-md-12">
                            <label class="mr-3">- Chủ xe:</label> <strong><% form.customers[0].name %> - <% form.customers[0].mobile %></strong>
                        </div>

                        <div class="col-md-12">
                            <label class="mr-3">- Thời hạn đăng kiểm:</label> <strong ng-class="dateReminderCheck(form._registration_deadline) ? 'text-danger' : 'text-success'"><% form.registration_deadline %></strong>
                        </div>
                        <div class="col-md-12">
                            <label class="mr-3">- Thời hạn bảo hiểm thân vỏ:</label> <strong ng-class="dateReminderCheck(form._hull_insurance_deadline) ? 'text-danger' : 'text-success'"><% form.hull_insurance_deadline %></strong>
                        </div>
                        <div class="col-md-12">
                            <label class="mr-3">- Ngày bảo dưỡng tiếp theo:</label> <strong ng-class="dateReminderCheck(form._maintenance_dateline) ? 'text-danger' : 'text-success'"><% form.maintenance_dateline %></strong>
                        </div>
                        <div class="col-md-12">
                            <label class="mr-3">- Thời hạn bảo hiểm bắt buộc:</label> <strong ng-class="dateReminderCheck(form._insurance_deadline) ? 'text-danger' : 'text-success'"><% form.insurance_deadline %></strong>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Hủy</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </form>
    <!-- /.modal-dialog -->
</div>