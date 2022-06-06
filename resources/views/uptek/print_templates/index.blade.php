@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý mẫu in
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
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
	let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('PrintTemplate.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT"},
			{data: 'name',title: 'Tiêu đề'},
			{data: 'code',title: 'Mã'},
			{data: 'created_at', title: "Ngày cập nhật"},
			{data: 'updated_by', title: "Người cập nhật"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: 'name', search_type: "text", placeholder: "Tên mẫu"},
		],
		search_by_time: false,
	})
</script>
@include('partial.confirm')
@endsection