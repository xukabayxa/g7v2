@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý Level khách hàng
@endsection

@section('buttons')
<a href="{{ route('CustomerLevel.create') }}" class="btn btn-outline-success" data-toggle="modal" href="javascript:void(0)" data-target="#create-customer-level" class="btn btn-info" ng-click="errors = null"><i class="fa fa-plus"></i> Thêm mới</a>
<a href="{{ route('CustomerLevel.exportExcel') }}" class="btn btn-primary"><i class="fas fa-file-excel"></i> Xuất file excel</a>
<a href="{{ route('CustomerLevel.create') }}" class="btn btn-primary"><i class="far fa-file-pdf"></i> Xuất file pdf</a>
@endsection
@section('content')
<div ng-cloak>
    <div class="row" ng-controller="CustomerLevel">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table-list">
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Form tạo mới --}}
    @include('g7.customer_levels.create_customer_level')
    @include('g7.customer_levels.edit_customer_level')
</div>
@endsection

@section('script')
@include('partial.classes.g7.CustomerLevel')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('CustomerLevel.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {data: 'name', title: 'Tên'},
            {data: 'point', title: 'Mức điểm đạt'},
            {data: 'money', title: 'Giá trị mua tương ứng'},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: 'name', search_type: "text", placeholder: "Tên"},
		],
		search_by_time: false,
	}).datatable;

    createCustomerLevelCallback = (response) => {
        datatable.ajax.reload();
    }

    editCustomerLevelCallback = (response) => {
        datatable.ajax.reload();
    }

    app.controller('CustomerLevel', function ($scope,$rootScope,$http) {
        $scope.loading = {};
        $scope.form = {}
        $('#table-list').on('click', '.edit', function () {
            $scope.data = getRowData(this, datatable);
            $.ajax({
                type: 'GET',
                url: "/g7/customer-levels/" + $scope.data.id + "/getDataForEdit",
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: $scope.data.id,

                success: function(response) {
                if (response.success) {
                    $rootScope.$emit("editCustomerLevel", response.data);
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
            $scope.errors = null;
            $scope.$apply();
            $('#edit-customer-level').modal('show');
        });
    })
</script>
@include('partial.confirm')
@endsection
