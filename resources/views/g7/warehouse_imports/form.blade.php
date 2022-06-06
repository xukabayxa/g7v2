<div class="row">
	<div class="col-12">
		<div class="card customize-card customize-card-2">
			<div class="card-header">
				<div class="table-tool text-right w-100 mb-2">
					<button type="button" class="btn btn-outline-success" ng-click="searchProduct.open()"><i class="fas fa-plus-square mr-1"></i>Chọn vật tư</button>
				</div>
			</div>
			<!-- /.card-header -->
			<div class="card-body card-body-customize">
				<div class="row">
					<div class="primary-col col-md-9 col-sm-12">
						<div class="card customize-card-sale">
							<div class="card-header">
								<h6 class="card-title">Danh sách hàng nhập</h6>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<table id="import-list" class="table table-bordered table-hover table-striped table-responsive">
									<thead>
										<tr>
											<th>STT</th>
											{{-- <th>Mã</th> --}}
											<th>Tên</th>
											<th>ĐVT</th>
											<th>Số lượng</th>
											<th>Đơn giá nhập</th>
											<th>Thành tiền</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="p in form.products track by $index">
											<td class="text-center"><% $index + 1 %></td>
											{{-- <td><% p.product.code %></td> --}}
											<td><% p.product.name %></td>
											<td><% p.product.unit_name %></td>
											<td>
												<input class="form-control text-right" type="number" step=".01" ng-model="p.qty" style="width:75px">
												<span class="invalid-feedback d-block" role="alert">
													<strong><% errors['products.' + $index + '.qty'][0] %></strong>
												</span>
											</td>
											<td class="text-center">
												<input class="form-control text-right" style="width:150px; margin: 0 auto" type="text" ng-model="p.import_price">
												<span class="invalid-feedback d-block" role="alert">
													<strong><% errors['products.' + $index + '.import_price'][0] %></strong>
												</span>
											</td>
											<td>
												<div><% p.amount | number %></div>
											</td>
											<td>
												<button class="btn btn-link text-danger p-0" ng-click="form.removeProduct($index)">
													<i class="fas fa-times"></i>
												</button>
											</td>
										</tr>
										<tr ng-if="!form.products.length">
											<td colspan="7" class="text-center">Chưa có dữ liệu</td>
										</tr>
									</tbody>
								</table>
								<span class="invalid-feedback d-block" role="alert">
									<strong><% errors.products[0] %></strong>
								</span>
							</div>
							<div class="card-footer text-center">
								<button type="button" class="btn btn-outline-success" ng-click="searchProduct.open()"><i class="fas fa-plus-square mr-1"></i>Chọn vật tư</button>
							</div>
							<!-- /.card-body -->
							{{--  Model Thêm mới --}}
						</div>
					</div>
					<div class="sidebar-col col-md-3 col-sm-12">
						<div class="card customize-card-sale">
							<div class="card-header">
								<h6 class="card-title">Thông tin hóa đơn</h6>
							</div>
							<!-- /.card-header -->
							<div class="card-body card-body-bill">
								<ul class="list-group">
									<li class="list-group-item">
										<div class="form-group custom-group custom-group-sale">
											<label for="my-input">Ngày tạo hóa đơn</label>
											<input class="form-control" datetime type="text" ng-model="form.import_date">
											<i class="far fa-calendar-alt"></i>
											<span class="invalid-feedback d-block" role="alert">
												<strong><% errors.import_date[0] %></strong>
											</span>
										</div>
									</li>
									<li class="list-group-item">
										<div class="form-group custom-group custom-group-sale add-btn">
											<label class="form-label" for="my-select">Nhà cung cấp</label>
											<div class="input-group mb-3">
												<ui-select remove-selected="false" ng-model="form.supplier_id">
													<ui-select-match placeholder="Nhà cung cấp">
														<% $select.selected.name %>
													</ui-select-match>
													<ui-select-choices repeat="item.id as item in (form.suppliers | filter: $select.search)">
														<span ng-bind="item.name"></span>
													</ui-select-choices>
												</ui-select>
												<div class="input-group-append">
													<button class="btn btn-outline-success" type="button" ng-click="addSupplier()">
														<i class="fa fa-plus"></i>
													</button>
												</div>
											</div>
											<span class="invalid-feedback d-block" role="alert">
												<strong><% errors.supplier_id[0] %></strong>
											</span>
										</div>
									</li>
									<li>
										<div class="form-group custom-group custom-group-sale">
											<label class="form-label">VAT (%)</label>
											<input class="form-control" type="number" ng-model="form.vat_percent">
										</div>
									</li>
									<li>
										<div class="form-group custom-group custom-group-sale">
											<label class="form-label">Ghi chú nhập hàng</label>
											<textarea id="my-textarea" class="form-control" name="" rows="3" ng-model="form.note"></textarea>
										</div>
									</li>
									<li>
										<ul style="padding: 0">
											<li><label class="mr-2">Số lượng hàng:</label> <% form.qty | number %></li>
											<li><label class="mr-2">Thành tiền:</label><% form.amount | number %></li>
											<li><label class="mr-2">VAT:</label> <% form.vat | number %></li>
											<li><label class="mr-2">Thành tiền sau VAT:</label> <% form.amount_after_vat | number %></li>
										</ul>
									</li>

								</ul>
								<hr>
								<div class="text-center">
									<button type="submit" class="btn btn-success btn-cons" ng-click="submit(3)" ng-disabled="loading.submit">
										<i ng-if="!loading.submit" class="fa fa-save"></i>
										<i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
										Lưu
									</button>
									<button type="submit" class="btn btn-success btn-cons" ng-click="submit(1)" ng-disabled="loading.submit">
										<i ng-if="!loading.submit" class="fa fa-save"></i>
										<i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
										Duyệt
									</button>
									<a href="{{ route('Product.index') }}" class="btn btn-danger btn-cons">
										<i class="fas fa-window-close"></i> Hủy
									</a>
								</div>
							</div>
							<!-- /.card-body -->
						</div>
					</div>
				</div>
			</div>
			<!-- /.card-body -->
			{{--  Model Thêm mới --}}
		</div>
		<!-- /.card -->
	</div>
	<!-- /.col -->
</div>
