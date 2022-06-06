@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý phiếu xuất kho
@endsection

@section('buttons')
@endsection

@section('content')
<div ng-cloak ng-controller="WarehouseExport">
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
@include('g7.warehouse_exports.show')
@endsection

@section('script')
<script>
	let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('WarehouseExport.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {data: 'code', title: 'Số phiếu'},
            {data: 'type', title: 'Loại phiếu'},
			{data: 'bill', orderable: false, title: 'Hóa đơn'},
			{data: 'created_by', title: "Người lập"},
			{data: 'created_at', title: "Thời gian lập"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
            {data: 'code', search_type: "text", placeholder: "Số phiếu"},
            {
                data: "type", search_type: "select", placeholder: "Loại phiếu",
                column_data: [{id: 1, name: "Xuất bán"}, {id: 99, name: "Xuất khác"}],
            },
            {data: 'bill', search_type: "text", placeholder: "Hóa đơn"},
            {
				data: 'created_by', search_type: "select", placeholder: "Người lập",
				column_data: USERS
			},
		],
		create_link: "{{ route('WarehouseExport.create') }}"
	}).datatable;


	createQuickReceiptCallback = (response) => {
        datatable.ajax.reload();

    }

    app.controller('WarehouseExport', function ($scope, $rootScope, $http) {
        $scope.loading = {};
		$scope.form = {};

        $scope.showWarehouseExportDetail = function(obj) {
            sendRequest({
                type: 'GET',
                url: "/g7/warehouse_exports/" + obj.id + "/getDataForShow",
                success: function(response) {
                    if (response.success) {
                        $('#show-modal').modal('show');
                        let data = response.data;
                        console.log(data);
                        $rootScope.$emit("openShowWarehouseExport", data);
                        $scope.$applyAsync();
                    }
                }
            });
        }

		// Chi tiết hóa đơn bán
        $('#table-list').on('click', '.show', function () {
            $scope.data = getRowData(this, datatable);
            $scope.showWarehouseExportDetail({id: $scope.data.id});
        });

        if (getParam('bill_id')) {
            $scope.showWarehouseExportDetail({id: getParam('bill_id')});
        }
    })


</script>
@include('partial.confirm')
@endsection
