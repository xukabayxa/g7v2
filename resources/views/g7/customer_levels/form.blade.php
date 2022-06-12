<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="form-group custom-group">
            <label class="form-label required-label">Tên</label>
            <input class="form-control" type="text" ng-model="form.name">
            <span class="invalid-feedback d-block" role="alert">
                <strong><% errors.name[0] %></strong>
            </span>
        </div>
        <div class="form-group custom-group">
            <label class="form-label required-label">Điểm</label>
            <input class="form-control" type="text" ng-model="form.point">
            <span class="invalid-feedback d-block" role="alert">
                <strong><% errors.point[0] %></strong>
            </span>
        </div>
    </div>
</div>