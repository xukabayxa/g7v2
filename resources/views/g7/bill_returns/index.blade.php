@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý hóa đơn trả
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
			url: '{!! route('BillReturn.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {data: 'code', title: 'Số hóa đơn'},
			{data: 'bill', orderable: false, title: 'Hóa đơn bán'},
			{data: 'license_plate', title: "Biển số xe"},
			{data: 'customer_name', title: "Khách hàng"},
			{data: 'cost_after_vat', title: 'Tổng thanh toán'},
			{data: 'created_by', title: "Người lập"},
			{data: 'created_at', title: "Thời gian lập"},
			{data: 'bill_date', title: "Thời gian ghi nhận"},
			{data: 'status', title: "Trạng thái"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
            {data: 'code', search_type: "text", placeholder: "Số hóa đơn"},
			{data: 'bill', search_type: "text", placeholder: "Hoá đơn bán"},
			{data: 'license_plate', search_type: "text", placeholder: "Biển số xe"},
			{data: 'customer_name', search_type: "text", placeholder: "Khách hàng"},
            {
				data: 'created_by', search_type: "select", placeholder: "Người lập",
				column_data: USERS
			},
		],
		create_link: "{{ route('BillReturn.create') }}"
	});

</script>
@include('partial.confirm')
@endsection
