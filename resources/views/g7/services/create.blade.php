@extends('layouts.main')

@section('css')

@endsection

@section('title')
Thêm mới dịch vụ
@endsection
@section('content')
<div ng-controller="Service" ng-cloak>
  @include('g7.services.form')
</div>
@include('common.service_types.createServiceType')
@endsection

@section('script')
@include('partial.classes.uptek.Service')
<script>
  app.controller('Service', function ($scope, $http) {

    $scope.form = new Service({}, {scope: $scope});

    @include('g7.services.formJs')

    $scope.submit = function() {
      $scope.loading.submit = true;
      $.ajax({
        type: 'POST',
        url: "{!! route('G7Service.store') !!}",
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        data: $scope.form.submit_data,
        processData: false,
        contentType: false,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
            window.location.href = "{{ route('G7Service.index') }}";
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
