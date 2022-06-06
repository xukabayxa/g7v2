@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý hồ sơ nhân viên
@endsection

@section('buttons')
<a href="{{ route('G7Employee.create') }}" class="btn btn-outline-success" data-toggle="modal" href="javascript:void(0)" data-target="#create-g7-employee" class="btn btn-info" ng-click="errors = null"><i class="fa fa-plus"></i> Thêm mới</a>
<a href="{{ route('G7Employee.exportExcel') }}" class="btn btn-primary"><i class="fas fa-file-excel"></i> Xuất file excel</a>
<a href="{{ route('G7Employee.create') }}" class="btn btn-primary"><i class="far fa-file-pdf"></i> Xuất file pdf</a>
@endsection
@section('content')
<div ng-cloak>
    <div class="row" ng-controller="G7Employee">
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
    @include('g7.g7_employees.create_g7_employee')
    @include('g7.g7_employees.edit_g7_employee')
    @include('g7.g7_employees.show')
</div>
@endsection

@section('script')
@include('partial.classes.g7.G7Employee')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('G7Employee.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {
                data: 'image', title: "Hình ảnh", orderable: false, className: "text-center",
                render: function (data) {
					return `<img src="${data.path}" style="max-width: 55px !important">`;
				}
            },
            {data: 'name', title: 'Tên'},
            {data: 'mobile', title: 'Điện thoại'},

            {
				data: 'status',
				title: "Trạng thái",
				render: function (data) {
					return getStatus(data, @json(App\Model\Uptek\G7Info::STATUSES));
				}
			},
			{data: 'updated_by', title: "Người sửa"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: 'name', search_type: "text", placeholder: "Tên nhân viên"},
            {data: 'mobile', search_type: "text", placeholder: "Số điện thoại"},
			{
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: @json(App\Model\Uptek\G7Info::STATUSES)
			}
		],
		search_by_time: false,
	}).datatable;
    app.controller('G7Employee', function ($scope, $rootScope, $http) {
        $scope.loading = {};
        $('#table-list').on('click', '.edit', function () {
            $scope.data = getRowData(this, datatable);

            sendRequest({
                type: "GET",
                url: "/g7/g7-employees/" + $scope.data.id + "/getData",
                success: function(response) {
                    if (response.success) {
                        $rootScope.$emit("editG7Employee", response.data);
                    } else {
                        toastr.warning(response.message);
                        $scope.errors = response.errors;
                    }
                }
            }, $scope);
        });
        $('#table-list').on('click', '.show', function () {
            $scope.data = getRowData(this, datatable);
            sendRequest({
                type: "GET",
                url: "/g7/g7-employees/" + $scope.data.id + "/getData",
                success: function(response) {
                    if (response.success) {
                        $rootScope.$emit("showG7Employee", response.data);
                    } else {
                        toastr.warning(response.message);
                        $scope.errors = response.errors;
                    }
                }
            }, $scope);
        });
    })
</script>
@include('partial.confirm')
@endsection
