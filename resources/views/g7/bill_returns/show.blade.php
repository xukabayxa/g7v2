@extends('layouts.main')

@section('css')

@endsection
@section('title')
Hóa đơn trả {{ $object->code }}
@endsection
@section('content')
<div ng-controller="G7" ng-cloak>
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
										<table class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>STT</th>
													<th>Tên hàng</th>
													<th>ĐVT</th>
													<th>Số lượng trả</th>
													<th>Đơn giá</th>
													<th>Thành tiền</th>
												</tr>
											</thead>
											<tbody>
												<tr ng-repeat="p in form.products">
													<td class="text-center"><% $index + 1 %></td>
													<td><% p.product_name %></td>
													<td><% p.unit_name %></td>
													<td class="text-center"><% p.qty %></td>
													<td class="text-right"><% p.price | number %></td>
													<td class="text-right"><% p.total_cost | number %></td>
												</tr>
												<tr ng-if="!form.products.length">
													<td colspan="6" class="text-center">Chưa có dữ liệu</td>
												</tr>
											</tbody>
										</table>
										<span class="invalid-feedback d-block" role="alert">
											<strong><% errors.products[0] %></strong>
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
										<div class="form-group custom-group custom-group-sale">
											<label for="my-input">Ngày tạo hóa đơn</label>
											<input class="form-control" datetime-form type="text" ng-model="form.bill_date" disabled>
											<i class="far fa-calendar-alt"></i>
										</div>
										<div class="input-group mb-0">
											<input type="text" class="form-control" placeholder="Chọn hóa đơn bán" value="<% form.bill.code %>" disabled>
										</div>
									</div>
									<div class="form-group custom-group custom-group-sale">
										<label class="form-label">Tổng tiền</label>
										<input class="form-control text-right" value="<% form.total_cost | number %>" disabled></textarea>
									</div>
									<div class="form-group custom-group custom-group-sale">
										<label class="form-label">VAT</label>
										<div class="input-group">
											<input type="text" class="form-control text-right" value="<% form.vat_percent | number %>" disabled>
											<span class="input-group-text">%</span>
											<input type="text" class="form-control text-right" value="<% form.vat_cost | number %>" disabled>
										</div>
									</div>
									<div class="form-group custom-group custom-group-sale">
										<label class="form-label">Tổng tiền sau VAT</label>
										<input class="form-control text-right" value="<% form.cost_after_vat | number %>" disabled></textarea>
									</div>
									<div class="form-group custom-group custom-group-sale">
										<label class="form-label">Ghi chú</label>
										<textarea class="form-control" rows="3" ng-model="form.note" disabled></textarea>
									</div>
									<hr>
									<div class="text-center">
										<a href="{{ route('BillReturn.index') }}" class="btn btn-danger btn-cons">
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
</div>
@endsection
@section('script')
@include('partial.classes.g7.BillReturn')
<script>
  app.controller('G7', function ($scope, $rootScope, $http) {
    $scope.form = new BillReturn(@json($object), {mode: 'show'});
  });
</script>
@endsection
