@extends('layouts.main')

@section('css')

@endsection
@section('title')
Tạo hóa đơn
@endsection
@section('page_class')
bill_page
@endsection
@section('content')
<div ng-controller="G7" ng-cloak>
  @include('g7.bills.form')
</div>

@include('g7.calendar_reminders.create_reminder')
@include('common.cars.createCar')
@include('common.customers.createCustomer')
@include('common.license_plates.create_license_plate')

@endsection
@section('script')
@include('partial.classes.common.Customer')
@include('partial.classes.g7.Bill')
@include('partial.classes.g7.CalendarReminder')

<script>
  createQuickReceiptCallback = (response) => {
    window.location.href = "{{ route('Bill.index') }}";
  }

  app.controller('G7', function ($scope, $rootScope, $http) {

    $scope.form = new Bill({});
    $scope.cars = [];

    createCustomerCallback = (response) => {
      $scope.form.customers.push(response);
      $scope.form.customer_id = response.id;
    }

    @include('g7.bills.formJs')

    $(document).ready(function (){
      $("#show-bill-info").click(function (){
        $('html, body').animate({
          scrollTop: $("#bill-info").offset().top
        }, 1000);
      });
    });

    $(document).on('click', `.approve-bill-info i#hide-bill-info`, function (e) {
      $(this).after( "<i class='fas fa-angle-double-down' id='show-bill-info'></i>" );
      $(this).remove();
      $('.approve-bill-info .card-body').hide();
    });

    $scope.createReminder = function() {
      let customer_id = $scope.form.customer_id;
      let car_id = $scope.form.car_id;
      $scope.data = {};
      $scope.data.customer_id = customer_id;
      $scope.data.car_id = car_id;
      $rootScope.$emit("createReminder", $scope.data);
    }

    $scope.submit = function(status) {
      $scope.loading.submit = true;
      let data = $scope.form.submit_data;
      data.status = status;
      $.ajax({
        type: 'POST',
        url: "{!! route('Bill.store') !!}",
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
                  window.location.href = "{{ route('Bill.index') }}"+'?bill_id='+response.data.id;
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
  });
</script>
@endsection
