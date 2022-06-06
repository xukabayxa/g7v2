@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý dịch vụ
@endsection

@section('content')
<div ng-cloak>
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
</div>
@endsection
@section('script')
<script>
	let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('G7Service.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT"},
			// {
            //     data: 'image', title: "Hình ảnh", orderable: false, className: "text-center",
            //     render: function (data) {
			// 		return `<img src="${data.path}" style="max-width: 55px !important">`;
			// 	}
            // },
			{data: 'image', title: 'Ảnh'},
			{data: 'name', title: 'Tên dịch vụ'},
			{data: 'code', title: 'Mã dịch vụ'},
			{data: 'service_type', title: 'Loại dịch vụ'},
			{
				data: 'status',
				title: "Trạng thái",
				render: function (data) {
					return getStatus(data, @json(App\Model\G7\G7Service::STATUSES));
				}
			},
			{data: 'updated_at', title: "Ngày cập nhật"},
			{data: 'updated_by', title: "Người cập nhật"},
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
				column_data: @json(App\Model\G7\G7Service::STATUSES)
			}
		],
		search_by_time: false,
		// create_link: "{{ route('Service.create') }}"
	})
</script>
@include('partial.confirm')
@endsection