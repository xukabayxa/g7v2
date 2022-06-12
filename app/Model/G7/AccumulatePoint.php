<?php

namespace App\Model\G7;
use Auth;
use App\Model\BaseModel;
use App\Model\Common\Customer;
use App\Model\Common\User;
use Illuminate\Database\Eloquent\Model;
use DB;

class AccumulatePoint extends BaseModel
{
    protected $table = 'accumulate_points';
    protected $fillable = ['value_to_point_rate','point_to_money_rate','allow_pay','accumulate_pay_point','type','g7_id'];

    // Type = 1 Tich luy theo gia tri hoa don
    // Type = 2 Tich luy theo diem cua hang hoa, dich vu
    
    public function users()
    {
        return $this->hasMany(User::class,'g7_id','id');
    }

    public function image()
    {
        return $this->morphOne(File::class, 'model');
    }

    public static function getForSelect() {
        return self::where('status', 1)
            ->select(['id', 'name'])
            ->orderBy('name', 'ASC')
            ->get();
    }

    public static function getPointRate()
    {
        return self::where('g7_id', Auth::user()->g7_id)->first()->point_to_money_rate;
    }

    public static function getDataForEdit($id) {
        return self::where('g7_id', Auth::user()->g7_id)
            ->with(['users'])
            ->firstOrFail();
    }

}
