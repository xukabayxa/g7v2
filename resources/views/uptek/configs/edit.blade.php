@extends('layouts.main')

@section('css')

@endsection

@section('title')
Cấu hình chung
@endsection

@section('page_title')
Cấu hình chung
@endsection


@section('content')
<div ng-controller="Config" ng-cloak>
  @include('uptek.configs.form')
</div>
@endsection
@section('script')
@include('partial.classes.uptek.Config')
<script>
  app.controller('Config', function ($scope, $http) {
    $scope.form = new Config(@json($object), {scope: $scope});
    $scope.loading = {};

    $scope.submit = function() {
      $scope.loading.submit = true;
      console.log($scope.form.submit_data);
      $.ajax({
        type: 'POST',
        url: "{!! route('Config.update') !!}",
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        data: $scope.form.submit_data,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
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