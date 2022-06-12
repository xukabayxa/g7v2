<?php

namespace App\Model\G7;

use App\Model\BaseModel;
use App\Model\Common\Customer;
use App\Model\Common\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Model\Common\File;
use Illuminate\Support\Facades\Auth;
use DB;

class PaymentVoucher extends BaseModel
{
    public CONST STATUSES = [
        [
            'id' => 1,
            'name' => 'Đã duyệt',
            'type' => 'success'
        ],
        [
            'id' => 0,
            'name' => 'Hủy',
            'type' => 'danger'
        ]
    ];
// Đối tượng nhận phí
    public CONST RECIPIENT_TYPES = [
        [
            'id' => 1,
            'name' => 'Khách hàng',
        ],
        [
            'id' => 2,
            'name' => 'Nhân viên',
        ],
        [
            'id' => 3,
            'name' => 'Nhà cung cấp',
        ],
        [
            'id' => 4,
            'name' => 'Khác',
        ]
    ];

    public function getRecipientType($type_id)
    {
        foreach(self::RECIPIENT_TYPES as $type) {
            if($type['id'] == $type_id) {
                return $type['name'];
            }
        }
    }

    protected $appends = ['created_format'];


    public function canDelete() {
        return true;
    }

    public function recipientale()
    {
        return $this->morphTo();
    }

    public function paymentVoucherType()
    {
        return $this->belongsTo('App\Model\G7\PaymentVoucherType','payment_voucher_type_id','id');
    }

    public function wareHouseImport()
    {
        return $this->belongsTo('App\Model\G7\WareHouseImport','ware_house_import_id','id');
    }

    public function g7FixedAssetImport()
    {
        return $this->belongsTo('App\Model\G7\G7FixedAssetImport','g7_fixed_asset_import_id','id');
    }


    public static function searchByFilter($request) {
        $result = self::with([]);

        if(Auth::user()->type == User::G7 || Auth::user()->type == User::NHAN_VIEN_G7) {
            $result = $result->where('g7_id', Auth::user()->g7_id);
        }

        if (!empty($request->code)) {
            $result = $result->where('code', 'like', '%'.$request->code.'%');
        }

        if ($request->status === 0 || $request->status === '0' || !empty($request->status)) {
            $result = $result->where('status', $request->status);
        }

        if (!empty($request->payment_voucher_type)) {
            $result = $result->where('payment_voucher_type_id', $request->payment_voucher_type);
        }

        if ($request->object) {
            $result = $result->where('recipient_type_id', $request->object);
        }

        if ($request->payer_name) {
            $result = $result->whereHasMorph('recipientale', [User::class, Customer::class, Supplier::class], function ($q) use ($request) {
                $q->where('recipientale_id', $request->payer_name);
            });
        }

        if ($request->updated_by) {
            $result = $result->where('updated_by', $request->updated_by);
        }

        if ($request->startDate) {
            $result = $result->where('created_at', '>', $request->startDate);
        }

        if ($request->endDate) {
            $result = $result->where('created_at', '<', $request->endDate);
        }

        $result = $result->orderBy('created_at','desc')->get();
        return $result;
    }

    public static function getForSelect() {
        return self::select(['id', 'code'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function generateCode() {
        $this->code = "PCT-".generateCode(5, $this->id);
        $this->save();
    }

    public static function getReportByDates($from_date, $to_date, $type_except = [])
    {
        $query = self::query()
            ->selectRaw(DB::raw('payment_voucher_type_id, sum(value) as total_value, record_date, month'))
            ->where(function ($q) use ($from_date, $to_date) {
               $q->whereBetween('record_date', [$from_date, $to_date])
                   ->orWhereNotNull('month');
            })
            ->where('g7_id', Auth::user()->g7_id);
        if (!empty($type_except)) {
            $query->whereNotIn('payment_voucher_type_id', $type_except);
        }
        $rows = $query->groupBy('payment_voucher_type_id', 'record_date', 'month')
            ->orderBy('payment_voucher_type_id')
            ->get();
        $results = [];

        foreach ($rows as $row) {
            if (!isset($results[$row->payment_voucher_type_id])) {
                $results[$row->payment_voucher_type_id] = 0;
            }
            // với chi phí có phân bổ theo tháng thì cần phân bổ theo thời gian tính trong kỳ
            if ($row->month) {
                $record_date = new Carbon($row->record_date);
                $from_date_carbon = new Carbon($from_date);
                $to_date_carbon = new Carbon($to_date);

                // Số tiền chi phí phân bổ theo từng ngày
                $end_record_date = (new Carbon($row->record_date))->addMonths($row->month);

                $days = $end_record_date->diffInDays($record_date);
                $value_each_day = $row->total_value / $days;

                // Số ngày được tính chi phí
                $days_ = 0;
                if ($from_date_carbon < $record_date && $to_date_carbon > $record_date && $to_date_carbon < $end_record_date) {
                    $days_ = $to_date_carbon->diffInDays($record_date);
                } elseif ($from_date_carbon >= $record_date && $to_date_carbon <= $end_record_date) {
                    $days_ = $to_date_carbon->diffInDays($from_date_carbon);
                } elseif ($from_date_carbon > $record_date && $from_date_carbon <= $end_record_date && $to_date_carbon > $end_record_date) {
                    $days_ = $end_record_date->diffInDays($from_date_carbon);
                }

                if ($days_ && $days_ <= $days) {
                    $results[$row->payment_voucher_type_id] += ($value_each_day * $days_);
                }
            } else {
                $results[$row->payment_voucher_type_id] += $row->total_value;
            }
        }

        if (!empty($type_except)) {
            $types = PaymentVoucherType::query()
                ->whereNotIn('id', $type_except)
                ->orderBy('id')
                ->pluck('name', 'id')
                ->toArray();
        } else {
            $types = PaymentVoucherType::query()
                ->orderBy('id')
                ->pluck('name', 'id')
                ->toArray();
        }

        $report = [];
        foreach ($types as $id => $name) {
            if (!isset($results[$id])) {
                $report[] = [
                    'name' => $name,
                    'total_value' => 0
                ];
            } else {
                $report[] = [
                    'name' => $name,
                    'total_value' => $results[$id]
                ];
            }
        }

        $total_point_money = Bill::query()
            ->whereBetween('bill_date', [$from_date, $to_date])
            ->where('g7_id', Auth::user()->g7_id)
            ->where('status', Bill::DA_DUYET)
            ->sum('point_money');

        $report[] = [
            'name' => 'Chi tiêu điểm',
            'total_value' => $total_point_money
        ];

        $total_value = array_sum(array_map(function($item) {
            return $item['total_value'];
        }, $report));

        return [$total_value, $report];
    }
}
