@extends('layouts.main')

@section('css')
@endsection

@section('title')
    Báo cáo quỹ
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" name="daterange" value="{{$from_date}} - {{$to_date}}" class="form-control"
                               id="daterange"/>
                    </div>
                    <table class="table table-bordered mt-2">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-left">Chỉ tiêu báo cáo</th>
                            <th scope="col">
                                Kỳ trước<br>({{$from_date_last}} - {{$to_date_last}})
                            </th>
                            <th scope="col">
                                Kỳ hiện tại<br>({{$from_date}} - {{$to_date}})
                            </th>
                            <th scope="col">% thay đổi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row" class="text-left">I. Các khoản thu</th>
                            <td class="text-right"><b>{{ number_format($total_receipt_out_period) }}</b></td>
                            <td class="text-right"><b>{{ number_format($total_receipt_in_period) }}</b></td>
                            <td class="text-right">{{ pct_change($total_receipt_out_period, $total_receipt_in_period) }}
                                %
                            </td>
                        </tr>
                        @foreach($report_receipt_in_period as $key => $row)
                            <tr>
                                <td class="text-left"
                                    style="padding-left: 20px !important;">{{$key + 1 }}.{{ $row['name'] }}</td>
                                <td class="text-right">{{ number_format($report_receipt_out_period[$key]['total_value']) }}</td>
                                <td class="text-right">{{ number_format($row['total_value']) }}</td>
                                <td class="text-right">{{ pct_change($report_receipt_out_period[$key]['total_value'], $row['total_value']) }}
                                    %
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th scope="row" class="text-left">II. Các khoản chi</th>
                            <td class="text-right"><b>{{ number_format($total_payment_out_period) }}</b></td>
                            <td class="text-right"><b>{{ number_format($total_payment_in_period) }}</b></td>
                            <td class="text-right">{{ pct_change($total_payment_out_period, $total_payment_in_period) }}
                                %
                            </td>
                        </tr>
                        @foreach($report_payment_in_period as $key => $row)
                            <tr>
                                <td class="text-left"
                                    style="padding-left: 20px !important;">{{$key + 1 }}.{{ $row['name'] }}</td>
                                <td class="text-right">{{ number_format($report_payment_out_period[$key]['total_value']) }}</td>
                                <td class="text-right">{{ number_format($row['total_value']) }}</td>
                                <td class="text-right">{{ pct_change($report_payment_out_period[$key]['total_value'], $row['total_value']) }}
                                    %
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot class="thead-light">
                        <tr>
                            <th scope="col" class="text-left">Lợi nhuận (I - II)</th>
                            <th class="text-right"><b>{{ number_format($total_receipt_out_period - $total_payment_out_period) }}</b></th>
                            <th class="text-right"><b>{{ number_format($total_receipt_in_period - $total_payment_in_period) }}</b></th>
                            <th class="text-right">{{ pct_change($total_receipt_out_period - $total_payment_out_period, $total_receipt_in_period - $total_payment_in_period) }}%</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(function () {

            $('input[name="daterange"]').daterangepicker({
                opens: 'right',
                locale: {
                    format: 'DD/MM/YYYY',
                    "applyLabel": "Đồng ý",
                    "cancelLabel": "Hủy",
                    "fromLabel": "Từ",
                    "toLabel": "Đến",
                    "customRangeLabel": "Tùy chọn",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "CN",
                        "T2",
                        "T3",
                        "T4",
                        "T5",
                        "T6",
                        "T7"
                    ],
                    "monthNames": [
                        "Tháng 1",
                        "Tháng 2",
                        "Tháng 3",
                        "Tháng 4",
                        "Tháng 5",
                        "Tháng 6",
                        "Tháng 7",
                        "Tháng 8",
                        "Tháng 9",
                        "Tháng 10",
                        "Tháng 11",
                        "Tháng 12"
                    ],
                    "firstDay": 1
                },
                ranges: {
                    '30 ngày trước': [moment().subtract(29, 'days'), moment()],
                    'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    '7 ngày trước': [moment().subtract(6, 'days'), moment()],
                    'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                }
            }, function (start, end, label) {
                let p = new URLSearchParams();
                p.set("from_date", start.format('DD/MM/YYYY'));
                p.set("to_date", end.format('DD/MM/YYYY'));
                window.location.href = "{{ route('FundReports.index') }}?" + p.toString();

                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>
@endsection
