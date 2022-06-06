@extends('layouts.main')

@section('css')

@endsection

@section('title')
Thêm mới hàng hóa
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

    $scope.form = new G7Product({}, {scope: $scope});

    let product_options = {
      title: "Tìm kiếm hàng hóa",
      ajax: {
          url: "{!! route('Product.searchData') !!}",
          data: function (d, context) {
              DATATABLE.mergeSearch(d, context);
              d.status = 1;
          }
      },
      columns: [
          {data: 'DT_RowIndex', orderable: false, title: "STT"},
          {data: 'name', title: "Tên hàng hóa"},
          {data: 'code', title: "Mã hàng hóa"},
          {data: 'category', title: "Loại hàng hóa"},
      ],
      search_columns: [
          {data: 'name', search_type: "text", placeholder: "Tên hàng hóa"},
          {data: 'code', search_type: "text", placeholder: "Mã hàng hóa"},
          {
              data: 'product_category_id', search_type: "select", placeholder: "Loại hàng hóa",
              column_data: @json(\App\Model\Common\ProductCategory::getForSelect())
          }
      ]
    };

    $scope.searchProduct = new BaseSearchModal(
        product_options,
        function(obj) {
            $scope.chooseProduct(obj);
        }
    );

    $scope.chooseProduct = function(obj) {
      sendRequest({
          type: 'GET',
          url: `/common/products/${obj.id}/getData`,
          success: function(response) {
              if (response.success) {
                  $scope.form.useRootProduct(response.data);
                  $scope.searchProduct.close();
                  toastr.success('Thêm thành công');
                  $scope.$applyAsync();
              }
          }
      });
    }

    @include('g7.products.formJs')

    $scope.submit = function() {
      $scope.loading.submit = true;
      $.ajax({
        type: 'POST',
        url: "{!! route('G7Product.store') !!}",
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
