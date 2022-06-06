<style>
	@media all and (max-width: 1280px) {
		.layout-fixed .main-sidebar {
			margin-left: -250px !important;
			box-shadow: none !important;
		}

		.main-header,
		.main-footer,
		.content-wrapper {
			margin-left: 0 !important;
		}

		.content-wrapper>.content {
			padding: 0;
		}
	}
</style>
<div class="row">
	<div class="col-12">
		<div class="card customize-card customize-card-2">
			<div class="card-body card-body-customize">
				<div class="row">
					<div class="col-lg-12">
						<div class="card customize-card-sale">
							<div class="card-body" style="padding: 15px 3px 5px">
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<div class="form-group custom-group custom-group-sale">
											<label class="form-label">Xe</label>
											<div class="input-group group-nowrap mb-3">
												<ui-select remove-selected="false" ng-model="form.car_id" ng-change="getCar()" theme="select2">
													<ui-select-match placeholder="Chọn xe" allow-clear="true">
														<% $select.selected.name %>
													</ui-select-match>
													<ui-select-choices repeat="item.id as item in cars" refresh="searchCar($select.search)" refresh-delay="0">
														<span ng-bind="item.name"></span>
													</ui-select-choices>
												</ui-select>
												<div class="input-group-append">
													<button class="btn btn-outline-success" type="button" data-toggle="modal" data-target="#createCar">
														<i class="fa fa-plus"></i>
													</button>
												</div>
											</div>
											<span class="invalid-feedback d-block" role="alert">
												<strong><% errors.car_id[0] %></strong>
											</span>
										</div>

										{{-- <div class="form-group">
											<div class="input-group mb-0">
												<div class="input-group-prepend">
													<button class="btn btn-info" type="button" ng-click="searchCar.open()">
														<i class="fa fa-search"></i>
													</button>
												</div>
												<input type="text" class="form-control" placeholder="Chọn xe sử dụng dịch vụ" value="<% form.car.license_plate.license_plate %>" disabled>
												<div class="input-group-append">
													<button class="btn btn-outline-success" type="button" data-toggle="modal" data-target="#createCar">
														<i class="fa fa-plus"></i>
													</button>
												</div>
											</div>
											<span class="invalid-feedback d-block" role="alert">
												<strong><% errors.car_id[0] %></strong>
											</span>
										</div> --}}

									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<div class="form-group custom-group custom-group-sale">
											<label class="required-label">Khách hàng</label>
											<div class="input-group group-nowrap mb-3">
												<ui-select remove-selected="false" ng-model="form.customer_id" ng-change="getPoints()" theme="select2">
													<ui-select-match placeholder="Khách hàng" allow-clear="true">
														<% $select.selected.name %>
													</ui-select-match>
													<ui-select-choices repeat="item.id as item in (form.customers | filter: $select.search)">
														<span ng-bind="item.name"></span>
													</ui-select-choices>
												</ui-select>
												<div class="input-group-append">
													<button class="btn btn-outline-success" type="button" ng-click="addCustomerToForm()">
														<i class="fa fa-plus"></i>
													</button>
												</div>
											</div>
											<span class="invalid-feedback d-block" role="alert">
												<strong><% errors.customer_id[0] %></strong>
											</span>

										</div>
									</div>
								</div>
								<div class="row mb-3" ng-show="form.customer_id && form.car_id">
									<div class="col-sm-12 col-xs-12">
										<div class="form-check">
											<input id="update_reminder" class="form-check-input ng-valid ng-dirty ng-valid-parse ng-touched" type="checkbox" ng-model="form.update_reminder">
											<label for="update_reminder" class="form-check-label">Thông tin xe</label>
										</div>
									</div>
								</div>
								<div class="row" ng-show="form.update_reminder">
									<div class="col-md-3 col-sm-6">
										<div class="form-group custom-group">
											<label class="form-label">Thời hạn đăng kiểm</label>
											<div class="input-group">
												<input type="text" date-form class="form-control" ng-class="{'is-invalid': !form.isValidRegistration()}" ng-model="form.registration_deadline">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
												</div>
												<span class="invalid-feedback d-block" role="alert">
													<strong><% errors.type_id[0] %></strong>
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="form-group custom-group">
											<label class="form-label">Thời hạn bảo hiểm thân vỏ</label>
											<div class="input-group">
												<input type="text" date-form class="form-control" ng-class="{'is-invalid': !form.isValidHullInsuranceDeadline()}" ng-model="form.hull_insurance_deadline">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
												</div>
												<span class="invalid-feedback d-block" role="alert">
													<strong><% errors.type_id[0] %></strong>
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="form-group custom-group">
											<label class="form-label">Ngày bảo dưỡng tiếp theo</label>
											<div class="input-group">
												<input type="text" date-form class="form-control" ng-class="{'is-invalid': !form.isValidMaintenanceDateline()}" ng-model="form.maintenance_dateline">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
												</div>
												<span class="invalid-feedback d-block" role="alert">
													<strong><% errors.maintenance_dateline[0] %></strong>
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="form-group custom-group">
											<label class="form-label">Thời hạn bảo hiểm bắt buộc</label>
											<div class="input-group">
												<input type="text" date-form class="form-control" ng-class="{'is-invalid': !form.isValidInsuranceDeadline()}" ng-model="form.insurance_deadline">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
												</div>
												<span class="invalid-feedback d-block" role="alert">
													<strong><% errors.insurance_deadline[0] %></strong>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="bill-menu-select col-md-9 col-sm-8 col-xs-12">
						<div class="card customize-card-sale" style="height: 90vh;">
							<div class="card-header">
								<h6 class="card-title">Menu dịch vụ G7</h6>
							</div>
							<div class="card-body" style="padding: 5px">
								<div class="row fillter-menu" style="margin-top: 10px">
									<div class="col md-4 col-sm-4 col-xs-12">
										<div class="form-group custom-group">
											<label class="form-label">Chọn dịch vụ/Hàng hóa</label>
											<select id="my-select" class="form-control custom-select" ng-model="fill.choose" ng-init="fill.choose = 1" ng-change="getFilterProducts()">
												<option value="1">Dịch vụ</option>
												<option value="2">Hàng hóa</option>
											</select>
										</div>
									</div>
									{{-- Tìm kiếm dịch vụ --}}
									<div class="col md-4 col-sm-4 col-xs-12" ng-if="fill.choose == 1">
										<div class="form-group custom-group">
											<label class="form-label">Loại dịch vụ</label>
											<select class="form-control custom-select" ng-model="fill.service_id">
												<option value="">Chọn loại dịch vụ</option>
												<option ng-repeat="t in form.service_groups" ng-value="t.id"><% t.name %></option>
											</select>
										</div>
									</div>
									<div class="col md-4 col-sm-4 col-xs-12" ng-if="fill.choose == 1">
										<div class="form-group custom-group">
											<label for="my-input">Tên dịch vụ</label>
											<input id="my-input" class="form-control" type="text" ng-model="fill.name" placeholder="Tìm theo tên dịch vụ">
										</div>
									</div>
									{{-- Tìm kiếm Hàng hóa --}}
									<div class="col md-4 col-sm-4 col-xs-12" ng-if="fill.choose == 2">
										<div class="form-group custom-group">
											<label class="form-label">Loại hàng hóa</label>
											<select id="my-select" class="form-control custom-select" ng-model="fill.category_id" ng-change="getFilterProducts()">
												<option value="">Chọn loại hàng hóa</option>
												<option ng-repeat="t in form.product_caterories" ng-value="t.id"><% t.name %></option>
											</select>
										</div>
									</div>
									<div class="col md-4 col-sm-4 col-xs-12" ng-if="fill.choose == 2">
										<div class="form-group custom-group">
											<label for="my-input">Tên hàng hóa</label>
											<input id="my-input" class="form-control" type="text" ng-model="fill.product_name" placeholder="Tìm theo tên hàng hóa" ng-change="getFilterProducts()">
										</div>
									</div>
								</div>
								{{-- Danh sách dịch vụ --}}
								<div class="row" ng-if="fill.choose == 1">
									<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 item-bill" ng-repeat="item in getFilterServices()">
										<img src="<% item.service.image.path %>" alt="">
										<div class="item-info">
											<p class="item-name"><b><% item.service.name %> (Gói: <% item.name %>)</b></p>
											<p class="item-price">
												<b><% item.service_price | number %></b>
											</p>
										</div>
										<div class="select-button">
											<button ng-disabled="form.checkServiceExists(item.id)" class="" ng-click="chooseService(item)">
												<i class="fas fa-plus-circle" ng-if="!form.checkServiceExists(item.id)"></i>
												<i class="far fa-check-circle" ng-if="form.checkServiceExists(item.id)"></i>
											</button>
										</div>
									</div>
								</div>
								{{-- Danh sách Hàng hóa --}}
								<div class="row" ng-if="fill.choose == 2">
									<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 item-bill" ng-repeat="item in all_product">
										<img src="<% item.image.path %>" alt="">
										<div class="item-info">
											<p class="item-name"><b><% item.name %></b></p>
											<p class="item-price">
												<b><% (item.g7_price.price || item.price) | number %></b>
											</p>
										</div>
										<div class="select-button">
											<button ng-disabled="form.checkProductExists(item.id)" class="" ng-click="chooseProduct(item)">
												<i class="fas fa-plus-circle" ng-if="!form.checkProductExists(item.id)"></i>
												<i class="far fa-check-circle" ng-if="form.checkProductExists(item.id)"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="bill-detail-col col-md-3 col-sm-4 col-xs-12">
						<div class="card customize-card-sale">
							<div class="card-header">
								<h6 class="card-title">Chi tiết hóa đơn</h6>
							</div>
							<div class="card-body" style="padding: 3px">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Tên</th>
											<th>Số lượng</th>
											<th>Đơn giá</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="s in form.list track by $index">
											<td ng-if="s.is_service">
												<button class="btn btn-link text-danger p-0 mr-2" ng-click="form.removeItem($index)">
													<i class="fas fa-times"></i>
												</button>
												<% s.service.name %>
												<div><b>Gói: </b><% s.group.name %></div>
											</td>
											<td ng-if="s.is_product">
												<button class="btn btn-link text-danger p-0 mr-2" ng-click="form.removeItem($index)">
													<i class="fas fa-times"></i>
												</button>
												<% s.product.name %>
											</td>
											<td ng-if="s.is_other">
												<div class="d-flex flex-nowrap">
													<button class="btn btn-link text-danger p-0 mr-2" ng-click="form.removeItem($index)">
														<i class="fas fa-times"></i>
													</button>
													<input class="form-control" type="text" ng-model="s.name">
												</div>
												<span class="invalid-feedback d-block" role="alert">
													<strong><% errors['list.' + $index + '.name'][0] %></strong>
												</span>
											</td>
											<td class="text-center">
												<input style="width: 55px;margin: 0 auto" class="form-control text-center" type="text" ng-model="s.qty" ng-change="form.calculatePromo()">
												<span class="invalid-feedback d-block" role="alert">
													<strong><% errors['list.' + $index + '.qty'][0] %></strong>
												</span>
											</td>
											<td class="text-right" ng-if="!s.is_other"><% s.price | number %></td>
											<td class="text-right" ng-if="s.is_other">
												<input class="form-control text-right" type="text" ng-model="s.price" ng-change="form.calculatePromo()">
												<span class="invalid-feedback d-block" role="alert">
													<strong><% errors['list.' + $index + '.price'][0] %></strong>
												</span>
											</td>
										</tr>
										<tr ng-if="!form.list.length">
											<td colspan="3" class="text-center">Chưa có dữ liệu</td>
										</tr>
										<tr>
											<td colspan="3" class="text-center">
												<a href="javascript:void(0)" ng-click="form.addOther()">
													<i class="fa fa-plus"></i>Thêm mục khác
												</a>
											</td>
										</tr>
										<tr ng-if="form.promo_products.length">
											<td colspan="3"><b>Khuyến mãi</b></td>
										</tr>
										<tr ng-repeat="s in form.promo_products track by $index">
											<td>
												<% s.product.name || s.product_name %>
											</td>
											<td class="text-center"><% s.qty | number %></td>
											<td class="text-right">0</td>
										</tr>
										<!-- <tr style="background: #f2f2f2">
											<td colspan="2" class="text-center">Tổng số lượng: </td>
											<td><b><% form.total_qty | number %></b></td>
										</tr> -->
										<tr style="background: #f2f2f2">
											<td colspan="2" class="text-center">Tổng giá trị:</td>
											<td><b><% form.total_cost | number %></b></td>
										</tr>
										<tr style="background: #f2f2f2">
											<td colspan="2" class="text-center">Chương trình khuyến mãi ({{ App\Model\Common\PromoCampaign::searchByFilter(new \Illuminate\Http\Request(['type' => 'use']))->count() }}):</td>
											<td>
												<a href="javascript:void(0)" ng-click="searchPromo.open()">
													<span ng-if="!form.promo">Chọn chương trình</span>
													<span ng-if="form.promo"><% form.promo.name %></span>
												</a>
												<a href="javascript:void(0)" class="text-danger ml-2" ng-if="form.promo" ng-click="form._promo = null">
													Hủy
												</a>
											</td>
										</tr>
									</tbody>
								</table>
								<span class="invalid-feedback d-block" role="alert">
									<strong><% errors.list[0] %></strong>
								</span>
							</div>
						</div>
						<div class="card customize-card-sale approve-bill-info">
							<div class="card-header text-center">
								<h6 class="card-title">Duyệt hóa đơn</h6>
								<i class="fas fa-angle-double-down" id="show-bill-info"></i>
							</div>
							<!-- /.card-header -->
							{{-- <div class="card-body card-body-bill">
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group custom-group custom-group-sale">
											<label for="my-input">Ngày tạo hóa đơn</label>
											<input class="form-control" date type="text" ng-model="form.bill_date">
											<i class="far fa-calendar-alt"></i>
											<span class="invalid-feedback d-block" role="alert">
												<strong><% errors.bill_date[0] %></strong>
											</span>
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group custom-group custom-group-sale">
											<label>Thành tiền</label>
											<input class="form-control text-right" type="text" value="<% form.service_total_cost | number %>" disabled>
											<span class="invalid-feedback d-block" role="alert">
												<strong><% errors.total_cost[0] %></strong>
											</span>
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group custom-group custom-group-sale">
											<label>Giảm giá</label>
											<input class="form-control text-right" type="text" ng-model="form.sale_cost">
											<span class="invalid-feedback d-block" role="alert">
												<strong><% errors.sale_cost[0] %></strong>
											</span>
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group custom-group custom-group-sale">
											<label>Thành tiền sau giảm giá</label>
											<input class="form-control text-right" type="text" value="<% form.cost_after_sale | number %>" disabled>
											<span class="invalid-feedback d-block" role="alert">
												<strong><% errors.cost_after_sale[0] %></strong>
											</span>
										</div>
									</div>
									<div class="col-md-12 col-sm-12">
										<div class="form-group custom-group custom-group-sale">
											<label>VAT</label>
											<div class="input-group mb-3">
												<input type="text" class="form-control text-right" ng-model="form.vat_percent">
												<span class="input-group-text">%</span>
												<input type="text" class="form-control text-right" value="<% form.vat_cost | number %>" disabled>
											</div>
											<span class="invalid-feedback d-block" role="alert">
												<strong><% errors.cost_after_sale[0] %></strong>
											</span>
										</div>
									</div>
									<div class="col-md-12 col-sm-12">
										<div class="form-group custom-group custom-group-sale">
											<label>Tổng thanh toán</label>
											<input class="form-control text-right" type="text" value="<% form.cost_after_vat | number %>" disabled>
											<span class="invalid-feedback d-block" role="alert">
												<strong><% errors.cost_after_vat[0] %></strong>
											</span>
										</div>
									</div>
									<div class="col-md-12 col-sm-12">
										<div class="form-group custom-group custom-group-sale">
											<label class="form-label">Ghi chú</label>
											<textarea class="form-control" rows="2" ng-model="form.note"></textarea>
										</div>
									</div>
								</div>
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
									<a href="{{ route('Bill.index') }}" class="btn btn-danger btn-cons">
							<i class="fas fa-window-close"></i> Quay lại
							</a>
						</div>
					</div> --}}
				</div>
			</div>
			<div class="bill-info col-md-12 col-sm-12 col-xs-12" id="bill-info">
				<div class="card customize-card-sale approve-bill-info">
					<div class="card-header text-center">
						<h6 class="card-title">Duyệt hóa đơn</h6>
						{{-- <i class="fas fa-angle-double-down" id="show-bill-info"></i> --}}
					</div>
					<!-- /.card-header -->
					<div class="card-body card-body-bill">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group custom-group custom-group-sale">
									<label for="my-input">Ngày tạo hóa đơn</label>
									<input class="form-control" datetime-form type="text" ng-model="form.bill_date">
									<i class="far fa-calendar-alt"></i>
									<span class="invalid-feedback d-block" role="alert">
										<strong><% errors.bill_date[0] %></strong>
									</span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group custom-group custom-group-sale">
									<label>Thành tiền</label>
									<input class="form-control text-right" type="text" value="<% form.total_cost | number %>" disabled>
									<span class="invalid-feedback d-block" role="alert">
										<strong><% errors.total_cost[0] %></strong>
									</span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group custom-group custom-group-sale">
									<label>Giảm giá</label>
									<input class="form-control text-right" type="text" ng-model="form.sale_cost">
									<span class="invalid-feedback d-block" role="alert">
										<strong><% errors.sale_cost[0] %></strong>
									</span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group custom-group custom-group-sale">
									<label>Thành tiền sau giảm giá</label>
									<input class="form-control text-right" type="text" value="<% form.cost_after_sale | number %>" disabled>
									<span class="invalid-feedback d-block" role="alert">
										<strong><% errors.cost_after_sale[0] %></strong>
									</span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6" ng-if="form.promo && form.promo.type == 1">
								<div class="form-group custom-group custom-group-sale">
									<label>Chiết khấu</label>
									<input class="form-control text-right" type="text" ng-value="form.promo_value | number" disabled>
									<span class="invalid-feedback d-block" role="alert">
										<strong><% errors.promo_value[0] %></strong>
									</span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6" ng-if="form.promo && form.promo.type == 1">
								<div class="form-group custom-group custom-group-sale">
									<label>Thành tiền sau chiết khấu</label>
									<input class="form-control text-right" type="text" value="<% form.cost_after_promo | number %>" disabled>
									<span class="invalid-feedback d-block" role="alert">
										<strong><% errors.cost_after_promo[0] %></strong>
									</span>
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group custom-group custom-group-sale">
									<label>VAT</label>
									<div class="input-group mb-3">
										<input type="text" class="form-control text-right" ng-model="form.vat_percent">
										<span class="input-group-text">%</span>
										<input type="text" class="form-control text-right" value="<% form.vat_cost | number %>" disabled>
									</div>
									<span class="invalid-feedback d-block" role="alert">
										<strong><% errors.cost_after_sale[0] %></strong>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group custom-group custom-group-sale">
									<label>Tổng thanh toán</label>
									<input class="form-control text-right" type="text" value="<% form.cost_after_vat | number %>" disabled>
									<span class="invalid-feedback d-block" role="alert">
										<strong><% errors.cost_after_vat[0] %></strong>
									</span>
								</div>
							</div>
							<div class="col-sm-2 col-xs-12">
								<div class="form-check">
									<input id="allow-point" class="form-check-input ng-valid ng-dirty ng-valid-parse ng-touched" type="checkbox" ng-model="form.allow_point"  ng-true-value="1" ng-false-value="0" ng-disabled="!form.customer_id" >
									<label for="allow-point" class="form-check-label" >Thanh toán bằng điểm</label>
									<br><label for="">Số điểm hiện có: <% form.points %></label>
								</div>
							</div>

							<div class="col-md-3 col-sm-12">
								<div class="form-group custom-group custom-group-sale">
									<label>Số điểm thanh toán</label>
									<input class="form-control text-right" type="text" value="<% form.point_pay %>" ng-disabled="!form.allow_point" ng-model="form.point_pay">
									<span class="invalid-feedback d-block" role="alert">
										<strong><% errors.point_pay[0] %></strong>
									</span>
								</div>
							</div>

							<div class="col-md-3 col-sm-12">
								<div class="form-group custom-group custom-group-sale">
									<label>Số tiền quy đổi</label>
									<input class="form-control text-right " type="text" value="<% form.point_monney | number %>" ng-model="form.point_money" ng-disabled="true">
									<span class="invalid-feedback d-block" role="alert">
										<strong><% errors.point_monney[0] %></strong>
									</span>
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group custom-group custom-group-sale">
									<label class="form-label">Ghi chú</label>
									<textarea class="form-control" rows="2" ng-model="form.note"></textarea>
								</div>
							</div>
						</div>
						<hr>
						<div class="text-center">

							<button type="submit" class="btn btn-primary btn-cons" ng-click="submit(3)" ng-disabled="loading.submit">
								<i ng-if="!loading.submit" class="fa fa-save"></i>
								<i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
								Lưu
							</button>
							<button type="submit" class="btn btn-success btn-cons" ng-click="submit(1)" ng-disabled="loading.submit">
								<i ng-if="!loading.submit" class="fas fa-check-double"></i>
								<i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
								Duyệt
							</button>

							<a href="{{ route('Bill.index') }}" class="btn btn-danger btn-cons">
								<i class="fas fa-window-close"></i> Hủy
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
@include('g7.funds.receipt_vouchers.quick_receipt')
