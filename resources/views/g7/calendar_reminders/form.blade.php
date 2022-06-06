<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="form-group custom-group ">
            <label class="form-label required-label">Loại nhắc lịch</label>
            <select name="" class="form-control custom-select" ng-model="form.reminder_type">
                <option value="">Chọn loại lịch</option>
                <option ng-repeat="t in form.types" value="<% t.id %>"><% t.name %></option>
            </select>
            <span class="invalid-feedback d-block" role="alert">
                <strong><% errors.reminder_type[0] %></strong>
            </span>
        </div>
    </div>

    <div class="col-md-12 col-sm-12">
        <div class="form-group custom-group">
            <label class="form-label required-label">Ngày nhắc</label>
            <input class="form-control" date type="text" ng-model="form.reminder_date">
            <span class="invalid-feedback d-block" role="alert">
                <strong><% errors.reminder_date[0] %></strong>
            </span>
        </div>
    </div>

    <div class="col-md-12 col-sm-12">
        <div class="form-group custom-group">
            <label class="required-label">Chọn xe</label>
            <ui-select remove-selected="false" ng-model="form.car_id" ng-change="getCustomers()">
                <ui-select-match placeholder="Chọn biển số xe">
                    <% $select.selected.name %>
                </ui-select-match>
                <ui-select-choices repeat="c.id as c in (form.cars | filter: $select.search)">
                    <span ng-bind="c.name"></span>
                </ui-select-choices>
            </ui-select>
            <span class="invalid-feedback d-block" role="alert">
                <strong><% errors.car_id[0] %></strong>
            </span>
        </div>
    </div>

    <div class="col-md-12 col-sm-12">
        <div class="form-group custom-group">
            <label class="required-label">Chọn Khách</label>
            <ui-select remove-selected="false" ng-model="form.customer_id" ng-disabled="!form.car_id">
                <ui-select-match placeholder="Chọn khách hàng">
                    <% $select.selected.name %>
                </ui-select-match>
                <ui-select-choices repeat="c.id as c in (form.customers | filter: $select.search)">
                    <span ng-bind="c.name"></span>
                </ui-select-choices>
            </ui-select>
            <span class="invalid-feedback d-block" role="alert">
                <strong><% errors.customer_id[0] %></strong>
            </span>
        </div>
    </div>

    <div class="col-md-12 col-sm-12">
        <div class="form-group custom-group">
            <label class="form-label required-label">Ghi chú</label>
            <textarea id="my-textarea" class="form-control" name="" rows="3" ng-model="form.note"></textarea>
            <span class="invalid-feedback d-block" role="alert">
                <strong><% errors.note[0] %></strong>
            </span>
        </div>
    </div>
</div>