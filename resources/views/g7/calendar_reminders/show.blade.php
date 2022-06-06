<div class="modal fade" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="POST" role="form" id="show-modal-form">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="semi-bold">Chi tiết nhà cung cấp</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group custom-group">
                                <label class="form-label">Tên</label>
                                <input class="form-control" type="text" ng-model="form.name" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12">
                            <div class="form-group custom-group">
                                <label class="form-label required-label">Số điện thoại</label>
                                <input class="form-control" type="text" ng-model="form.mobile" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12">
                            <div class="form-group custom-group">
                                <label class="form-label">Địa chỉ</label>
                                <input class="form-control" type="text" ng-model="form.address" disabled="disabled">
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong><% errors.address[0] %></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12">
                            <div class="form-group custom-group">
                                <label class="form-label required-label">Trạng thái</label>
                                <select class="form-control custom-select" name="status" ng-model="form.status" disabled="disabled">
                                    <option value="">Trạng thái</option>
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Khóa</option>
                                </select>
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
    </form>
</div>