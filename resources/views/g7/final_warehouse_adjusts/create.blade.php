@extends('layouts.main')

@section('css')

@endsection
@section('title')
Chốt vật tư tiêu hao
@endsection
@section('content')
<div ng-controller="G7" ng-cloak>
  @include('g7.final_warehouse_adjusts.form')
</div>
@endsection
@section('script')
@include('partial.classes.g7.FinalWarehouseAdjust')
<script>
  app.controller('G7', function ($scope, $rootScope, $http) {

    $scope.form = new FinalWarehouseAdjust({});

    @include('g7.final_warehouse_adjusts.formJs')

    $scope.getBills();

    $scope.submit = function() {
      $scope.loading.submit = true;
      let data = $scope.form.submit_data;
      $.ajax({
        type: 'POST',
        url: "{!! route('FinalWarehouseAdjust.store') !!}",
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        data: data,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
            window.location.href = "{{ route('FinalWarehouseAdjust.index') }}";
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
