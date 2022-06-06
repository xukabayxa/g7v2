<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Model\Common\Car;
use App\Model\Common\User;
use App\Model\G7\Bill;
use App\Model\G7\PaymentVoucher;
use App\Model\G7\ReceiptVoucher;
use App\Model\G7\WareHouseImport;
use App\Model\Uptek\Config;
use Auth;
use Carbon\Carbon;
use DB;
use PDF;
use Response;
use Validator;

class DashboardController extends Controller
{
    protected $view = 'common.dashboard';


    public function index()
    {
        $data = [];
        $g7_ids = [];
        // Lấy config nhắc lịch
        $config = Config::where('id', 1)->first();
        $date = $config ? $config->date_reminder : 0;
        $reminders = Car::whereBetween('registration_deadline',
            [Carbon::now()->subDays(1), Carbon::now()->addDays($date)])
            ->orWhereBetween('hull_insurance_deadline', [Carbon::now()->subDays(1), Carbon::now()->addDays($date)])
            ->orWhereBetween('maintenance_dateline', [Carbon::now()->subDays(1), Carbon::now()->addDays($date)])
            ->orWhereBetween('insurance_deadline', [Carbon::now()->subDays(1), Carbon::now()->addDays($date)]);
        // User là Quản lý G7 hoặc nhân viên G7
        if (Auth::user()->type == 3 || Auth::user()->type == 5) {
            $g7_id = Auth::user()->g7_id;
            $g7_ids[] = $g7_id;
            // Số hóa đơn bán trong ngày
            $data['bills'] = Bill::where('g7_id', $g7_id)->where('status', 1)->whereDate('bill_date',
                date('Y-m-d'))->count();
            // Doanh thu trong ngày
            $data['revenue_day'] = Bill::where('g7_id', $g7_id)->where('status', 1)->whereDate('bill_date',
                date('Y-m-d'))->sum('cost_after_vat');
            // Doanh thu trong tháng
            $data['revenue_month'] = Bill::where('g7_id', $g7_id)->where('status', 1)->whereMonth('bill_date',
                Carbon::now()->month)->sum('cost_after_vat');
            // Tiền thu trong ngày
            $data['receipt_day'] = ReceiptVoucher::where('g7_id', $g7_id)->where('status', 1)->whereDate('record_date',
                date('Y-m-d'))->sum('value');
            // Tiền chi trong ngày
            $data['payment_day'] = PaymentVoucher::where('g7_id', $g7_id)->where('status', 1)->whereDate('record_date',
                date('Y-m-d'))->sum('value');
            // tồn quỹ
            if (Auth::user()->type == 3)
                $data['reserve_fund'] = $this->fundReportSummary($g7_ids);

            // Doanh só từng ngày trong tuần
            $sales = $this->getSaleByCurrentDay($g7_ids);
            $total_receipt = $this->getReceiptByCurrentDay($g7_ids);

            if (Auth::user()->type == User::G7) {
                $reminders = $reminders->where('g7_id', $g7_id);
            }
        }

        // User là Quản lý nhóm G7
        if (Auth::user()->type == 4) {
            $g7_ids = Auth::user()->g7s->pluck('id');
            // Số hóa đơn bán trong ngày
            $data['bills'] = Bill::whereIn('g7_id', $g7_ids)->whereDate('bill_date', date('Y-m-d'))->count();
            // Số phiếu nhập trong ngày
            $data['imports'] = WareHouseImport::whereIn('g7_id', $g7_ids)->whereDate('import_date',
                date('Y-m-d'))->count();
            // Số phiếu chi trong ngày
            $data['payments'] = PaymentVoucher::whereIn('g7_id', $g7_ids)->whereDate('record_date',
                date('Y-m-d'))->count();
            // Số phiếu thu trong ngày
            $data['receipts'] = ReceiptVoucher::whereIn('g7_id', $g7_ids)->whereDate('record_date',
                date('Y-m-d'))->count();

            // Số hóa đơn bán trong ngày
            $data['bills'] = Bill::whereIn('g7_id', $g7_ids)->where('status', 1)->whereDate('bill_date',
                date('Y-m-d'))->count();
            // Doanh thu trong ngày
            $data['revenue_day'] = Bill::whereIn('g7_id', $g7_ids)->where('status', 1)->whereDate('bill_date',
                date('Y-m-d'))->sum('cost_after_vat');
            // Doanh thu trong tháng
            $data['revenue_month'] = Bill::whereIn('g7_id', $g7_ids)->where('status', 1)->whereMonth('bill_date',
                Carbon::now()->month)->sum('cost_after_vat');
            // Tiền thu trong ngày
            $data['receipt_day'] = ReceiptVoucher::whereIn('g7_id', $g7_ids)->where('status',
                1)->whereDate('record_date', date('Y-m-d'))->sum('value');
            // Tiền chi trong ngày
            $data['payment_day'] = PaymentVoucher::whereIn('g7_id', $g7_ids)->where('status',
                1)->whereDate('record_date', date('Y-m-d'))->sum('value');
            // tồn quỹ
            $data['reserve_fund'] = $this->fundReportSummary($g7_ids);

            // Doanh só từng ngày trong tuần
            $sales = $this->getSaleByCurrentDay($g7_ids);
            $total_receipt = $this->getReceiptByCurrentDay($g7_ids);

            $reminders = $reminders->whereIn('g7_id', $g7_ids);
        }

        // User là uptek

        if (Auth::user()->type == 1 || Auth::user()->type == 2) {
            $g7_ids = [];
            // Số hóa đơn bán trong ngày
            $data['bills'] = Bill::whereDate('bill_date', date('Y-m-d'))->count();
            // Số phiếu nhập trong ngày
            $data['imports'] = WareHouseImport::whereDate('import_date', date('Y-m-d'))->count();
            // Số phiếu chi trong ngày
            $data['payments'] = PaymentVoucher::whereDate('record_date', date('Y-m-d'))->count();
            // Số phiếu thu trong ngày
            $data['receipts'] = ReceiptVoucher::whereDate('record_date', date('Y-m-d'))->count();

            // Số hóa đơn bán trong ngày
            $data['bills'] = Bill::where('status', 1)->whereDate('bill_date', date('Y-m-d'))->count();
            // Doanh thu trong ngày
            $data['revenue_day'] = Bill::where('status', 1)->whereDate('bill_date',
                date('Y-m-d'))->sum('cost_after_vat');
            // Doanh thu trong tháng
            $data['revenue_month'] = Bill::where('status', 1)->whereMonth('bill_date',
                Carbon::now()->month)->sum('cost_after_vat');
            // Tiền thu trong ngày
            $data['receipt_day'] = ReceiptVoucher::where('status', 1)->whereDate('record_date',
                date('Y-m-d'))->sum('value');
            // Tiền chi trong ngày
            $data['payment_day'] = PaymentVoucher::where('status', 1)->whereDate('record_date',
                date('Y-m-d'))->sum('value');

            // Doanh só từng ngày trong tuần
            $sales = $this->getSaleByCurrentDay($g7_ids);
            $total_receipt = $this->getReceiptByCurrentDay($g7_ids);

            $reminders = $reminders->whereBetween('registration_deadline',
                [Carbon::now()->subDays(1), Carbon::now()->addDays($date)])
                ->orWhereBetween('hull_insurance_deadline', [Carbon::now()->subDays(1), Carbon::now()->addDays($date)])
                ->orWhereBetween('maintenance_dateline', [Carbon::now()->subDays(1), Carbon::now()->addDays($date)])
                ->orWhereBetween('insurance_deadline', [Carbon::now()->subDays(1), Carbon::now()->addDays($date)]);
        }

        $reminders->with([
            'customers',
            'licensePlate'
        ])->get();

        return view($this->view . '.dash', compact('data', 'sales', 'total_receipt', 'reminders'));
    }

