<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <table style="width:100%">
            <tr>
                <td colspan="8" style="font-size: 15px; font-weight: bold; vertical-align: center; text-align: center">Báo cáo tồn kho
                </td>
            </tr>
            <tr>
                <td colspan="8" style="text-align: left; font-weight: bold;">
                    Bộ lọc
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left;">
                    Tên hàng: {{ $data->filter->product_name }}
                </td>
                <td colspan="4" style="text-align: left;">
                    Mã hàng: {{ $data->filter->product_code }}
                </td>
            </tr>
            <tr>
                <td colspan="8" style="text-align: left; font-weight: bold;">
                </td>
            </tr>
            <tr>
                <td colspan="8" style="text-align: left; font-weight: bold;">
                    Chi tiết
                </td>
            </tr>
            <tr>
                <td style="vertical-align: center;border: 1px solid black"><b>STT</b></td>
                <td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Tên hàng hóa</b></td>
                <td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Mã hàng</b></td>
                <td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Đơn vị</b></td>
                <td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Tồn</b></td>
				<td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Tổng SL nhập</b></td>
				<td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Tổng SL xuất</b></td>
				<td style="vertical-align: center;border: 1px solid black; word-wrap: break-word"><b>Tổng giá trị kho</b></td>
            </tr>
            @foreach($data->data as $index => $product)
            <tr>
                <td style="vertical-align: center; border: 1px solid black; width: 5px">{{$index + 1}}</td>
                <td style="vertical-align: center; border: 1px solid black; width: 35px; word-wrap: break-word">
                    {{$product->product_name}}
                </td>
                <td style="vertical-align: center; border: 1px solid black; width: 25px">
                    {{$product->product_code}}
                </td>
                <td style="vertical-align: center; border: 1px solid black; width: 20px">{{$product->unit_name}}</td>
                <td style="vertical-align: center; text-align: center; border: 1px solid black; width: 20px">{{formatCurrency($product->stock_qty)}}</td>
				<td style="vertical-align: center; text-align: center; border: 1px solid black; width: 20px">{{formatCurrency($product->import_qty)}}</td>
				<td style="vertical-align: center; text-align: center; border: 1px solid black; width: 20px">{{formatCurrency($product->export_qty)}}</td>
                <td style="vertical-align: center; text-align: right; border: 1px solid black; width: 20px">{{formatCurrency($product->stock_value)}}</td>
            </tr>
            @endforeach
			<tr>
				<td colspan="4" style="text-align: center; border: 1px solid black; font-weight: bold">Tổng cộng</td>
				<td style="text-align: center; border: 1px solid black; font-weight: bold">{{formatCurrency($data->total->stock_qty)}}</td>
				<td style="text-align: center; border: 1px solid black; font-weight: bold">{{formatCurrency($data->total->import_qty)}}</td>
				<td style="text-align: center; border: 1px solid black; font-weight: bold">{{formatCurrency($data->total->export_qty)}}</td>
				<td style="text-align: right; border: 1px solid black; font-weight: bold">{{formatCurrency($data->total->stock_value)}}</td>
			</tr>
        </table>
    </body>
</html>
