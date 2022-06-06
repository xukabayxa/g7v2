@extends('layouts.main')

@section('css')
<link rel="stylesheet" href="{{ asset('libs/pagination/pagination.css') }}">
@endsection

@section('title')
    Sổ quỹ
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
						<div class="col-md-3">
                            <div class="form-group custom-group">
                                <label>Hình thức thanh toán:</label>
                                <select class="form-control custom-select" ng-model="form.payment_method">
									<option value="">Chọn hình thức</option>
									<option ng-repeat="e in payment_methods" value="<% e.id %>"><% e.name %></option>
								</select>
                            </div>
                        </div>
						<div class="col-md-3">
                            <div class="form-group custom-group">
                                <label>Người nộp/nhận:</label>
                                <input class="form-control" ng-model="form.object_name">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group custom-group">
                                <label>Loại phiếu:</label>
                                <input class="form-control" ng-model="form.type">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group custom-group">
                                <label>Mã phiếu:</label>
                                <input class="form-control" ng-model="form.code">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-right">
                        <button class="btn btn-success" ng-click="filter(1, true)" ng-disabled="loading.search">
                            Tất cả
                        </button>
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
								<th>STT</th>
								<th>Loại phiếu</th>
								<th>Ngày ghi nhận</th>
                                <th>Ngày tạo</th>
								<th>Mã phiếu</th>
                                <th>Người nộp/nhận</th>
								<th>Hình thức thanh toán</th>
								<th>Tiền thu</th>
								<th>Tiền chi</th>
								<th>Mô tả</th>
								<th>Tham chiếu</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-if="loading.search">
								<td colspan="11"><i class="fa fa-spin fa-spinner"></i> Đang tải dữ liệu</td>
							</tr>
							<tr ng-if="!loading.search && details && !details.length">
								<td colspan="11">Chưa có dữ liệu</td>
							</tr>
							<tr ng-if="!loading.search && details && details.length" ng-repeat="d in details">
								<td class="text-center"><% $index + 1 + current.page * (per_page - 1) %></td>
								<td><% d.type_name %></td>
                                <td><% d.record_date | toDate | date:'dd/MM/yyyy' %></td>
								<td><% d.created_at | toDate | date:'dd/MM/yyyy' %></td>
								<td>
									<a href="javascript:void(0)" ng-if="d.type == 1" ng-click="showReceiptVoucher(d.record_id)"><% d.record_code %></a>
									<a href="javascript:void(0)" ng-if="d.type == 2" ng-click="showPaymentVoucher(d.record_id)"><% d.record_code %></a>
								</td>
								<td><% d.object_name %></td>
								<td><% getPayType(d.pay_type) %></td>
								<td class="text-right"><% d.type == 1 ? (d.value | number) : '-' %></td>
								<td class="text-right"><% d.type == 2 ? (d.value | number) : '-' %></td>
								<td><% d.note %></td>
								<td>
									<a href="#" ng-if="d.type == 1"><% d.ref_code %></a>
									<a href="#" ng-if="d.type == 2"><% d.ref_code %></a>
								</td>
							</tr>
							<tr ng-if="!loading.search && details && details.length">
								<td class="text-center" colspan="5"><b>Tổng cộng</b></td>
								<td class="text-right" colspan="2"><b>Tồn đầu: <% summary.before | number %></b></td>
								<td class="text-right"><b><% summary.income | number %></b></td>
								<td class="text-right"><b><% summary.spending | number %></b></td>
								<td class="text-right" colspan="2"><b>Tồn cuối: <% getAfter() | number %></b></td>
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

    @include('g7.warehouse_reports.payment_voucher_show')
    @include('g7.warehouse_reports.receipt_vouchers_show')

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
		$scope.payment_methods = PAYMENT_METHODS;

        @include('g7.warehouse_reports.js')

		$scope.filter = function(page = 1, all = false) {
			draw++;
			$scope.current.page = page;
			$scope.loading.search = true;
            if(! all) {

                $.ajax({
                    type: 'GET',
                    url: "{{ route('WarehouseReport.fundReportSearchData') }}",
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
            } else {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('WarehouseReport.fundReportSearchData') }}",
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: {
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

        }

		$scope.getPayType = function(type) {
			return (PAYMENT_METHODS.find(val => val.id == type) || {}).name;
		}

		$scope.filter(1);

		$scope.pageChanged = function() {
			$scope.filter($scope.current.page);
		};

		$scope.exportExcelURL = function() {
            const params = $scope.form.submit_data;
            return `{{ route('WarehouseReport.fundReportExcel') }}?${$.param(params)}`;
        }

		$scope.getAfter = function() {
			if (!$scope.summary) return 0;
			return Number($scope.summary.before) + Number($scope.summary.income) - Number($scope.summary.spending);
		}

        $scope.showPaymentVoucher = function(id) {
            sendRequest({
                type: "GET",
                url: "/g7/funds/payment-vouchers/" + id + "/show",
                success: function(response) {
                    if (response.success) {
                        $scope.pv = response.data;
                        $scope.pv.recipient_type_name = response.recipient_type_name;
                        $('#show-modal').modal('show');
                    }
                }
            }, $scope);
        }

        $scope.showReceiptVoucher = function(id) {
            $.ajax({
                type: 'GET',
                url: "/g7/funds/receipt-vouchers/" + id + "/show",
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: id,
                success: function(response) {
                    if (response.success) {
                        $scope.rv = response.data;
                        $scope.rv.payer_type_name = response.payer_type_name;
                        $('#show-modal2').modal('show');
                    } else {
                        toastr.warning(response.message);
                        $scope.errors = response.errors;
                    }
                },
                error: function(e) {
                    toastr.error('Đã có lỗi xảy ra');
                },
                complete: function() {
                    $scope.loading.submit = false;
                    $scope.$applyAsync();
                }
            });
        }

    })
</script>
@endsection
