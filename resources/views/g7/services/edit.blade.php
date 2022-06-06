@extends('layouts.main')

@section('css')

@endsection

@section('title')
Chỉnh sửa thông tin dịch vụ
@endsection
@section('content')
<div ng-controller="Service" ng-cloak>
  @include('g7.services.form')
</div>
@endsection
@section('script')
@include('partial.classes.g7.G7Service')
<script>
  app.controller('Service', function ($scope, $http) {
    $scope.form = new G7Service(@json($object), {scope: $scope});

    @include('g7.services.formJs')

    $scope.submit = function() {
      $scope.loading.submit = true;
      $.ajax({
        type: 'POST',
        url: "{!! route('G7Service.update', $object->id) !!}",
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
