<?php

namespace App\Http\Controllers\G7;

use Illuminate\Http\Request;
use App\Model\G7\AccumulatePoint as ThisModel;
use Yajra\DataTables\DataTables;
use Validator;
use \stdClass;
use Response;
use App\Http\Controllers\Controller;
use \Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Model\Common\User;
use Auth;
use DB;

class AccumulatePointController extends Controller
{
	protected $view = 'g7.accumulate_points';
	protected $route = 'AccumulatePoint';

	public function edit()
	{
		$object = ThisModel::where('g7_id',Auth::user()->g7_id)->first();
		return view($this->view.'.edit', compact('object'));
	}

	public function update(Request $request)
	{
		$validate = Validator::make(
			$request->all(),
			[
				'value_to_point_rate' => 'required|integer',
				'point_to_money_rate' => 'required|integer',

			]
		);

		$json = new stdClass();

		if ($validate->fails()) {
			$json->success = false;
            $json->errors = $validate->errors();
            $json->message = "Thao tác thất bại!";
            return Response::json($json);
		}

		DB::beginTransaction();
		try {
			$request->allow_pay === 'true' ? $allow_pay = 1 : $allow_pay = 0;
			$request->accumulate_pay_point === 'true' ? $accumulate_pay_point = 1 : $accumulate_pay_point = 0;

			ThisModel::updateOrCreate(
				[
					'g7_id' => Auth::user()->g7_id
				],
				[
					'value_to_point_rate' => $request->value_to_point_rate,
					'point_to_money_rate' => $request->point_to_money_rate,
					'allow_pay' => $allow_pay,
					'accumulate_pay_point' => $accumulate_pay_point,
					'type' => $request->type,
					'g7_id' => Auth::user()->g7_id
				]
			);

			DB::commit();
			$json->success = true;
			$json->message = "Thao tác thành công!";
			return Response::json($json);
		} catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
	}
}
