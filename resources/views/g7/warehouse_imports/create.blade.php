@extends('layouts.main')

@section('css')

@endsection
@section('title')
Tạo phiếu nhập hàng
@endsection
@section('content')
<div ng-controller="WareHouseImport" ng-cloak>
  @include('g7.warehouse_imports.form')
</div>
@include('g7.funds.payment_vouchers.quick_payment')
@include('g7.suppliers.create_supplier')
@endsection
@section('script')
@include('partial.classes.g7.WareHouseImport')
@include('partial.classes.g7.Supplier')

<script>
  createQuickPaymentCallback = (response) => {
    window.location.href = "{{ route('WareHouseImport.index') }}";
  }
  app.controller('WareHouseImport', function ($rootScope, $scope, $http) {
    $scope.form = new WareHouseImport({});
    $scope.customers = @json(\App\Model\Common\Customer::getForSelect());

    @include('g7.warehouse_imports.formJs')

    $scope.submit = function(status) {
    $scope.loading.submit = true;
	  let data = $scope.form.submit_data;
	  data.status = status
      $.ajax({
        type: 'POST',
        url: "{!! route('WareHouseImport.store') !!}",
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        data: data,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
			if (status == 1) {
				// Quick Paymment
				swal({
					title: "Tạo nhanh phiếu chi",
					text: "Bạn có muốn tạo phiếu chi tiền?",
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
						data.payment_voucher_type_id = 1;
						data.recipient_type_id = 3;
						data.recipient_id = response.data.supplier_id;
						$rootScope.$emit("quickPayWhenImport", data);
						$("#quick-payment-voucher").modal('show');

					} else {
						window.location.href = "{{ route('WareHouseImport.index') }}";
					}
          		})
			} else window.location.href = "{{ route('WareHouseImport.index') }}";

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
