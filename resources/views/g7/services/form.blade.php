<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h5>Thông tin chung</h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group custom-group">
							<label class="form-label required-label">Tên dịch vụ</label>
							<input class="form-control" ng-model="form.name" type="text">
							<span class="invalid-feedback d-block" role="alert">
								<strong><% errors.name[0] %></strong>
							</span>
						</div>
						<div class="form-group custom-group">
							<label class="form-label required-label">Loại dịch vụ</label>
							<div class="input-group mb-3">
								<ui-select remove-selected="false" ng-model="form.service_type_id">
									<ui-select-match placeholder="Chọn loại dịch vụ">
										<% $select.selected.name %>
									</ui-select-match>
									<ui-select-choices repeat="t.id as t in (form.all_service_types | filter: $select.search)" ng-selected="t.id == form.service_type_id">
										<span ng-bind="t.name"></span>
									</ui-select-choices>
								</ui-select>

								<div class="input-group-append">
									<button class="btn btn-outline-success" type="button" data-toggle="modal" data-target="#createServiceType">
										<i class="fa fa-plus"></i>
									</button>
								</div>
							</div>
							<span class="invalid-feedback d-block" role="alert">
								<strong><% errors.service_type_id[0] %></strong>
							</span>
						</div>
					</div>
					<div class="col-md-6">
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
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header d-flex align-items-center">
				<h5>Vật tư tiêu hao theo nhóm dịch vụ</h5>
			</div>
			<div class="card-body">
				<table class="table table-bordered table-hover table-responsive">
					<thead>
						<tr>
							<th>STT</th>
							<th>Tên vật tư</th>
							<th>Loại vật tư</th>
							<th>Số lượng</th>
							<th>
								<button class="btn btn-link text-success p-0" ng-click="searchProduct.open()">
									<i class="fa fa-plus"></i>
								</button>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="p in form.products track by $index">
							<td class="text-center"><% $index + 1 %></td>
							<td><% p.product.name %></td>
							<td><% p.product.category.name %></td>
							<td>
								<input class="form-control" type="number" step=".01" ng-model="p._qty">
								<span class="invalid-feedback d-block" role="alert">
									<strong><% errors['products.' + $index + '.qty'][0] %></strong>
								</span>
							</td>
							<td>
								<button class="btn btn-link text-danger p-0" ng-click="form.removeProduct($index)">
									<i class="fas fa-times"></i>
								</button>
							</td>
						</tr>
						<tr ng-if="!form.products.length">
							<td colspan="5">Chưa có dữ liệu</td>
						</tr>
					</tbody>
				</table>
				<span class="invalid-feedback d-block" role="alert">
					<strong><% errors.products[0] %></strong>
				</span>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="card">
			<div class="card-header d-flex align-items-center">
				<h5>Giá dịch vụ</h5>
				<div class="text-danger ml-1">(*)</div>
			</div>
			<div class="card-body">
				<table class="table table-bordered table-responsive" id="table-list">
					<thead>
						<tr>
							<th style="width: 70px" rowspan="2">STT</th>
							<th colspan="4">Dịch vụ</th>
							<th colspan="3">Gói Vật tư sử dụng</th>
							<th style="width: 70px" rowspan="2">
								<button class="btn btn-link text-success p-0" ng-click="form.addVehicleCategory()">
									<i class="fa fa-plus"></i>
								</button>
							</th>
						</tr>
						<tr>
							<th style="width: 200px">Dòng xe</th>
							<th style="width: 250px">Tên trên hóa đơn</th>
							<th style="width: 150px">Giá dịch vụ</th>
							<th style="width: 100px">Tích điểm</th>
							<th style="width: 250px">Mã</th>
							<th style="width: 250px">Tên</th>
							<th style="width: 100px">Định mức</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat-start="v in form.service_vehicle_categories track by $index">
							<td rowspan="<% v.rowspan %>" class="text-center"><% $index + 1 %></td>
							<td rowspan="<% v.rowspan %>" style="width: 200px">
								<ui-select class="" remove-selected="false" ng-model="v.vehicle_category_id">
									<ui-select-match placeholder="Chọn dòng xe">
										<% $select.selected.name %>
									</ui-select-match>
									<ui-select-choices repeat="t.id as t in (v.available_categories | filter: $select.search)">
										<span ng-bind="t.name"></span>
									</ui-select-choices>
								</ui-select>
								<span class="invalid-feedback d-block" role="alert">
									<strong><% errors['service_vehicle_categories.' + $index + '.vehicle_category_id'][0] %></strong>
								</span>
							</td>
							<td colspan="6" class="p-0 border-none"></td>
							<td rowspan="<% v.rowspan %>" class="text-center">
								<button class="btn btn-link text-danger p-0" ng-click="form.removeVehicleCategory($index)">
									<i class="fa fa-minus"></i>
								</button>
							</td>
						</tr>
						<tr ng-repeat-start="g in v.groups">
							<td class="text-center" rowspan="<% g.rowspan %>">
								<input class="form-control" type="text" step=".01" ng-model="g.name">
								<span class="invalid-feedback d-block" role="alert">
									<strong><% errors['service_vehicle_categories.' + $parent.$index + '.groups.' + $index + '.name'][0] %></strong>
								</span>
								<button class="btn btn-link text-danger p-0" ng-click="v.removeGroup($index)">
									<i class="fas fa-times"></i>
								</button>
							</td>
							<td rowspan="<% g.rowspan %>">
								<input class="form-control" type="text" ng-model="g.service_price">
								<span class="invalid-feedback d-block" role="alert">
									<strong><% errors['service_vehicle_categories.' + $parent.$index + '.groups.' + $index + '.service_price'][0] %></strong>
								</span>
							</td>
							<td rowspan="<% g.rowspan %>">
								<input class="form-control" type="text" ng-model="g.points">
								<span class="invalid-feedback d-block" role="alert">
									<strong><% errors['service_vehicle_categories.' + $parent.$index + '.groups.' + $index + '.points'][0] %></strong>
								</span>
							</td>
							<td colspan="3" class="p-0 border-none"></td>
						</tr>
						<tr ng-repeat="p in g.products">
							<td>
								<% p.product.code %>
								<button class="btn btn-link text-danger p-0" ng-click="g.removeProduct($index)">
									<i class="fas fa-times"></i>
								</button>
							</td>
							<td><% p.product.name %> (<% p.product.unit_name %>)</td>
							<td>
								<input class="form-control" type="number" step=".01" ng-model="p._qty">
								<span class="invalid-feedback d-block" role="alert">
									<strong><% errors['service_vehicle_categories.' + $parent.$index + '.products.' + $index + '.qty'][0] %></strong>
								</span>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<button class="btn btn-link p-0" ng-click="searchVehicleCategoryProduct(g)">
									<i class="fa fa-plus"></i> Thêm vật tư
								</button>
								<span class="invalid-feedback d-block" role="alert">
									<strong><% errors['service_vehicle_categories.' + $parent.$index + '.groups.' + $index + '.products'][0] %></strong>
								</span>
							</td>
						</tr>
						<tr class="d-none" ng-repeat-end></tr>
						<tr>
							<td colspan="5">
								<button class="btn btn-link p-0" ng-click="v.addGroup()">
									<i class="fa fa-plus"></i> Thêm nhóm
								</button>
								<span class="invalid-feedback d-block" role="alert">
									<strong><% errors['service_vehicle_categories.' + $index + '.groups'][0] %></strong>
								</span>
							</td>
						</tr>
						<tr class="d-none" ng-repeat-end></tr>
						<tr ng-if="!form.service_vehicle_categories.length">
							<td colspan="8">Chưa có dữ liệu</td>
						</tr>
					</tbody>
				</table>
				<span class="invalid-feedback d-block" role="alert">
					<strong><% errors.service_vehicle_categories[0] %></strong>
				</span>
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
	<a href="{{ route('Service.index') }}" class="btn btn-danger btn-cons">
		<i class="fa fa-remove"></i> Hủy
	</a>
</div>
