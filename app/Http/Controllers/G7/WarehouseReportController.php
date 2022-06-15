<?php

namespace App\Http\Controllers\G7;

use App\ExcelExports\FundReport;
use App\ExcelExports\SaleReport;
use App\ExcelExports\StockReport;
use App\Http\Controllers\Controller;
use App\Model\G7\Bill;
use App\Model\G7\BillExportProduct;
use App\Model\G7\FinalWarehouseAdjustDetail;
use App\Model\G7\PaymentVoucher;
use App\Model\G7\ReceiptVoucher;
use App\Model\G7\Stock;
use App\Model\G7\WarehouseExportDetail;
use App\Model\G7\WareHouseImportDetail;
use Auth;
use DB;
use Illuminate\Http\Request;
use Response;
use stdClass;
use Validator;

class WarehouseReportController extends Controller
{
    protected $view = 'g7.warehouse_reports';

    public function stockReport(Request $request)
    {
        return view($this->view . '.stockReport', compact([]));
    }

    public function stockReportExcel(Request $request)
    {
        $json = new stdClass();
        $json->data = $this->stockReportQuery($request)->get();
        $json->total = $this->stockReportQuery($request, true)->first();
        $json->filter = $request;
        return (new StockReport)
            ->forData($json)
            ->download('Bao_cao_ton_kho.xlsx');
    }

    public function stockReportSearchData(Request $request)
    {
        $json = new stdClass();
        $json->success = true;
        $json->draw = $request->draw;

        $json->data = $this->stockReportQuery($request)->paginate($request->per_page, '', 'page',
            $request->current_page);
        $json->total = $this->stockReportQuery($request, true)->first();
        return Response::json($json);
    }

    public function stockReportQuery($request, $total = false)
    {
        $export = WarehouseExportDetail::from('warehouse_export_details as wed')
            ->join('warehouse_exports as we', 'wed.parent_id', '=', 'we.id')
            ->where('we.g7_id', auth()->user()->g7_id)
            ->select([
                'wed.id',
                'wed.qty',
                'wed.product_id',
                DB::raw('1 as type')
            ]);

        $import = WareHouseImportDetail::from('ware_house_import_detail as wid')
            ->join('ware_house_imports as wi', 'wid.ware_house_import_id', '=', 'wi.id')
            ->where('wi.g7_id', auth()->user()->g7_id)
            ->select([
                'wid.id',
                'wid.qty',
                'wid.product_id',
                DB::raw('3 as type')
            ]);

        $selectSub = [
            DB::raw('SUM(CASE WHEN type = 1 OR type = 2 THEN sub.qty ELSE 0 END) as export_qty'),
            DB::raw('SUM(CASE WHEN type = 3 THEN sub.qty ELSE 0 END) as import_qty'),
            DB::raw('SUM(CASE WHEN type = 1 OR type = 2 THEN -sub.qty ELSE sub.qty END) as stock_qty'),
            'sub.product_id'
        ];

        $union = DB::table(DB::raw("({$export->union($import)->toRawSql()}) as sub"))
            ->select($selectSub)->groupBy('sub.product_id');

        if ($total) {
            $select = [
                DB::raw("SUM(export_qty) as export_qty"),
                DB::raw("SUM(import_qty) as import_qty"),
                DB::raw("SUM(stock_qty) as stock_qty"),
                DB::raw("SUM(value) as stock_value"),
            ];
        } else {
            $select = [
                DB::raw("SUM(export_qty) as export_qty"),
                DB::raw("SUM(import_qty) as import_qty"),
                DB::raw("SUM(stock_qty) as stock_qty"),
                DB::raw("SUM(value) as stock_value"),
                'sub1.product_id',
                'p.name as product_name',
                'p.code as product_code',
                'p.unit_name as unit_name'
            ];
        }
        $result = DB::table(DB::raw("({$union->toRawSql()}) as sub1"))
            ->join('products as p', 'sub1.product_id', '=', 'p.id')
            ->join('stocks as s', 'sub1.product_id', '=', 's.product_id')
            ->select($select);

        $this->stockReportFilter($result, $request);

        if (!$total) {
            $result = $result->groupBy(['sub1.product_id', 'p.name', 'p.code', 'p.unit_name']);
        }
        return $result;
    }

    public function stockReportFilter($query, $filter)
    {
        if (!empty($filter->product_name)) {
            $query->where('p.name', 'LIKE', '%' . $filter->product_name . '%');
        }
        if (!empty($filter->product_code)) {
            $query->where('p.code', 'LIKE', '%' . $filter->product_code . '%');
        }
    }

    public function saleReport(Request $request)
    {
        return view($this->view . '.saleReport', compact([]));
    }

