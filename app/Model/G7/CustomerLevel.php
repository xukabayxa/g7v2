<?php

namespace App\Model\G7;
use Auth;
use App\Model\BaseModel;
use App\Model\Common\Customer;
use App\Model\Common\User;
use Illuminate\Database\Eloquent\Model;
use App\Model\Common\File;
use DB;

class CustomerLevel extends BaseModel
{
    protected $table = 'customer_levels';

    public function canEdit()
    {
        if(Auth::user()->g7_id == $this->g7_id) {
            return true;
        } else {
            return false;
        }
    }

    public function canDelete() {
        if(Auth::user()->g7_id == $this->g7_id) {
            return true;
        } else {
            return false;
        }
    }


    public static function searchByFilter($request) {
        $result = self::where('g7_id', Auth::user()->g7_id);

        if (!empty($request->name)) {
            $result = $result->where('name', 'like', '%'.$request->name.'%');
        }

        $result = $result->orderBy('point','asc')->get();
        return $result;
    }

    public static function getForSelect() {
        return self::where('status', 1)
            ->where('g7_id', Auth::user()->g7_id)
            ->select(['id', 'name'])
            ->orderBy('name', 'ASC')
            ->get();
    }

    public static function getDataForEdit($id) {
        return self::where('id', $id)
            ->with(['users'])
            ->firstOrFail();
    }

}
