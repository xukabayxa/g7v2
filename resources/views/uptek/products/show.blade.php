<div class="modal fade" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="POST" role="form" id="showModalForm">
        @csrf
        <div class="modal-dialog" style="max-width: 850px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="semi-bold"><% form.name %></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 col-sm-12">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group custom-group">
                                        <label class="required-label form-label">Tên hàng hóa</label>
                                        <input class="form-control" type="text" ng-model="formEdit.name" placeholder="Tên hàng hóa (*)" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group custom-group">
                                        <label class="form-label">Mã vạch</label>
                                        <input class="form-control" type="text" ng-model="formEdit.barcode" placeholder="Mã vạch" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group custom-group">
                                        <label class="required-label form-label">Loại hàng hóa</label>
                                        <div class="input-group mb-3">
                                            <ui-select remove-selected="false" ng-model="formEdit.product_category_id" disabled="disabled">
                                                <ui-select-match placeholder="Chọn nhóm vật tư">
                                                    <% $select.selected.name %>
                                                </ui-select-match>
                                                <ui-select-choices repeat="item.id as item in (formEdit.all_categories | filter: $select.search)">
                                                    <span ng-bind="item.name"></span>
                                                </ui-select-choices>
                                            </ui-select>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group custom-group">
                                        <label class="required-label form-label">Giá bán</label>
                                        <input class="form-control" type="text" ng-model="formEdit.price" placeholder="Đơn giá bán (*)" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group custom-group">
                                        <label class="required-label form-label">Đơn vị tính (*)</label>
                                        <div class="input-group mb-3">
                                            <ui-select remove-selected="false" ng-model="formEdit.unit_id" disabled="disabled">
                                                <ui-select-match placeholder="Chọn đơn vị tính">
                                                    <% $select.selected.name %>
                                                </ui-select-match>
                                                <ui-select-choices repeat="item.id as item in (formEdit.all_units | filter: $select.search)" ng-selected="item.id == formEdit.unit_id">
                                                    <span ng-bind="item.name"></span>
                                                </ui-select-choices>
                                            </ui-select>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group custom-group">
                                        <label class="form-label">Tích điểm</label>
                                        <input class="form-control" type="text" ng-model="formEdit.points" placeholder="Tích điểm" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group custom-group">
                                        <label class="form-label required-label">Trạng thái</label>
                                        <select class="form-control" select2 style="width: 100%;" name="status" ng-model="formEdit.status" disabled="disabled">
                                            <option value="1">Hoạt động</option>
                                            <option value="0">Khóa</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group custom-group">
                                        <label class="form-label">Ghi chú</label>
                                        <textarea id="my-textarea" class="form-control" ng-model="formEdit.note" rows="3" disabled="disabled"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group text-center">
                                <div class="main-img-preview">
                                    <img class="thumbnail img-preview" ng-src="<% formEdit.image.path %>" style="max-with:250px">
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
    </form>
</div>