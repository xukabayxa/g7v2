<?php

namespace App\Http\Controllers\G7;

use Illuminate\Http\Request;
use App\Model\G7\Config as ThisModel;
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

class ConfigController extends Controller
{
	protected $view = 'g7.configs';
	protected $route = 'Config';

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
				'date_reminder' => 'required|integer',
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
			$object = ThisModel::where('g7_id',Auth::user()->g7_id)->first();

			
			ThisModel::updateOrCreate(
				[
				'g7_id' => Auth::user()->g7_id],
				[
				'date_reminder' => $request->date_reminder
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
