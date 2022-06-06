@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý bài viết
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
			url: '{!! route('Post.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT"},
			{data: 'name',title: 'Tiêu đề'},

			{
				data: 'status',
				title: "Trạng thái",
				render: function (data) {
					return getStatus(data, @json(App\Model\Uptek\Post::STATUSES));
				}
			},
			{data: 'created_at', title: "Ngày cập nhật"},
			{data: 'updated_by', title: "Người cập nhật"},
			{
                data: 'image', title: "Hình ảnh", orderable: false, className: "text-center",
                render: function (data) {
					return `<img src="${data.path}" style="max-width: 55px !important">`;
				}
            },
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: 'name', search_type: "text", placeholder: "Tiêu đề"},
			{
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: @json(App\Model\Uptek\Post::STATUSES)
			}
		],
		search_by_time: false,
		@if(Auth::user()->type == App\Model\Common\User::SUPER_ADMIN || Auth::user()->type == App\Model\Common\User::UPTEK)
		create_link: "{{ route('Post.create') }}"
		@endif
	})
</script>
@include('partial.confirm')
@endsection