    public function saleReportSearchData(Request $request)
    {
        $json = new stdClass();
        $json->success = true;
        $json->draw = $request->draw;

        $json->data = $this->saleReportQuery($request)->paginate($request->per_page, '', 'page',
            $request->current_page);
        $json->total = $this->saleReportQuery($request, true)->first();
        return Response::json($json);
    }

    public function saleReportExcel(Request $request)
    {
        $json = new stdClass();
        $json->data = $this->saleReportQuery($request)->get();
        $json->total = $this->saleReportQuery($request, true)->first();
        $json->filter = $request;
        return (new SaleReport)
            ->forData($json)
            ->download('Bao_cao_ban_hang.xlsx');
    }


    public function saleReportQuery($request, $total = false)
    {

        if ($total) {
            $select = [
                DB::raw("SUM(total_cost) as total_cost"),
                DB::raw("SUM(sale_cost) as sale_cost"),
                DB::raw("SUM(cost_after_sale) as cost_after_sale"),
            ];
        } else {
            $select = [
                DB::raw("SUM(total_cost) as total_cost"),
                DB::raw("SUM(sale_cost) as sale_cost"),
                DB::raw("SUM(cost_after_sale) as cost_after_sale"),
                DB::raw("DATE(bill_date) as day"),
            ];
        }

        $result = Bill::where('g7_id', auth()->user()->g7_id)
            ->select($select);

        if (!empty($request->from_date)) {
            $result = $result->where('bill_date', '>=', $request->from_date);
        }

        if (!empty($request->to_date)) {
            $result = $result->where('bill_date', '<', addDay($request->to_date));
        }

        if (!$total) {
            $result = $result->groupBy([DB::raw('DATE(bill_date)')]);
        }
        return $result;
    }

    public function fundReport(Request $request)
    {
        return view($this->view . '.fundReport', compact([]));
    }

    public function fundReportExcel(Request $request)
    {
        $json = new stdClass();
        $json->data = $this->fundReportQuery($request)->get();
        $json->total = $this->fundReportSummary($request);
        $json->filter = $request;
        return (new FundReport)
            ->forData($json)
            ->download('So_quy.xlsx');
    }

    public function fundReportSearchData(Request $request)
    {
        $json = new stdClass();
        $json->success = true;
        $json->draw = $request->draw;

        $json->data = $this->fundReportQuery($request)->paginate($request->per_page, '', 'page',
            $request->current_page);
        $json->total = $this->fundReportSummary($request);
        return Response::json($json);
    }

    public function fundReportQuery($request)
    {
        $g7_ids = $this->getG7Ids();

        $receipt = ReceiptVoucher::from('receipt_vouchers as rv')
            ->leftJoin('bills as b', 'rv.bill_id', '=', 'b.id')
            ->leftJoin('receipt_voucher_types as rvt', 'rv.receipt_voucher_type_id', '=', 'rvt.id')
            ->select([
                'rv.code as record_code',
                'rv.id as record_id',
                DB::raw('1 as type'),
                'rv.record_date',
                'rv.created_at',
                'rvt.name as type_name',
                'rv.value',
                'rv.note',
                'rv.payer_name as object_name',
                'b.id as ref_id',
                'b.code as ref_code',
                'rv.pay_type'
            ])->whereIn('rv.g7_id', $g7_ids);

        $payment = PaymentVoucher::from('payment_vouchers as pv')
            ->leftJoin('ware_house_imports as wi', 'pv.ware_house_import_id', '=', 'wi.id')
            ->leftJoin('payment_voucher_types as pvt', 'pv.payment_voucher_type_id', '=', 'pvt.id')
            ->select([
                'pv.code as record_code',
                'pv.id as record_id',
                DB::raw('2 as type'),
                'pv.record_date',
                'pv.created_at',
                'pvt.name as type_name',
                'pv.value',
                'pv.note',
                'pv.recipient_name as object_name',
                'wi.id as ref_id',
                'wi.code as ref_code',
                'pv.pay_type'
            ])->whereIn('pv.g7_id', $g7_ids);

        $result = DB::table(DB::raw("({$receipt->union($payment)->toRawSql()}) as sub"));

        $result = $this->fundReportFilter($result, $request);

        return $result->select(['*'])->orderBy('sub.record_date', 'DESC');
    }

