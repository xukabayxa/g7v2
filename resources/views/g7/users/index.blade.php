@extends('layouts.main')

@section('css')
@endsection

@section('title')
Danh sách tài khoản nhân viên
@endsection

@section('buttons')
<a href="{{ route('G7User.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> Thêm mới</a>
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<table id="table-list">
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('G7User.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT"},
			{data: 'name', title: "Tên"},
			{data: 'mobile', title: "Số điện thoại"},
			{data: 'email', title: "Email"},
			{
				data: 'status',
				title: "Trạng thái",
			},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: "name", search_type: "text", placeholder: "Tên"},
			{data: "mobile", search_type: "text", placeholder: "Số điện thoại"},
			{
				data: "status", search_type: "select", placeholder: "Trạng thái",
				column_data: [{id: 1, name: "Hoạt động"}, {id: 0, name: "Khóa"}],
			},
			{
				data: "type", search_type: "select", placeholder: "Loại",
				column_data: USER_TYPES,
			},
		]
	});

</script>
@include('partial.confirm')
@endsection