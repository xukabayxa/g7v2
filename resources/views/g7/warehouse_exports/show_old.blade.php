@extends('layouts.main')

@section('css')

@endsection
@section('title')
Phiếu xuất kho {{ $object->code }}
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
													<th>Số lượng</th>
												</tr>
											</thead>
											<tbody>
												<tr ng-repeat="p in form.details">
													<td><% p.product.name %></td>
													<td><% p.product.code %></td>
													<td><% p.unit_name %></td>
													<td class="text-center"><% p.qty %></td>
												</tr>
												<tr ng-if="!form.details.length">
													<td colspan="4" class="text-center">Chưa có dữ liệu</td>
												</tr>
											</tbody>
										</table>
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
									<div class="form-group custom-group custom-group-sale" ng-if="form.type == 1">
										<div class="input-group mb-0">
											<input type="text" class="form-control" placeholder="Chọn hóa đơn" value="<% form.bill.code %>" disabled>
										</div>
									</div>
									<div class="form-group custom-group custom-group-sale">
										<label class="form-label">Ghi chú</label>
										<textarea class="form-control" rows="3" ng-model="form.note" disabled></textarea>
									</div>
									<hr>
									<div class="text-center">
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
</div>
@endsection
@section('script')
@include('partial.classes.g7.WarehouseExport')
<script>
  app.controller('G7', function ($scope, $rootScope, $http) {
    $scope.form = new WarehouseExport(@json($object), {mode: 'show'});
  });
</script>
@endsection
