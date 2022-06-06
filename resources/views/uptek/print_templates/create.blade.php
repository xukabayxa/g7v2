@extends('layouts.main')

@section('title')
Thêm mới bài viết
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
    $scope.form = new Post({}, {scope: $scope});
    $scope.loading = {}

    $scope.submit = function(publish = 0) {
      $scope.loading.submit = true;
      let data = $scope.form.submit_data;
      data.append('publish', publish);
      $.ajax({
        type: 'POST',
        url: "{!! route('PrintTemplate.update') !!}",
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        data: data,
        processData: false,
        contentType: false,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
            window.location.href = "{{ route('Post.index') }}";
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
