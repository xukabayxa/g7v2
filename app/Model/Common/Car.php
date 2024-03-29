<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;
use App\Model\BaseModel;
use Auth;
use App\Model\G7\Bill;

class Car extends BaseModel
{
    protected $fillable = ['registration_deadline','hull_insurance_deadline','maintenance_dateline','insurance_deadline'];
    public CONST HOAT_DONG = 1;
    public CONST KHOA = 0;

    public CONST STATUSES = [
        [
            'id' => self::HOAT_DONG,
            'name' => 'Hoạt động',
            'type' => 'success'
        ],
        [
            'id' => self::KHOA,
            'name' => 'Đã khóa',
            'type' => 'danger'
        ],
    ];

    public function canDelete() {
        if($this->created_by == Auth::user()->id && $this->bill()->count() == 0 || Auth::user()->type == 1 && $this->bill()->count() == 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function canEdit() {
        if($this->created_by == Auth::user()->id || Auth::user()->g7_id == $this->g7_id ) {
            return true;
        } else {
            return false;
        }
    }

    public function bill()
    {
        return $this->hasMany(Bill::class,'car_id','id');
    }

    // public function licensePlate()
    // {
    //     return $this->belongsTo('App\Model\Common\LicensePlate','license_plate_id','id');
    // }

    public function customers()
    {
        return $this->belongsToMany('App\Model\Common\Customer')->withTimestamps();
    }

    public function manufact()
    {
        return $this->belongsTo('App\Model\Common\VehicleManufact','manufact_id','id');
    }

    public function type()
    {
        return $this->belongsTo('App\Model\Common\VehicleType','type_id','id');
    }

    public function category()
    {
        return $this->belongsTo('App\Model\Common\VehicleCategory','category_id','id');
    }



    public static function searchByFilter($request) {
        $result = self::with('customers','manufact','type','category');

        if(Auth::user()->type == User::G7 || Auth::user()->type == User::NHAN_VIEN_G7) {
            $result = $result->where('g7_id', Auth::user()->g7_id);
        }

        if($request->g7_id) {
            $result = $result->where('g7_id', $request->g7_id);
        }

        if ($request->license_plate) {
            $result = $result->where('license_plate','like','%'.$request->license_plate.'%');
        }

        if($request->customer_mobile) {
            $result = $result->whereHas('customers', function ($query) use($request) {
                $query->where('mobile','like','%'.$request->customer_mobile.'%')->orWhere('name','like','%'.$request->customer_mobile.'%');
            });
        }

        if (!empty($request->manufact)) {
            $result = $result->where('manufact_id', $request->manufact);
        }

        if (!empty($request->vehicle_type)) {
            $result = $result->where('type_id', $request->vehicle_type);
        }

        if (!empty($request->category_vehicle)) {
            $result = $result->where('category_id', $request->category_vehicle);
        }

        if ($request->status === 0 || $request->status === '0' || !empty($request->status)) {
            $result = $result->where('status', $request->status);
        }
        if($result) {
            $result = $result->orderBy('created_at','desc');
        }
        return $result;
    }

    public static function getForSelect() {
        return self::select(['id', 'license_plate as name'])
            ->where('g7_id',Auth::user()->g7_id)
            ->with('customers')
            ->orderBy('license_plate', 'ASC')
            ->get();
    }

    public static function getData($id) {
        return self::where('id', $id)
            ->with([
                'customers'
            ])
            ->firstOrFail();
    }
}
