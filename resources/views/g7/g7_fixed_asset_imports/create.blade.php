@extends('layouts.main')

@section('css')

@endsection
@section('title')
Tạo phiếu nhập tài sản cố định
@endsection
@section('content')
<div ng-controller="G7" ng-cloak>
  @include('g7.g7_fixed_asset_imports.form')
</div>
@include('g7.suppliers.create_supplier')
@endsection

@section('script')
@include('partial.classes.g7.G7FixedAssetImport')
@include('partial.classes.g7.Supplier')
<script>
  app.controller('G7', function ($rootScope, $scope, $http) {
    $scope.form = new G7FixedAssetImport({});

    @include('g7.g7_fixed_asset_imports.formJs')

    $scope.submit = function(status) {
      $scope.loading.submit = true;
	  let data = $scope.form.submit_data;
	  data.status = status
      $.ajax({
        type: 'POST',
        url: "{!! route('G7FixedAssetImport.store') !!}",
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        data: data,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
			window.location.href = "{{ route('G7FixedAssetImport.index') }}";
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