@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý tài sản cố định
@endsection

@section('buttons')
@endsection
@section('content')
<div ng-cloak ng-controller="G7FixedAsset">
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
@include('g7.g7_fixed_assets.show')
@endsection

@section('script')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('G7FixedAsset.searchData') !!}',
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
            {data: 'code', title: 'Mã'},
            {data: 'status', title: "Trạng thái"},
			{data: 'updated_by', title: "Người sửa"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: 'name', search_type: "text", placeholder: "Tên"},
            {data: 'code', search_type: "text", placeholder: "Mã"},
            {
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: @json(\App\Model\G7\G7FixedAsset::STATUSES)
			}
		],
        create_link: "{{ route('G7FixedAsset.create') }}"
	}).datatable;

    app.controller('G7FixedAsset', function($scope, $rootScope, $http) {
        $scope.loading = {};
        $scope.form = {};

        $('#table-list').on('click', '.show', function () {
            $scope.data = getRowData(this, datatable);
            sendRequest({
                type: "GET",
                url: "/g7/g7_fixed_assets/"+$scope.data.id+"/getData",
                success: function(response) {
                    if (response.success) {
                        if (response.success) {
                            $rootScope.$emit("showG7FixedAsset", response.data);
                        } else {
                            toastr.warning(response.message);
                            $scope.errors = response.errors;
                        }
                    }
                }
            }, $scope);
        });

    });

</script>
@include('partial.confirm')
@endsection
