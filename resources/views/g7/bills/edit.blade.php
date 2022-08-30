@extends('layouts.main')

@section('css')

@endsection

@section('title')
Chỉnh sửa hóa đơn {{ $object->code }}
@endsection
@section('content')
<div ng-controller="G7" ng-cloak>
  @include('g7.bills.form')
</div>
@include('common.cars.createCar')
@include('common.customers.createCustomer')
@include('common.license_plates.create_license_plate')
@endsection
@section('script')
@include('partial.classes.common.Customer')
@include('partial.classes.g7.Bill')
<script>
  createQuickReceiptCallback = (response) => {
    window.location.href = "{{ route('Bill.index') }}";
  }
  app.controller('G7', function ($scope, $rootScope, $http) {
    $scope.form = new Bill(@json($object), {scope: $scope});
	  $scope.cars = [$scope.form.car];

    @include('g7.bills.formJs')

    if($scope.form.car) {
      $scope.chooseCar({id: $scope.form.car.id});
    }

    $scope.submit = function(status) {
      $scope.loading.submit = true;
      let data = $scope.form.submit_data;
      data.status = status;
      $.ajax({
        type: 'POST',
        url: "{!! route('Bill.update', $object->id) !!}",
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        data: data,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
            // Quick Receipt
            if(data.status == 1) {
              swal({
                title: "Tạo nhanh phiếu thu",
                text: "Bạn có muốn tạo phiếu thu tiền?",
                type: "success",
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "Có",
                cancelButtonClass: "btn-danger",
                cancelButtonText: "Tạo sau",
                closeOnConfirm: true
            }, function(isConfirm) {
                if (isConfirm) {
                  let data = response.data;
                  data.receipt_voucher_type_id = 1;
                  data.payer_type_id = 1;
                  data.payer_id = response.data.customer_id;
                  $rootScope.$emit("openQuickReceipt", data);
                  $("#quick-receipt-voucher").modal('show');

                } else {
                  window.location.href = "{{ route('Bill.index') }}";
                }
            })
          } else {
            window.location.href = "{{ route('Bill.index') }}";
          }
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

	$scope.getServices();
  });
</script>
@endsection
