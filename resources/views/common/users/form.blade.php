<div class="row">
	<div class="col-md-9">
		<div class="card">
			<div class="card-header">
				<h6>Thông tin chung</h6>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Loại tài khoản</label>
                            <span class="text-danger">(*)</span>
							<select class="form-control" ng-model="form.type" ng-change="changeType()" ng-disabled="form.id">
                                <option value="">Chọn loại tài khoản</option>
                                <option ng-repeat="t in form.types" value="<% t.id %>" ng-selected="t.id == form.type">
                                    <% t.name %>
                                </option>
                            </select>
							<span class="invalid-feedback d-block" role="alert">
								<strong><% errors.type[0] %></strong>
							</span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Trạng thái</label>
                            <span class="text-danger">(*)</span>
							<select class="form-control" ng-model="form.status">
								<option value="1" ng-selected="form.status == 1">Hoạt động</option>
                                <option value="0" ng-selected="form.status == 0">Khóa</option>
                            </select>
							<span class="invalid-feedback d-block" role="alert">
								<strong><% errors.status[0] %></strong>
							</span>
						</div>
					</div>
					<div class="col-md-12" ng-if="form.type == 3">
						<div class="form-group">
							<label class="form-label">Điểm G7</label>
							<span class="text-danger">(*)</span>
							<ui-select remove-selected="false" ng-model="form.g7_id" ng-disabled="form.id">
								<ui-select-match placeholder="Chọn điểm g7">
									<% $select.selected.name %>
								</ui-select-match>
								<ui-select-choices repeat="item.id as item in (form.all_g7s | filter: $select.search)">
									<span ng-bind="item.name"></span>
								</ui-select-choices>
							</ui-select>
							<span class="invalid-feedback d-block" role="alert">
								<strong><% errors.g7_id[0] %></strong>
							</span>
						</div>
					</div>
					<div class="col-md-12" ng-if="form.type == 4">
						<div class="form-group">
							<label class="form-label">Điểm G7</label>
							<span class="text-danger">(*)</span>
							<ui-select remove-selected="false" ng-model="form.g7_ids" multiple>
								<ui-select-match placeholder="Chọn điểm g7">
									<% $item.name %>
								</ui-select-match>
								<ui-select-choices repeat="item.id as item in (form.all_g7s | filter: $select.search)">
									<span ng-bind="item.name"></span>
								</ui-select-choices>
							</ui-select>
							<span class="invalid-feedback d-block" role="alert">
								<strong><% errors.g7_id[0] %></strong>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card" ng-if="arrayInclude([2,3], form.type)">
			<div class="card-header d-flex align-items-center">
				<h6 class="mb-0">Phân quyền</h6>
				<div class="text-danger ml-1">(*)</div>
			</div>
			<div class="card-body">
				<ui-select remove-selected="false" multiple ng-model="form.roles">
					<ui-select-match placeholder="Chọn chức vụ">
						<% $item.name %>
					</ui-select-match>
					<ui-select-choices repeat="item.id as item in (form.available_roles | filter: $select.search)">
						<span ng-bind="item.name"></span>
					</ui-select-choices>
				</ui-select>
				<span class="invalid-feedback d-block" role="alert">
					<strong><% errors.roles[0] %></strong>
				</span>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card">
			<div class="card-header"><h6>Ảnh đại diện</h6></div>
			<div class="card-body">
				<div class="img-chooser">
					<label for="<% form.image.element_id %>">
					<img ng-src="<% form.image.path %>">
					<input class="d-none" type="file" accept=".jpg,.png,.jpeg" id="<% form.image.element_id %>">
					</label>
				</div>
				<span class="invalid-feedback d-block" role="alert">
					<strong><% errors['image'][0] %></strong>
				</span>
			</div>
		</div>
		<div class="card">
			<div class="card-header"><h6>Thông tin khác</h6></div>
			<div class="card-body">
				<div class="form-group">
					<label class="form-label">Tên</label>
					<span class="text-danger">(*)</span>
					<input class="form-control" type="text" ng-model="form.name">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.name[0] %></strong>
					</span>
				</div>
				<div class="form-group">
					<label class="form-label">Email</label>
					<span class="text-danger">(*)</span>
					<input class="form-control" type="text" ng-model="form.email">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.email[0] %></strong>
					</span>
				</div>
				<div class="form-group">
					<label class="form-label">Mật khẩu</label>
					<span class="text-danger">(*)</span>
					<div class="input-group mb-0">
						<input class="form-control" type="password" ng-model="form.password">
						<div class="input-group-append">
							<button class="btn btn-outline-secondary show-password" type="button"><i
									class="fa fa-eye muted"></i></button>
						</div>
					</div>
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.password[0] %></strong>
					</span>
				</div>
				<div class="form-group">
					<label class="form-label">Xác nhận mật khẩu</label>
					<span class="text-danger">(*)</span>
					<div class="input-group mb-0">
						<input class="form-control" type="password" ng-model="form.password_confirm">
						<div class="input-group-append">
							<button class="btn btn-outline-secondary show-password" type="button"><i
									class="fa fa-eye muted"></i></button>
						</div>
					</div>
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.password_confirm[0] %></strong>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<hr>
<div class="text-right">
	<button type="submit" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
		<i ng-if="!loading.submit" class="fa fa-save"></i>
		<i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
		Lưu
	</button>
	<a href="{{ route('User.index') }}" class="btn btn-danger btn-cons">
		<i class="fa fa-remove"></i> Hủy
	</a>
</div>