    public function fundReportSummary($request)
    {
        $g7_ids = $this->getG7Ids();

        $receipt = ReceiptVoucher::from('receipt_vouchers as rv')
            ->leftJoin('bills as b', 'rv.bill_id', '=', 'b.id')
            ->leftJoin('receipt_voucher_types as rvt', 'rv.receipt_voucher_type_id', '=', 'rvt.id')
            ->select([
                'rv.code as record_code',
                'rv.id as record_id',
                DB::raw('1 as type'),
                'rv.record_date',
                'rvt.name as type_name',
                'rv.value',
                'rv.payer_name as object_name',
                'rv.pay_type'
            ])->whereIn('rv.g7_id', $g7_ids);

        $payment = PaymentVoucher::from('payment_vouchers as pv')
            ->leftJoin('ware_house_imports as wi', 'pv.ware_house_import_id', '=', 'wi.id')
            ->leftJoin('payment_voucher_types as pvt', 'pv.payment_voucher_type_id', '=', 'pvt.id')
            ->select([
                'pv.code as record_code',
                'pv.id as record_id',
                DB::raw('2 as type'),
                'pv.record_date',
                'pvt.name as type_name',
                'pv.value',
                'pv.recipient_name as object_name',
                'pv.pay_type'
            ])->whereIn('pv.g7_id', $g7_ids);

        $result = DB::table(DB::raw("({$receipt->union($payment)->toRawSql()}) as sub"));

        $result = $this->fundReportFilter($result, $request);

        $result = $result->select([
            DB::raw('SUM(CASE WHEN type = 1 THEN value ELSE 0 END) as income'),
            DB::raw('SUM(CASE WHEN type = 2 THEN value ELSE 0 END) as spending')
        ])->first();

        if (empty($request->from_date)) {
            $before = 0;
        } else {
            $receipt_before = ReceiptVoucher::from('receipt_vouchers as rv')
                ->leftJoin('bills as b', 'rv.bill_id', '=', 'b.id')
                ->leftJoin('receipt_voucher_types as rvt', 'rv.receipt_voucher_type_id', '=', 'rvt.id')
                ->select([
                    'rv.id as record_id',
                    DB::raw('1 as type'),
                    'rv.record_date',
                    'rvt.name as type_name',
                    'rv.value',
                    'rv.payer_name as object_name',
                    'rv.pay_type'
                ]);

            $payment_before = PaymentVoucher::from('payment_vouchers as pv')
                ->leftJoin('ware_house_imports as wi', 'pv.ware_house_import_id', '=', 'wi.id')
                ->leftJoin('payment_voucher_types as pvt', 'pv.payment_voucher_type_id', '=', 'pvt.id')
                ->select([
                    'pv.id as record_id',
                    DB::raw('2 as type'),
                    'pv.record_date',
                    'pvt.name as type_name',
                    'pv.value',
                    'pv.recipient_name as object_name',
                    'pv.pay_type'
                ]);

            $result_before = DB::table(DB::raw("({$receipt_before->union($payment_before)->toRawSql()}) as sub"))
                ->where('sub.record_date', '<', $request->from_date);

            if (!empty($request->payment_method)) {
                $result_before = $result_before->where('sub.pay_type', $request->payment_method);
            }

            if (!empty($request->object_name)) {
                $result_before = $result_before->where('sub.object_name', 'likes', '%' . $request->object_name . '%');
            }

            $result_before = $result_before->select([
                DB::raw('SUM(CASE WHEN type = 1 THEN value ELSE 0 END) as income'),
                DB::raw('SUM(CASE WHEN type = 2 THEN value ELSE 0 END) as spending')
            ])->first();

            $before = $result_before->income - $result_before->spending;
        }

        return [
            'before' => $before,
            'income' => $result->income,
            'spending' => $result->spending
        ];
    }

    function getG7Ids()
    {
        $g7_ids = [];
        if (Auth::user()->type == 3 || Auth::user()->type == 5) {
            $g7_id = Auth::user()->g7_id;
            $g7_ids[] = $g7_id;
        } elseif (Auth::user()->type == 4) {
            $g7_ids = Auth::user()->g7s->pluck('id');
        }
        return $g7_ids;
    }

    public function fundReportFilter($result, $request)
    {
        if (!empty($request->from_date)) {
            $result = $result->where('sub.record_date', '>=', $request->from_date);
        }

        if (!empty($request->to_date)) {
            $result = $result->where('sub.record_date', '<', addDay($request->to_date));
        }

        if (!empty($request->payment_method)) {
            $result = $result->where('sub.pay_type', $request->payment_method);
        }

        if (!empty($request->object_name)) {
            $result = $result->where('sub.object_name', 'like', '%' . $request->object_name . '%');
        }

        if (!empty($request->type)) {
            $result = $result->where('sub.type_name', 'like', '%' . $request->type . '%');
        }

        if (!empty($request->code)) {
            $result = $result->where('sub.record_code', 'like', '%' . $request->code . '%');
        }
        return $result;
    }
}
