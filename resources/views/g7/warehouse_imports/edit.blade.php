@extends('layouts.main')

@section('css')

@endsection

@section('title')
Chỉnh sửa phiếu nhập hàng
@endsection
@section('content')
<div ng-controller="WareHouseImport" ng-cloak>
  @include('g7.warehouse_imports.form')
</div>
@include('g7.suppliers.create_supplier')
@endsection

@section('script')
@include('partial.classes.g7.WareHouseImport')
@include('partial.classes.g7.Supplier')
<script>
  app.controller('WareHouseImport', function ($scope, $http) {
    $scope.form = new WareHouseImport(@json($object));

    @include('g7.warehouse_imports.formJs')

    $scope.submit = function(status) {
      $scope.loading.submit = true;
	  let data = $scope.form.submit_data;
	  data.status = status
      $.ajax({
        type: 'POST',
        url: "{!! route('WareHouseImport.update', $object->id) !!}",
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        data: data,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
            window.location.href = "{{ route('WareHouseImport.index') }}";
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
