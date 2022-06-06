@extends('layouts.main')

@section('css')
    <style>
        .product-edit-price-table td{
            vertical-align: middle;
            display: table-cell;
        }
        .product-price {
            max-width: 150px;
        }
    </style>
@endsection

@section('title')
    Quản lý hàng hóa - Cập nhật giá
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
                        <table id="table-list" class="product-edit-price-table">
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
                url: '{!! route('Product.searchData') !!}',
                data: function (d, context) {
                    d.type = 'edit-price'
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
                {data: 'price', title: "Giá đề xuất", className: "text-right"},
                {data: 'g7_price', title: "Giá"},
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
            ]
        })

        $(document).on('input', '.product-price', onBlur);
        $(document).on('blur', '.product-price', onBlur);
        $(document).on('focus', '.product-price', function () {
            $(this).select()
        });

        function localStringToNumber( s ){
            return Number(String(s).replace(/[^0-9.-]+/g,""))
        }

        function onBlur(e){
            var value = e.target.value

            e.target.value = (value || value === 0)
                ? localStringToNumber(value).toLocaleString('en')
                : ''
        }

        $(document).on('change', '.product-price', function () {
            let data = {
                product_id: $(this).data('product_id'),
                price: this.value.replace(/[^0-9.-]+/g,"")
            };
            sendRequest({
                type: 'POST',
                url: `{{ route('G7Product.updatePrice') }}`,
                data: data,
                success: function(response) {
                    toastr.success(response.messages);
                }
            });
        })

    </script>
    @include('partial.confirm')
@endsection
