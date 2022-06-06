<div class="row">
	<div class="col-md-8">
		<div class="row" ng-if="!form.id">
			<div class="col-md-6">
				<div class="form-group">
					<div class="input-group mb-0">
						<div class="input-group-prepend">
							<button class="btn btn-info" type="button" ng-click="searchFixedAsset.open()">
								<i class="fa fa-search"></i>
							</button>
						</div>
						<input type="text" class="form-control" placeholder="Chọn tài sản có sẵn" value="<% form.root.name %>" disabled>
						<div class="input-group-append">
							<button class="btn btn-info" type="button" ng-click="form.removeRootFixedAsset()">
								<i class="fa fa-times"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group custom-group">
					<label class="required-label">Tên</label>
					<input class="form-control" type="text" ng-model="form.name" ng-disabled="form.root.id">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.name[0] %></strong>
					</span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group custom-group">
					<label class="required-label">Mã</label>
					<input class="form-control" type="text" ng-model="form.code" ng-disabled="form.root.id">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.code[0] %></strong>
					</span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group custom-group">
					<label class="required-label">Thời gian khấu hao</label>
					<input class="form-control" type="text" ng-model="form.depreciation_period">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.depreciation_period[0] %></strong>
					</span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group custom-group">
					<label class="required-label">Đơn vị tính</label>
					<ui-select remove-selected="false" ng-model="form.unit_id" ng-disabled="form.root">
						<ui-select-match placeholder="Chọn đơn vị tính">
							<% $select.selected.name %>
						</ui-select-match>
						<ui-select-choices repeat="item.id as item in (form.all_units | filter: $select.search)">
							<span ng-bind="item.name"></span>
						</ui-select-choices>
					</ui-select>
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.unit_id[0] %></strong>
					</span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group custom-group">
					<label class="required-label">Giá nhập định mức</label>
					<input class="form-control" type="text" ng-model="form.import_price_quota">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.import_price_quota[0] %></strong>
					</span>
				</div>
			</div>
			<div class="col-md-6" ng-if="form.id">
				<div class="form-group custom-group">
					<label class="required-label">Trạng thái (*)</label>
					<ui-select remove-selected="false" ng-model="form.status">
						<ui-select-match placeholder="Trạng thái">
							<% $select.selected.name %>
						</ui-select-match>
						<ui-select-choices repeat="item.id as item in (form.statuses | filter: $select.search)">
							<span ng-bind="item.name"></span>
						</ui-select-choices>
					</ui-select>
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.status[0] %></strong>
					</span>
				</div>
			</div>

			<div class="col-md-12">
				<div class="form-group custom-group">
					<label class="form-label">Ghi chú</label>
					<textarea id="my-textarea" class="form-control" ng-model="form.note" rows="3"></textarea>
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.note[0] %></strong>
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

<hr>
<div class="text-right">
	<button type="submit" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
		<i ng-if="!loading.submit" class="fa fa-save"></i>
		<i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
		Lưu
	</button>
	<a href="{{ route('G7FixedAsset.index') }}" class="btn btn-danger btn-cons">
		<i class="fa fa-remove"></i> Hủy
	</a>
</div>
