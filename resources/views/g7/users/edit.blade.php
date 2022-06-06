@extends('layouts.main')

@section('css')
@endsection

@section('title')
Sửa người dùng
@endsection

@section('content')
<div ng-controller="EditG7User" ng-cloak>
	@include('g7.users.form')
</div>

@endsection

@section('script')
@include('partial.classes.g7.G7User')
<script>
	app.controller('EditG7User', function ($scope, $http) {
	$scope.form = new G7User(@json($object), {scope: $scope, mode: "edit"});
	@include('g7.users.formJs')

	$scope.submit = function() {
		$scope.loading.submit = true;
		let data = $scope.form.submit_data;
		console.log(data);
		$.ajax({
			type: 'POST',
			url: "{!! route('G7User.update', $object->id) !!}",
			headers: {
				'X-CSRF-TOKEN': CSRF_TOKEN
			},
			data: data,
			success: function(response) {
				if (response.success) {
					toastr.success(response.message);
					window.location.href = "{{ route('G7User.index') }}";
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