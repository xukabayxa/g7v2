<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <table style="width:100%">
            <tr>
                <td colspan="11" style="font-size: 15px; font-weight: bold; vertical-align: center; text-align: center">Sổ quỹ
                </td>
            </tr>
            <tr>
                <td colspan="11" style="text-align: left; font-weight: bold;">
                    Bộ lọc
                </td>
            </tr>
            <tr>
				<td colspan="6" style="text-align: left;">
                    Từ ngày: {{ $data->filter->from_date }}
                </td>
                <td colspan="5" style="text-align: left;">
                    Đến ngày: {{ $data->filter->to_date }}
                </td>
            </tr>
			<tr>
                <td colspan="6" style="text-align: left;">
                    Hình thức thanh toán: {{ $data->filter->payment_method ? ($data->filter->payment_method == 1 ? 'Tiền mặt' : 'Chuyển khoản') : '' }}
                </td>
                <td colspan="5" style="text-align: left;">
                    Người nộp/nhận: {{ $data->filter->object_name }}
                </td>
            </tr>
            <tr>
                <td colspan="11" style="text-align: left; font-weight: bold;">
                </td>
            </tr>
            <tr>
                <td colspan="11" style="text-align: left; font-weight: bold;">
                    Chi tiết
                </td>
            </tr>
            <tr>
                <td style="vertical-align: center;border: 1px solid black"><b>STT</b></td>
                <td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Loại phiếu</b></td>
                <td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Ngày ghi nhận</b></td>
                <td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Ngày tạo</b></td>
                <td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Mã phiếu</b></td>
				<td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Người nộp/nhận</b></td>
				<td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Hình thức thanh toán</b></td>
				<td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Tiền thu</b></td>
				<td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Tiền chi</b></td>
				<td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Mô tả</b></td>
				<td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Tham chiếu</b></td>
            </tr>
            @foreach($data->data as $index => $d)
            <tr>
                <td style="vertical-align: center; border: 1px solid black; width:5px">{{$index + 1}}</td>
                <td style="vertical-align: center; border: 1px solid black; word-wrap: break-word; width: 20px">
                    {{$d->type_name}}
                </td>
                <td style="vertical-align: center; border: 1px solid black; width: 20px">
                    {{\Carbon\Carbon::parse($d->record_date)->format('d/m/Y')}}
                </td>
				<td style="vertical-align: center; border: 1px solid black; width: 20px">
                    {{\Carbon\Carbon::parse($d->created_at)->format('d/m/Y')}}
                </td>
                <td style="vertical-align: center; border: 1px solid black; width: 20px">{{$d->code}}</td>
				<td style="vertical-align: center; border: 1px solid black; width: 20px">{{$d->object_name}}</td>
				<td style="vertical-align: center; border: 1px solid black; width: 20px">{{$d->pay_type == 1 ? 'Tiền mặt' : 'Chuyển khoản'}}</td>
                <td style="vertical-align: center; text-align: right; border: 1px solid black; width: 20px">{{$d->type == 1 ? formatCurrency($d->value) : '-'}}</td>
				<td style="vertical-align: center; text-align: right; border: 1px solid black; width: 20px">{{$d->type == 2 ? formatCurrency($d->value) : '-'}}</td>
				<td style="vertical-align: center; border: 1px solid black; width: 20px">{{$d->note}}</td>
                <td style="vertical-align: center; border: 1px solid black; width: 20px">{{$d->ref_code}}</td>
            </tr>
            @endforeach
			<tr>
				<td colspan="5" style="text-align: center; border: 1px solid black; font-weight: bold">Tổng cộng</td>
				<td colspan="2" style="text-align: right; border: 1px solid black; font-weight: bold">Tồn đầu: {{formatCurrency($data->total['before'])}}</td>
				<td style="text-align: right; border: 1px solid black; font-weight: bold">{{formatCurrency($data->total['income'])}}</td>
				<td style="text-align: right; border: 1px solid black; font-weight: bold">{{formatCurrency($data->total['spending'])}}</td>
				<td colspan="2" style="text-align: right; border: 1px solid black; font-weight: bold">Tồn cuối: {{formatCurrency($data->total['before'] + $data->total['income'] - $data->total['spending'])}}</td>
			</tr>
        </table>
    </body>
</html>
