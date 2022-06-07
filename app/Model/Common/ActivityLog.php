<?php

namespace App\Model\Common;
use Auth;
use App\Model\BaseModel;
use App\Model\Common\Customer;
use App\Model\Common\User;
use Illuminate\Database\Eloquent\Model;
use App\Model\Common\File;
use DB;
use App\Model\Common\Notification;
use App\Model\Uptek\G7Info;
use \Carbon\Carbon;

class ActivityLog extends Model
{

    public function g7()
    {
        return $this->belongsTo(G7Info::class,'g7_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public static function getForDisplay() {
        $result = self::query()
			->with([
				'user' => function($q) {
					$q->select([
						'id', 'name'
					]);
				}
			]);

		if (auth()->user()->type == User::G7 || auth()->user()->type == User::NHAN_VIEN_G7) {
			$result = $result->where('g7_id', auth()->user()->g7_id);
		}
//        else if (auth()->user()->type == User::NHOM_G7) {
//			$result = $result->whereIn('g7_id', auth()->user()->g7_ids);
//		}

		$result = $result->where('time', '>', date('Y-m-d'))
			->orderBy('time', 'DESC')
			->limit(5)
            ->get();

		return $result;
    }

    public static function createRecord($content, $link) {
		$obj = new ActivityLog();
		$obj->link = $link;
		$obj->content = $content;
		$obj->user_id = auth()->user()->id;
		$obj->g7_id = auth()->user()->g7_id;
		$obj->time = Carbon::now();
		$obj->save();
    }

}
