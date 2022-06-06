<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <table style="width:100%">
            <tr>
                <td colspan="4" style="font-size: 15px; font-weight: bold; vertical-align: center; text-align: center">Báo cáo bán hàng
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left; font-weight: bold;">
                    Bộ lọc
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;">
                    Từ ngày: {{ $data->filter->from_date }}
                </td>
                <td colspan="2" style="text-align: left;">
                    Đến ngày: {{ $data->filter->to_date }}
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left; font-weight: bold;">
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left; font-weight: bold;">
                    Chi tiết
                </td>
            </tr>
            <tr>
                <td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Ngày</b></td>
                <td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Doanh thu trước giảm giá</b></td>
                <td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Giảm giá</b></td>
				<td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Tổng doanh thu</b></td>
            </tr>
            @foreach($data->data as $index => $d)
            <tr>
                <td style="vertical-align: center; border: 1px solid black; width: 30px; word-wrap: break-word">
                    {{\Carbon\Carbon::parse($d->day)->format('d/m/Y')}}
                </td>
                <td style="vertical-align: center; text-align: right; border: 1px solid black; width: 40px">{{formatCurrency($d->total_cost)}}</td>
				<td style="vertical-align: center; text-align: right; border: 1px solid black; width: 40px">{{formatCurrency($d->sale_cost)}}</td>
				<td style="vertical-align: center; text-align: right; border: 1px solid black; width: 40px">{{formatCurrency($d->cost_after_sale)}}</td>
            </tr>
            @endforeach
			<tr>
				<td style="text-align: center; border: 1px solid black; font-weight: bold">Tổng cộng</td>
				<td style="text-align: right; border: 1px solid black; font-weight: bold">{{formatCurrency($data->total->total_cost)}}</td>
				<td style="text-align: right; border: 1px solid black; font-weight: bold">{{formatCurrency($data->total->sale_cost)}}</td>
				<td style="text-align: right; border: 1px solid black; font-weight: bold">{{formatCurrency($data->total->cost_after_sale)}}</td>
			</tr>
        </table>
    </body>
</html>
