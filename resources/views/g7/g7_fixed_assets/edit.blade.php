@extends('layouts.main')

@section('css')

@endsection

@section('title')
Chỉnh sửa tài sản cố định {{ $object->code }}
@endsection
@section('content')
<div ng-controller="FixedAsset" ng-cloak>
  @include('g7.g7_fixed_assets.form')
</div>
@endsection
@section('script')
@include('partial.classes.G7.G7FixedAsset')
<script>
  app.controller('FixedAsset', function ($scope, $http) {
    $scope.form = new G7FixedAsset(@json($object), {scope: $scope});
    @include('g7.g7_fixed_assets.formJs')

    $scope.submit = function() {
      $scope.loading.submit = true;
      $.ajax({
        type: 'POST',
        url: "{!! route('G7FixedAsset.update', $object->id) !!}",
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        processData: false,
        contentType: false,
        data: $scope.form.submit_data,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
            window.location.href = "{{ route('G7FixedAsset.index') }}";
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
