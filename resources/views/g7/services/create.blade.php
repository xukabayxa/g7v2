@extends('layouts.main')

@section('css')

@endsection

@section('title')
Thêm mới dịch vụ
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
    $scope.form = new G7Service({}, {scope: $scope});
    let service_options = {
      title: "Tìm kiếm dịch vụ",
      ajax: {
          url: "{!! route('Service.searchData') !!}",
          data: function (d, context) {
              DATATABLE.mergeSearch(d, context);
              d.status = 1;
          }
      },
      columns: [
          {data: 'DT_RowIndex', orderable: false, title: "STT"},
          {data: 'name', title: "Tên dịch vụ"},
          {data: 'code', title: "Mã dịch vụ"},
          {data: 'service_type', title: "Loại dịch vụ"},
      ],
      search_columns: [
        {data: 'name', search_type: "text", placeholder: "Tên dịch vụ"},
        {data: 'code', search_type: "text", placeholder: "Mã dịch vụ"},
        {
          data: 'service_type', search_type: "select", placeholder: "Loại dịch vụ",
          column_data: @json(App\Model\Common\ServiceType::getForSelect())
        },
      ]
    };

    $scope.searchService = new BaseSearchModal(
        service_options,
        function(obj) {
            $scope.chooseService(obj);
        }
    );

    $scope.chooseService = function(obj) {
      sendRequest({
          type: 'GET',
          url: `/common/services/${obj.id}/getDataForG7Service`,
          success: function(response) {
              if (response.success) {
                $scope.form.useRootService(response.data);
                $scope.searchService.close();
                toastr.success('Thêm thành công');
                $scope.$applyAsync();
              } else toastr.warning(response.message);
          }
      });
    }

    @include('g7.services.formJs')

    $scope.submit = function() {
      $scope.loading.submit = true;
      $.ajax({
        type: 'POST',
        url: "{!! route('G7Service.store') !!}",
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