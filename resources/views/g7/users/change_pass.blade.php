@extends('layouts.main')

@section('css')
@endsection

@section('title')
Thay đổi mật khẩu
@endsection

@section('page_title')
Thay đổi mật khẩu
@endsection

@section('content')
<div ng-controller="updatePass" ng-cloak>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6>Thay đổi mật khẩu</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 mb-3">
                            <div class="form-group custom-group">
                                <label class="form-label required-label">Mật khẩu hiện tại</label>
                                <div class="input-group mb-0">
                                    <input class="form-control" type="password" ng-model="form.old_password">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary show-password" type="button"><i class="fa fa-eye muted"></i></button>
                                    </div>
                                </div>
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong><% errors.old_password[0] %></strong>
                                </span>
                            </div>
                            <div class="form-group custom-group">
                                <label class="form-label required-label">Mật khẩu mới</label>
                                <div class="input-group mb-0">
                                    <input class="form-control" type="password" ng-model="form.password">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary show-password" type="button"><i class="fa fa-eye muted"></i></button>
                                    </div>
                                </div>
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong><% errors.password[0] %></strong>
                                </span>
                            </div>
                            <div class="form-group custom-group">
                                <label class="form-label required-label">Xác nhận mật khẩu mới</label>
                                <div class="input-group mb-0">
                                    <input class="form-control" type="password" ng-model="form.password_confirm">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary show-password" type="button"><i class="fa fa-eye muted"></i></button>
                                    </div>
                                </div>
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong><% errors.password_confirm[0] %></strong>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="text-right">
        <button type="submit" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
            <i ng-if="!loading.submit" class="fa fa-save"></i>
            <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
            Lưu
        </button>
        <a href="{{ route('User.index') }}" class="btn btn-danger btn-cons">
            <i class="fa fa-remove"></i> Hủy
        </a>
    </div>

</div>

@endsection

@section('script')
@include('partial.classes.g7.G7UpdatePass')
<script>
    app.controller('updatePass', function ($scope, $http) {
	$scope.form = new G7UpdatePass({}, {scope: $scope});
    $scope.loading = {};

	$scope.submit = function() {
		$scope.loading.submit = true;
		let data = $scope.form.submit_data;
		console.log(data);
		$.ajax({
			type: 'POST',
			url: "{!! route('G7User.updatePass') !!}",
			headers: {
				'X-CSRF-TOKEN': CSRF_TOKEN
			},
			data: data,
			success: function(response) {
				if (response.success) {
					toastr.success(response.message);
					window.location.href = back();
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