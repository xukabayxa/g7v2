@extends('layouts.main')

@section('css')
<link rel="stylesheet" href="{{ asset('libs/pagination/pagination.css') }}">
@endsection

@section('title')
    Báo cáo bán hàng
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
						<div class="col-md-3">
                            <div class="form-group custom-group">
                                <label>Từ ngày:</label>
                                <input class="form-control" date ng-model="form.from_date">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group custom-group">
                                <label>Đến ngày:</label>
                                <input class="form-control" date ng-model="form.to_date">
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
								<th>Ngày</th>
                                <th>Doanh thu trước giảm giá</th>
								<th>Giảm giá</th>
                                <th>Tổng doanh thu</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-if="loading.search">
								<td colspan="4"><i class="fa fa-spin fa-spinner"></i> Đang tải dữ liệu</td>
							</tr>
							<tr ng-if="!loading.search && details && !details.length">
								<td colspan="4">Chưa có dữ liệu</td>
							</tr>
							<tr ng-if="!loading.search && details && details.length" ng-repeat="d in details">
								<td class="text-center"><% d.day | date:'dd/MM/yyyy' %></td>
                                <td class="text-right"><% d.total_cost | number %></td>
								<td class="text-right"><% d.sale_cost | number %></td>
								<td class="text-right"><% d.cost_after_sale | number %></td>
							</tr>
							<tr ng-if="!loading.search && details && details.length">
								<td class="text-center"><b>Tổng cộng</b></td>
								<td class="text-right"><b><% summary.total_cost | number %></b></td>
								<td class="text-right"><b><% summary.sale_cost | number %></b></td>
								<td class="text-right"><b><% summary.cost_after_sale | number %></b></td>
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
		$scope.details = [];

        @include('g7.warehouse_reports.js')

		$scope.filter = function(page = 1) {
			draw++;
			$scope.current.page = page;
			$scope.loading.search = true;
			$.ajax({
                type: 'GET',
                url: "{{ route('WarehouseReport.saleReportSearchData') }}",
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
						$scope.details = response.data.data;
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

		$scope.exportExcelURL = function() {
            const params = $scope.form.submit_data;
            return `{{ route('WarehouseReport.saleReportExcel') }}?${$.param(params)}`;
        }

		$scope.filter(1);

		$scope.pageChanged = function() {
			$scope.filter($scope.current.page);
		};
    })
</script>
@endsection
