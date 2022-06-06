@extends('layouts.main')

@section('css')

@endsection

@section('title')
Chỉnh sửa mẫu in
@endsection
@section('content')
<div ng-controller="PrintTemplate" ng-cloak>
  @include('uptek.print_templates.form')
</div>
@endsection
@section('script')
@include('partial.classes.uptek.PrintTemplate')
<script>
  app.controller('PrintTemplate', function ($scope, $http) {
    $scope.form = new PrintTemplate(@json($object), {scope: $scope});
    $scope.loading = {};

    $scope.submit = function(publish = 0) {
      $scope.loading.submit = true;
      let data = $scope.form.submit_data;
      $.ajax({
        type: 'POST',
        url: "{!! route('PrintTemplate.update', $object->id) !!}",
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        data: data,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
            window.location.href = "{{ route('PrintTemplate.index') }}";
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
