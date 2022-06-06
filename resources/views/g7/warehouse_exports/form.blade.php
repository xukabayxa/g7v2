<div class="row">
	<div class="col-12">
		<div class="card customize-card customize-card-2">
			<div class="card-body card-body-customize">
				<div class="row">
					<div class="primary-col col-md-9 col-sm-12">
						<div class="card customize-card-sale">
							<div class="card-header">
								<h6 class="card-title">Danh sách hàng hóa</h6>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-bordered table-hover" ng-if="form.type == 1">
										<thead>
											<tr>
												<th>STT</th>
												<th>Tên hàng</th>
												<th>ĐVT</th>
												<th>Số lượng</th>
											</tr>
										</thead>
										<tbody>
											<tr ng-repeat="p in form.details">
												<td class="text-center"><% $index + 1 %></td>
												<td><% p.product.name %></td>
												<td><% p.unit_name %></td>
												<td>
													<input class="form-control" ng-model="p.qty">
													<span class="invalid-feedback d-block" role="alert">
														<strong><% errors['details.' + $index + '.qty'][0] %></strong>
													</span>
												</td>
											</tr>
											<tr ng-if="!form.details.length">
												<td colspan="4" class="text-center">Chưa có dữ liệu</td>
											</tr>
										</tbody>
									</table>
									<table class="table table-bordered table-hover" ng-if="form.type == 99">
										<thead>
											<tr>
												<th>STT</th>
												<th>Tên hàng</th>
												<th>ĐVT</th>
												<th>Số lượng</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr ng-repeat="p in form.details">
												<td class="text-center"><% $index + 1 %></td>
												<td><% p.product.name %></td>
												<td><% p.product.unit_name %></td>
												<td>
													<input class="form-control" ng-model="p.qty">
													<span class="invalid-feedback d-block" role="alert">
														<strong><% errors['details.' + $index + '.qty'][0] %></strong>
													</span>
												</td>
												<td>
													<button class="btn btn-link text-danger p-0" ng-click="form.removeDetail($index)">
														<i class="fas fa-times"></i>
													</button>
												</td>
											</tr>
											<tr ng-if="!form.details.length">
												<td colspan="5" class="text-center">Chưa có dữ liệu</td>
											</tr>
											<tr>
												<td colspan="5" class="text-center">
													<button type="button" class="btn btn-outline-success" ng-click="searchProduct.open()"><i class="fas fa-plus-square mr-1"></i>Chọn vật tư</button>
												</td>
											</tr>
										</tbody>
									</table>
									<span class="invalid-feedback d-block" role="alert">
										<strong><% errors.details[0] %></strong>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="sidebar-col col-md-3 col-sm-12">
						<div class="card customize-card-sale">
							<div class="card-header">
								<h6 class="card-title">Thông tin chung</h6>
							</div>
							<!-- /.card-header -->
							<div class="card-body card-body-bill">
								<div class="form-group custom-group custom-group-sale">
									<label class="form-label required-label">Loại phiếu</label>
									<ui-select remove-selected="false" ng-model="form.type">
										<ui-select-match placeholder="Loại phiếu">
											<% $select.selected.name %>
										</ui-select-match>
										<ui-select-choices repeat="item.id as item in (form.types | filter: $select.search)">
											<span ng-bind="item.name"></span>
										</ui-select-choices>
									</ui-select>
									<span class="invalid-feedback d-block" role="alert">
										<strong><% errors.type[0] %></strong>
									</span>
								</div>
								<div class="form-group custom-group custom-group-sale" ng-if="form.type == 1">
									<div class="input-group mb-0">
										<input type="text" class="form-control" placeholder="Chọn hóa đơn" value="<% form.bill.code %>" disabled>
										<div class="input-group-append">
											<button class="btn btn-info" type="button" ng-click="searchBill.open()">
												<i class="fa fa-search"></i>
											</button>
										</div>
									</div>
									<span class="invalid-feedback d-block" role="alert">
										<strong><% errors.bill_id[0] %></strong>
									</span>
								</div>
								<div class="form-group custom-group custom-group-sale" ng-if="form.type == 1">
									<label class="form-label">Ngày ghi nhận bán</label>
									<input type="text" datetime-form class="form-control" disabled="disabled" ng-model="form.bill_date">
								</div>
								<div class="form-group custom-group custom-group-sale" ng-if="form.type == 1">
									<label class="form-label">Khách hàng</label>
									<input type="text" class="form-control" disabled="disabled" ng-model="form.customer_name">
								</div>
								<div class="form-group custom-group custom-group-sale" ng-if="form.type == 1">
									<label class="form-label">Ghi chú trên hóa đơn bán</label>
									<textarea class="form-control" rows="3" ng-model="form.bill_note" disabled="disabled"></textarea>
								</div>
								<div class="form-group custom-group custom-group-sale">
									<label class="form-label">Ghi chú xuất hàng</label>
									<textarea class="form-control" rows="3" ng-model="form.note" ></textarea>
								</div>
								<hr>
								<div class="text-center">
									<button type="submit" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
										<i ng-if="!loading.submit" class="fa fa-save"></i>
										<i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
										Duyệt
									</button>
									<a href="{{ route('WarehouseExport.index') }}" class="btn btn-danger btn-cons">
										<i class="fas fa-window-close"></i> Quay lại
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
