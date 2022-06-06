@extends('layouts.main')

@section('css')

@endsection

@section('title')
Thêm mới tài sản cố định
@endsection
@section('content')
<div ng-controller="FixedAsset" ng-cloak>
    @include('g7.g7_fixed_assets.form')
</div>
@endsection
@section('script')
@include('partial.classes.g7.G7FixedAsset')
<script>
  app.controller('FixedAsset', function ($scope, $http) {

    $scope.form = new G7FixedAsset({}, {scope: $scope});

    let options = {
      title: "Tìm kiếm tài sản cố định",
      ajax: {
          url: "{!! route('FixedAsset.searchData') !!}",
          data: function (d, context) {
              DATATABLE.mergeSearch(d, context);
              d.status = 1;
          }
      },
      columns: [
          {data: 'DT_RowIndex', orderable: false, title: "STT"},
          {data: 'name', title: "Tên"},
          {data: 'code', title: "Mã"},
      ],
      search_columns: [
          {data: 'name', search_type: "text", placeholder: "Tên"},
          {data: 'code', search_type: "text", placeholder: "Mã"},
      ]
    };

    $scope.searchFixedAsset = new BaseSearchModal(
        options,
        function(obj) {
            $scope.chooseFixedAsset(obj);
        }
    );

    $scope.chooseFixedAsset = function(obj) {
      sendRequest({
          type: 'GET',
          url: `/common/fixed-assets/${obj.id}/getDataForG7`,
          success: function(response) {
              if (response.success) {
                  $scope.form.useRootFixedAsset(response.data);
                  $scope.searchFixedAsset.close();
                  toastr.success('Thêm thành công');
                  $scope.$applyAsync();
              }
          }
      });
    }

    @include('g7.g7_fixed_assets.formJs')

    $scope.submit = function() {
      $scope.loading.submit = true;
      $.ajax({
        type: 'POST',
        url: "{!! route('G7FixedAsset.store') !!}",
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
