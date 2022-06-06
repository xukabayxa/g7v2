@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý dịch vụ
@endsection

@section('content')
<div ng-cloak ng-controller="serviceIndex">
	<div class="row">
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
</div>
@endsection
@section('script')
<script>
	let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('Service.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT"},
			{data: 'image', title: 'Ảnh'},
			{data: 'name', title: 'Tên dịch vụ'},
			{data: 'code', title: 'Mã dịch vụ'},
			{data: 'service_type', title: 'Loại dịch vụ'},
			{
				data: 'status',
				title: "Trạng thái",
				render: function (data) {
					return getStatus(data, @json(App\Model\Uptek\Service::STATUSES));
				}
			},
			// {data: 'updated_at', title: "Ngày cập nhật"},
			// {data: 'updated_by', title: "Người cập nhật"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: 'name', search_type: "text", placeholder: "Tên dịch vụ"},
			{data: 'code', search_type: "text", placeholder: "Mã dịch vụ"},
			{
				data: 'service_type', search_type: "select", placeholder: "Loại dịch vụ",
				column_data: @json(App\Model\Common\ServiceType::getForSelect())
			},
			{
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: @json(App\Model\Uptek\Service::STATUSES)
			}
		],
		search_by_time: false,
		create_link: "{{ route('Service.create') }}"
	}).datatable;

	app.controller('Bill', function ($rootScope, $scope, $http) {
        $scope.loading = {};
		$scope.form = {};
		// Chi tiết dịch vụ
        $('#table-list').on('click', '.show', function () {
            $scope.data = getRowData(this, datatable);
			$.ajax({
                type: 'GET',
                url: "/uptek/services/" + $scope.data.id + "/getDataForShow",
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: $scope.data.id,
                success: function(response) {
                if (response.success) {
					let data = response.data;
                    $rootScope.$emit("openShowBill", data);
                    $('#show-modal').modal('show');
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
        });
    })
</script>
@include('partial.confirm')
@endsection
