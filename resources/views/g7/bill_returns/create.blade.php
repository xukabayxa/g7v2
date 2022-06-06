@extends('layouts.main')

@section('css')

@endsection
@section('title')
Tạo hóa đơn trả
@endsection
@section('content')
<div ng-controller="G7" ng-cloak>
  @include('g7.bill_returns.form')
</div>
@endsection
@section('script')
@include('partial.classes.g7.BillReturn')
<script>
  app.controller('G7', function ($scope, $rootScope, $http) {

    $scope.form = new BillReturn({});

    @include('g7.bill_returns.formJs')

    $scope.searchBill = new BaseSearchModal(
        {
			title: "Hóa đơn",
			ajax: {
				url: "{!! route('Bill.searchData') !!}",
				data: function (d, context) {
					DATATABLE.mergeSearch(d, context);
					d.type = 'return';
				}
			},
			columns: [
				{data: 'DT_RowIndex', orderable: false, title: "STT"},
				{data: 'code', title: 'Số hóa đơn'},
				{data: 'license_plate', title: "Biển số xe"},
				{data: 'customer_name', title: "Khách hàng"},
				{data: 'cost_after_vat', title: 'Tổng thanh toán'},
				{data: 'created_by', title: "Người lập"},
				{data: 'bill_date', title: "Thời gian ghi nhận"},
			],
			search_columns: [
				{data: 'code', search_type: "text", placeholder: "Số hóa đơn"},
				{data: 'license_plate', search_type: "text", placeholder: "Biển số xe"},
				{data: 'customer_name', search_type: "text", placeholder: "Khách hàng"},
				{
					data: 'created_by', search_type: "select", placeholder: "Người lập",
					column_data: USERS
				},
			]
		},
        function(obj) {
            $scope.chooseBill(obj);
        }
    );

    $scope.chooseBill = function(obj) {
		sendRequest({
			type: 'GET',
			url: `/g7/bills/${obj.id}/getDataForReturn`,
			success: function(response) {
				if (response.success) {
					$scope.form.useBill(response.data);
					$scope.searchBill.close();
					toastr.success('Thêm thành công');
					$scope.$applyAsync();
				}
			}
		});
    }

    $scope.submit = function(status) {
		$scope.loading.submit = true;
		let data = $scope.form.submit_data;
		data.status = status;
		$.ajax({
			type: 'POST',
			url: "{!! route('BillReturn.store') !!}",
			headers: {
				'X-CSRF-TOKEN': CSRF_TOKEN
			},
			data: data,
			success: function(response) {
			if (response.success) {
				toastr.success(response.message);
				window.location.href = "{{ route('BillReturn.index') }}";
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

	if (getParam('bill_id')) {
		$scope.chooseBill({id: getParam('bill_id')});
	}
  });
</script>
@endsection
