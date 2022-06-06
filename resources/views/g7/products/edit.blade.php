@extends('layouts.main')

@section('css')

@endsection

@section('title')
Chỉnh sửa hàng hóa {{ $object->code }}
@endsection
@section('content')
<div ng-controller="Product" ng-cloak>
  @include('g7.products.form')
</div>
@endsection
@section('script')
@include('partial.classes.g7.G7Product')
<script>
  app.controller('Product', function ($scope, $http) {
    $scope.form = new G7Product(@json($object), {scope: $scope});
    @include('g7.products.formJs')
    $scope.submit = function() {
      $scope.loading.submit = true;
      $.ajax({
        type: 'POST',
        url: "{!! route('G7Product.update', $object->id) !!}",
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        processData: false,
        contentType: false,
        data: $scope.form.submit_data,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
            window.location.href = "{{ route('G7Product.index') }}";
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