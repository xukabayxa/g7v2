<div class="row">
	<div class="col-12">
		<div class="card customize-card customize-card-2">
			<div class="card-body card-body-customize">
				<div class="row">
					<div class="primary-col col-md-9 col-sm-12">
						<div class="card customize-card-sale">
							<div class="card-header">
								<h6 class="card-title">Danh sách hóa đơn</h6>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th rowspan="2">STT</th>
												<th rowspan="2">Số hóa đơn</th>
												<th rowspan="2">Ngày duyệt</th>
												<th colspan="7">Chi tiết</th>
											</tr>
											<tr>
												<th>Tên hàng</th>
												<th>Mã hàng</th>
												<th>ĐVT</th>
												<th>Số lượng định mức</th>
												<th>Số lượng thực tế</th>
												<th>Chênh lệch</th>
												<th>Ghi chú</th>
											</tr>
										</thead>
										<tbody>
											<tr ng-repeat-start="b in form.bills track by $index">
												<td rowspan="<% b.rowspan %>" class="text-center"><% $index + 1 %></td>
												<td rowspan="<% b.rowspan %>"><% b.code %></td>
												<td rowspan="<% b.rowspan %>"><% b.approved_time | toDate | date:'HH:mm dd/MM/yyyy' %></td>
												<td colspan="7" class="p-0 border-none"></td>
											</tr>
											<tr ng-repeat="p in b.export_products">
												<td><% p.product.name %></td>
												<td><% p.product.code %></td>
												<td><% p.unit_name %></td>
												<td class="text-center"><% p.qty | number %></td>
												<td>
													<input class="form-control" ng-model="p.real_qty">
													<span class="invalid-feedback d-block" role="alert">
														<strong><% errors['bills.' + $parent.$index + '.export_products.' + $index + '.real_qty'][0] %></strong>
													</span>
												</td>
												<td class="text-center"><% p.diff %></td>
												<td>
													<input class="form-control" ng-model="p.note">
													<span class="invalid-feedback d-block" role="alert">
														<strong><% errors['bills.' + $parent.$index + '.export_products.' + $index + '.note'][0] %></strong>
													</span>
												</td>
											</tr>
											<tr ng-repeat-end></tr>
											<tr ng-if="!form.bills.length">
												<td colspan="10" class="text-center">Chưa có dữ liệu</td>
											</tr>
										</tbody>
									</table>
									<span class="invalid-feedback d-block" role="alert">
										<strong><% errors.bills[0] %></strong>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="sidebar-col col-md-3 col-sm-12">
						<div class="card customize-card-sale">
							<div class="card-header">
								<h6 class="card-title">Thông tin khác</h6>
							</div>
							<!-- /.card-header -->
							<div class="card-body card-body-bill">
								<div class="form-group custom-group custom-group-sale">
									<label for="my-input">Ngày chốt</label>
									<input class="form-control" date type="text" ng-model="form.created_time" disabled>
									<i class="far fa-calendar-alt"></i>
								</div>
								<div class="form-group custom-group custom-group-sale">
									<label class="form-label">Ghi chú</label>
									<textarea class="form-control" rows="3" ng-model="form.note"></textarea>
								</div>
								<hr>
								<div class="text-center">
									<button type="submit" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
										<i ng-if="!loading.submit" class="fa fa-save"></i>
										<i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
										Duyệt
									</button>
									<a href="{{ route('FinalWarehouseAdjust.index') }}" class="btn btn-danger btn-cons">
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
