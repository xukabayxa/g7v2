@extends('layouts.main')

@section('css')

@endsection

@section('title')
Cấu hình điểm tích lũy
@endsection
@section('content')
<div ng-controller="AccumulatePoint" ng-cloak>
  @include('uptek.accumulate_points.form')
</div>
@endsection
@section('script')
@include('partial.classes.uptek.AccumulatePoint')
<script>
  app.controller('AccumulatePoint', function ($scope, $http) {
    $scope.form = new AccumulatePoint(@json($object), {scope: $scope});
    console.log($scope.form);
    $scope.loading = {};

    $scope.submit = function() {
      $scope.loading.submit = true;
      console.log($scope.form.submit_data);
      $.ajax({
        type: 'POST',
        url: "{!! route('AccumulatePoint.update') !!}",
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        data: $scope.form.submit_data,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
            // window.location.href = "{{ route('AccumulatePoint.edit') }}"
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