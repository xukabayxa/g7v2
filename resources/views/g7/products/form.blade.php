<div class="row">
	<div class="col-md-8">
		<div class="row" ng-if="!form.id">
			<div class="col-md-6">
				<div class="form-group">
					<div class="input-group mb-0">
						<div class="input-group-prepend">
							<button class="btn btn-info" type="button" ng-click="searchProduct.open()">
								<i class="fa fa-search"></i>
							</button>
						</div>
						<input type="text" class="form-control" placeholder="Chọn hàng hóa có sẵn" value="<% form.root_product.name %>" disabled>
						<div class="input-group-append">
							<button class="btn btn-info" type="button" ng-click="form.removeRootProduct()">
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
					<label class="form-label required-label">Tên</label>
					<input class="form-control" type="text" ng-model="form.name" placeholder="Tên hàng hóa (*)" ng-disabled="form.root_product">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.name[0] %></strong>
					</span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group custom-group">
					<label class="form-label required-label">Mã</label>
					<input class="form-control" type="text" ng-model="form.code" placeholder="Mã hàng hóa (*)" ng-disabled="form.root_product || form.id">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.code[0] %></strong>
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
			<div class="col-md-6">
				<div class="form-group custom-group">
					<label class="form-label">Mã vạch</label>
					<input class="form-control" type="text" ng-model="form.barcode" placeholder="Mã vạch">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.barcode[0] %></strong>
					</span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group custom-group">
					<label class="required-label">Loại vật tư</label>
					<ui-select remove-selected="false" ng-model="form.product_category_id" ng-disabled="form.root_product">
						<ui-select-match placeholder="Chọn loại vật tư">
							<% $select.selected.name %>
						</ui-select-match>
						<ui-select-choices repeat="item.id as item in (form.all_categories | filter: $select.search)">
							<span ng-bind="item.name"></span>
						</ui-select-choices>
					</ui-select>
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.product_category_id[0] %></strong>
					</span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group custom-group">
					<label class="form-label required-label">Giá bán</label>
					<input class="form-control" type="text" ng-model="form.price" placeholder="Đơn giá bán (*)">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.price[0] %></strong>
					</span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group custom-group">
					<label class="required-label form-label">Đơn vị tính</label>
					<ui-select remove-selected="false" ng-model="form.unit_id" ng-disabled="form.root_product">
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
					<label class="form-label">Tên</label>
					<input class="form-control" type="text" ng-model="form.points" placeholder="Tích điểm">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.points[0] %></strong>
					</span>
				</div>
			</div>

			<div class="col-md-12">
				<div class="form-group custom-group">
					<label class="form-label">Ghi chú</label>
					<textarea class="form-control" ng-model="form.note" rows="3"></textarea>
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
	<a href="{{ route('G7Product.index') }}" class="btn btn-danger btn-cons">
		<i class="fa fa-remove"></i> Hủy
	</a>
</div>
