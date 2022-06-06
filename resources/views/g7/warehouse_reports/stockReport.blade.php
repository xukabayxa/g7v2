@extends('layouts.main')

@section('css')
<link rel="stylesheet" href="{{ asset('libs/pagination/pagination.css') }}">
@endsection

@section('title')
    Báo cáo tồn kho
@endsection

@section('content')
<div ng-controller="Warehouse" ng-cloak>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Bộ lọc</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label>Tính đến ngày:</label>
                                <input class="form-control" date ng-model="form.to_date">
                            </div>
                        </div> -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tên hàng:</label>
                                <input class="form-control" ng-model="form.product_name" ng-keyup="$event.keyCode === 13 && filter(1)">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mã hàng:</label>
                                <input class="form-control" ng-model="form.product_code" ng-keyup="$event.keyCode === 13 && filter(1)">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-right">
						<a href="<% exportExcelURL() %>" target="_blank" class="btn btn-primary" ng-disabled="loading.search">
                            <i ng-if="!loading.search" class="fas fa-file-excel"></i>
                            <i ng-if="loading.search" class="fa fa-spinner fa-spin"></i>
                            Xuất excel
                        </a>
                        <button class="btn btn-primary" ng-click="filter(1)" ng-disabled="loading.search">
                            <i ng-if="!loading.search" class="fa fa-filter"></i>
                            <i ng-if="loading.search" class="fa fa-spinner fa-spin"></i>
                            Lọc
                        </button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Chi tiết</h4>
                </div>
                <div class="card-body">
                    <table class="table table-condensed table-bordered table-head-border">
						<thead class="sticky-thead">
							<tr>
								<th>Tên hàng hóa</th>
                                <th>Mã hàng</th>
								<th>Đơn vị</th>
                                <th>Tồn</th>
								<th>Tổng SL nhập</th>
								<th>Tổng SL xuất</th>
								<th>Tổng giá trị kho</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-if="loading.search">
								<td colspan="7"><i class="fa fa-spin fa-spinner"></i> Đang tải dữ liệu</td>
							</tr>
							<tr ng-if="!loading.search && products && !products.length">
								<td colspan="7">Chưa có dữ liệu</td>
							</tr>
							<tr ng-if="!loading.search && products && products.length" ng-repeat="product in products">
								<td><% product.product_name %></td>
                                <td><% product.product_code %></td>
								<td><% product.unit_name %></td>
								<td class="text-center"><% product.stock_qty | number %></td>
								<td class="text-center"><% product.import_qty | number %></td>
								<td class="text-center"><% product.export_qty | number %></td>
								<td class="text-right"><% product.stock_value | number %></td>
							</tr>
							<tr ng-if="!loading.search && products && products.length">
								<td class="text-center" colspan="3"><b>Tổng cộng</b></td>
								<td class="text-center"><b><% summary.stock_qty | number %></b></td>
								<td class="text-center"><b><% summary.import_qty | number %></b></td>
								<td class="text-center"><b><% summary.export_qty | number %></b></td>
								<td class="text-right"><b><% summary.stock_value | number %></b></td>
							</tr>
						</tbody>
					</table>
					<div class="text-right mt-2">
						<ul uib-pagination ng-change="pageChanged()" total-items="total_items" ng-model="current.page" max-size="10"
							class="pagination-sm" boundary-links="true" items-per-page="per_page" previous-text="‹" next-text="›" first-text="«" last-text="»">
						</ul>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('libs/pagination/ui-bootstrap.min.js') }}"></script>
@include('partial.classes.g7.WarehouseReport')
<script>
    angular.module("App").requires.push('ui.bootstrap');
    app.controller('Warehouse', function ($scope) {
        $scope.form = new WarehouseReport({});
		$scope.products = [];

        @include('g7.warehouse_reports.js')

		$scope.filter = function(page = 1) {
			draw++;
			$scope.current.page = page;
			$scope.loading.search = true;
			$.ajax({
                type: 'GET',
                url: "{{ route('WarehouseReport.stockReportSearchData') }}",
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: {
					...$scope.form.submit_data,
					per_page: $scope.per_page,
					current_page: $scope.current.page,
					draw: draw
				},
                success: function(response) {
                    if (response.success && response.draw == draw) {
						$scope.products = response.data.data;
						$scope.total_items = response.data.total;
						$scope.current.page = response.data.current_page;
						$scope.summary = response.total;
					}
				},
				error: function(err) {
					toastr.error('Đã có lỗi xảy ra');
				},
				complete: function() {
					$scope.loading.search = false;
					$scope.$applyAsync();
				}
            });
        }

		$scope.filter(1);

		$scope.pageChanged = function() {
			$scope.filter($scope.current.page);
		};

		$scope.exportExcelURL = function() {
            const params = $scope.form.submit_data;
            return `{{ route('WarehouseReport.stockReportExcel') }}?${$.param(params)}`;
        }
    })
</script>
@endsection
