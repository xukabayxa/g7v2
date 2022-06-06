@extends('layouts.main')

@section('css')
@endsection

@section('title')
Quản lý hàng hóa - vật tư
@endsection

@section('buttons')
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
@include('partial.classes.uptek.Product')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('G7Product.searchData') !!}',
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
            {data: 'category', title: 'Loại vật tư'},
            {data: 'status', title: "Trạng thái"},
			{data: 'points', title: "Tích điểm"},
			{data: 'updated_by', title: "Người sửa"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [
			{data: 'name', search_type: "text", placeholder: "Tên vật tư"},
            {data: 'code', search_type: "text", placeholder: "Mã vật tư"},
            {
                data: 'product_category_id', search_type: "select", placeholder: "Loại vật tư",
                column_data: @json(\App\Model\Common\ProductCategory::getForSelect())
            },
            {
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: @json(\App\Model\G7\G7Product::STATUSES)
			}
		],
        create_link: "{{ route('G7Product.create') }}"
	})

</script>
@include('partial.confirm')
@endsection
