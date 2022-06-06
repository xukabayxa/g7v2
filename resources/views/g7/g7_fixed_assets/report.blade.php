@extends('layouts.main')

@section('css')
@endsection

@section('title')
    Báo cáo tài sản cố định
@endsection

@section('buttons')
@endsection
@section('content')
    <div ng-cloak>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-md-3">
                            <table class="table">
                                <tr>
                                    <td>Số lượng tài sản cố định:</td>
                                    <td class="text-right"><b>{{ $summary_report['qty'] }}</b></td>
                                </tr>
                                <tr>
                                    <td>Tổng giá trị:</td>
                                    <td class="text-right"><b>{{ number_format($summary_report['total_price']) }}</b></td>
                                </tr>
                                <tr>
                                    <td>Đã khấu hao:</td>
                                    <td class="text-right"><b>{{ number_format($summary_report['depreciated']) }}</b></td>
                                </tr>
                                <tr>
                                    <td>Giá trị còn lại:</td>
                                    <td class="text-right"><b>{{ number_format($summary_report['total_price'] - $summary_report['depreciated']) }}</b></td>
                                </tr>
                            </table>
                        </div>
                    </div>
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
                url: '{!! route('G7FixedAsset.searchReportData') !!}',
                data: function (d, context) {
                    DATATABLE.mergeSearch(d, context);
                }
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
                {data: 'code', title: 'Mã tài sản'},
                {data: 'name', title: 'Tên tài sản'},
                {data: 'depreciation_period', title: 'Số tháng khấu hao', className: "text-center"},
                {data: 'import_code', title: 'Mã phiếu nhập'},
                {data: 'import_date', title: 'Ngày nhập'},
                {data: 'qty', title: 'Số lượng', className: "text-center sum"},
                {data: 'total_price', title: 'Giá trị', className: "text-right sum"},
                {data: 'depreciated', title: 'Đã khấu hao', className: "text-right sum"},
                {data: 'residual_value', title: 'Giá trị còn lại', className: "text-right sum"},
            ],
            search_columns: [
                {data: 'name', search_type: "text", placeholder: "Tên tài sản"},
                {data: 'code', search_type: "text", placeholder: "Mã phiếu nhập"}
            ]
        }).datatable;
    </script>
@endsection
