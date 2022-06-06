@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý nhóm khách hàng
@endsection

@section('buttons')
<a href="{{ route('CustomerGroup.create') }}" class="btn btn-outline-success" data-toggle="modal" href="javascript:void(0)" data-target="#createCustomerGroup" class="btn btn-info" ng-click="errors = null"><i class="fa fa-plus"></i> Thêm mới</a>
<a href="javascript:void(0)" target="_blank" data-href="{{ route('CustomerGroup.exportExcel') }}" class="btn btn-info export-button"><i class="fas fa-file-excel"></i> Xuất file excel</a>
<a href="javascript:void(0)" target="_blank" data-href="{{ route('CustomerGroup.exportPDF') }}" class="btn btn-warning export-button"><i class="far fa-file-pdf"></i> Xuất file pdf</a>
@endsection
@section('content')
<div ng-cloak>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table-list">
                    </table>
                </div>
            </div>
            {{-- Form sửa --}}
            <div class="modal fade" id="editCustomerGroup" tabindex="-1" role="dialog" aria-hidden="true">
                <form action="#" method="POST" role="form" id="editCustomerGroupForm">
                    @csrf
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="semi-bold">Sửa nhóm</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="form-label">Tên nhóm</label>
                                    <span class="text-danger">(*)</span>
                                    <input class="form-control" type="text" name="name" ng-model="editing.name">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors.name[0] %></strong>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Trạng thái</label>
                                    <select class="form-control" name="status" ng-model="editing.status">
                                        <option value="1">Hoạt động</option>
                                        <option value="0">Khóa</option>
                                    </select>
                                    <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.status">
                                        <strong><% errors.status[0] %></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" ng-disabled="loading"><i class="fa fa-save"></i> Lưu</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal" ng-disabled="loading"><i class="fa fa-remove"></i> Hủy
                                </button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Form tạo mới nhóm khách --}}
    @include('common.customer_groups.createCustomerGroup')
</div>
@endsection

@section('script')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('CustomerGroup.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT"},
            {data: 'name', title: 'Tên'},
            {
				data: 'status',
				title: "Trạng thái",
				render: function (data) {
					if (data == 0) {
						return `<span class="badge badge-danger">Khóa</span>`;
					} else {
						return `<span class="badge badge-success">Hoạt động</span>`;
					}
				}
			},
            {data: 'status', title: "Trạng thái"},
			{data: 'created_at', title: "Ngày tạo"},
			{data: 'created_by', title: "Người tạo"},
			{data: 'updated_by', title: "Người sửa"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: 'name', search_type: "text", placeholder: "Tên nhóm"},
			{
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: [{id: 1, name: "Hoạt động"}, {id: 0, name: "Khóa"}]
			}
		],
		search_by_time: false,
	}).datatable;

    $(document).on('click', '.export-button', function(event) {
        event.preventDefault();
        let data = {};
        mergeSearch(data, datatable.context[0]);
        window.location.href = $(this).data('href') + "?" + $.param(data);
    })

    createCustomerGroupCallback = (response) => {
        datatable.ajax.reload();
    }

</script>
@include('partial.confirm')
@endsection