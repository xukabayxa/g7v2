<div class="row">
    <div class="col-md-8 col-sm-12">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group custom-group">
                    <label class="form-label required-label">Tên</label>
                    <input class="form-control" type="text" ng-model="form.name">
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.name[0] %></strong>
                    </span>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group custom-group">
                            <label class="form-label required-label">Số điện thoại</label>
                            <input class="form-control" type="text" ng-model="form.mobile">
                            <span class="invalid-feedback d-block" role="alert">
                                <strong><% errors.mobile[0] %></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group custom-group">
                            <label class="form-label">Email</label>
                            <input class="form-control" type="text" ng-model="form.email">
                            <span class="invalid-feedback d-block" role="alert">
                                <strong><% errors.email[0] %></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group custom-group">
                            <label class="form-label required-label">Giới tính</label>
                            <select class="form-control custom-select" style="width: 100%;" ng-model="form.gender">
                                <option value="">Giới tính</option>
                                <option value="1">Nam</option>
                                <option value="0">Nữ</option>
                            </select>
                            <span class="invalid-feedback d-block" role="alert">
                                <strong><% errors.gender[0] %></strong>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group custom-group">
                            <label class="form-label required-label">Ngày sinh</label>
                            <input class="form-control" type="text" date ng-model="form.birth_day">
                            <span class="invalid-feedback d-block" role="alert">
                                <strong><% errors.birth_day[0] %></strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <div class="form-group custom-group">
                            <label class="form-label required-label">Ngày vào làm việc</label>
                            <input class="form-control" type="text" date ng-model="form.start_date">
                            <span class="invalid-feedback d-block" role="alert">
                                <strong><% errors.start_date[0] %></strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <div class="form-group custom-group">
                            <label class="form-label required-label">Trạng thái</label>
                            <select class="form-control custom-select" style="width: 100%;" ng-model="form.status">
                                <option value="">Trạng thái</option>
                                <option value="1">Hoạt động</option>
                                <option value="0">Khóa</option>
                            </select>
                            <span class="invalid-feedback d-block" role="alert">
                                <strong><% errors.status[0] %></strong>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group custom-group">
                    <label class="form-label required-label">Địa chỉ</label>
                    <input class="form-control" type="text" ng-model="form.address" placeholder="Địa chỉ">
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.address[0] %></strong>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
		<div class="form-group text-center">
			<div class="main-img-preview">
				<p class="help-block-img">* Ảnh định dạng: jpg, png không quá 2MB.</p>
				<img class="thumbnail img-preview" ng-src="<% form.image.path %>">
			</div>
			<div class="input-group" style="width: 100%; text-align: center">
				<div class="input-group-btn" style="margin: 0 auto">
					<div class="fileUpload fake-shadow cursor-pointer">
						<label class="mb-0" for="<% form.image.element_id %>">
							<i class="glyphicon glyphicon-upload"></i> Chọn ảnh
						</label>
						<input class="d-none" id="<% form.image.element_id %>" type="file" class="attachment_upload" accept=".jpg,.jpeg,.png">
					</div>
				</div>
			</div>
			<span class="invalid-feedback d-block" role="alert">
				<strong><% errors.image[0] %></strong>
			</span>
		</div>
	</div>
</div>