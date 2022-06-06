@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý chốt vật tư tiêu hao
@endsection

@section('buttons')
@endsection

@section('content')
<div>
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
			url: '{!! route('FinalWarehouseAdjust.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {data: 'code', title: 'Số phiếu'},
			{data: 'created_by', title: "Người lập"},
			{data: 'created_at', title: "Thời gian lập"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
            {data: 'code', search_type: "text", placeholder: "Số phiếu"},
            {
				data: 'created_by', search_type: "select", placeholder: "Người lập",
				column_data: USERS
			},
		],
		create_link: "{{ route('FinalWarehouseAdjust.create') }}"
	});

</script>
@include('partial.confirm')
@endsection
