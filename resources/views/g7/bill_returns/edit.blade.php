@extends('layouts.main')

@section('css')

@endsection
@section('title')
Sửa hóa đơn trả {{ $object->code }}
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

    $scope.form = new BillReturn(@json($object));

    @include('g7.bill_returns.formJs')

    $scope.submit = function(status) {
		$scope.loading.submit = true;
		let data = $scope.form.submit_data;
		data.status = status;
		$.ajax({
			type: 'POST',
			url: "{!! route('BillReturn.update', $object->id) !!}",
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
  });
</script>
@endsection