    public function getSaleByCurrentDay($g7_ids)
    {
        $select = [
            DB::raw("SUM(cost_after_sale) as cost_after_sale"),
            DB::raw("DATE(bill_date) as day"),
        ];
        if ($g7_ids) {
            $result = Bill::whereIn('g7_id', $g7_ids)
                ->select($select)->whereDate('bill_date', '>',
                    Carbon::now()->subDays(7))->groupBy([DB::raw('DATE(bill_date)')])->get();
        } else {
            $result = Bill::select($select)->whereDate('bill_date', '>',
                Carbon::now()->subDays(7))->groupBy([DB::raw('DATE(bill_date)')])->get();
        }

        return $result;
    }

    public function getReceiptByCurrentDay($g7_ids)
    {
        $select = [
            DB::raw("SUM(value) as value"),
            DB::raw("DATE(record_date) as day"),
        ];
        if ($g7_ids) {
            $result = ReceiptVoucher::whereIn('g7_id', $g7_ids)
                ->select($select)->whereDate('record_date', '>',
                    Carbon::now()->subDays(7))->groupBy([DB::raw('DATE(record_date)')])->get();
        } else {
            $result = ReceiptVoucher::select($select)->whereDate('record_date', '>',
                Carbon::now()->subDays(7))->groupBy([DB::raw('DATE(record_date)')])->get();
        }

        return $result;
    }

    function fundReportSummary($g7_ids)
    {
        $receipt = ReceiptVoucher::from('receipt_vouchers as rv')
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
            ])
            ->whereIn('rv.g7_id', $g7_ids);

        $payment = PaymentVoucher::from('payment_vouchers as pv')
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
            ])
            ->whereIn('pv.g7_id', $g7_ids);

        $result = DB::table(DB::raw("({$receipt->union($payment)->toRawSql()}) as sub"));

        $rsl = $result->select([
            DB::raw('SUM(CASE WHEN type = 1 THEN value ELSE 0 END) as income'),
            DB::raw('SUM(CASE WHEN type = 2 THEN value ELSE 0 END) as spending')
        ])->first();
        return $rsl->income - $rsl->spending;
    }
}
