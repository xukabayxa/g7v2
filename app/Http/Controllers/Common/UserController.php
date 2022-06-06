<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Model\Common\User as ThisModel;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;
use Validator;
use App\Employee;
use Auth;
use \stdClass;
use Response;
use Rap2hpoutre\FastExcel\FastExcel;
use PDF;
use App\Http\Controllers\Controller;
use \Carbon\Carbon;
use DB;
use App\Http\Traits\ResponseTrait;
use App\Helpers\FileHelper;
use App\Model\Common\User;
use Hash;

class UserController extends Controller
{
	use ResponseTrait;

	protected $view = 'common.users';
	protected $route = 'User';

	public function index()
	{
		return view($this->view.'.index');
	}

	// Hàm phân trang, search cho datatable
    public function searchData(Request $request)
    {
        $objects = ThisModel::searchByFilter($request);

        return Datatables::of($objects)
			->editColumn('updated_by', function ($object) {
				return $object->user_update->name;
			})
            ->editColumn('created_at', function ($object) {
                return Carbon::parse($object->created_at)->format("d/m/Y");
            })
			->editColumn('status', function ($object) {
                return getStatus($object->status, ThisModel::STATUSES);
            })
			->editColumn('created_by', function ($object) {
                return $object->user_create ? $object->user_create->name : '';
            })
            ->addColumn('action', function ($object) {
				$result = '';
				if ($object->canEdit()) {
					$result = '<a href="' . route($this->route.'.edit',$object->id) .'" title="Sửa" class="btn btn-sm btn-primary edit"><i class="fas fa-pencil-alt"></i></a> ';
				}
				if ($object->canDelete()) {
					$result .= '<a href="' . route($this->route.'.delete', $object->id) . '" title="Khóa" class="btn btn-sm btn-danger confirm"><i class="fas fa-times"></i></a>';
				}
				return $result;

            })
			->rawColumns(['image', 'status', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

	public function create()
	{
		return view($this->view.'.create', compact([]));
	}

	public function edit($id)
	{
		$object = ThisModel::getDataForEdit($id);
		return view($this->view.'.edit', compact(['object']));
	}

	public function store(Request $request)
	{
		$rule = [
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6|regex:/^[a-zA-Z0-9\@\$\!\%\*\#\?\&]+$/',
			'password_confirm' => 'required|same:password',
			'type' => 'required|in:2,3,4,5',
			'status' => 'required|in:0,1',
			'image' => 'required|file|mimes:jpg,jpeg,png|max:3000'
		];

		if ($request->type == ThisModel::UPTEK) {
			$rule = array_merge($rule, [
				'roles' => 'required|array|min:1',
				'roles.*' => 'required|exists:roles,id'
			]);
		}

		if ($request->type == ThisModel::G7) {
			$rule = array_merge($rule, [
				'g7_id' => 'required|exists:g7_infos,id',
				'roles' => 'required|array|min:1',
				'roles.*' => 'required|exists:roles,id'
			]);
		}

		if ($request->type == ThisModel::NHOM_G7) {
			$rule = array_merge($rule, [
				'g7_ids' => 'required|array|min:1',
				'g7_ids.*' => 'required|exists:g7_infos,id'
			]);
		}

		$validate = Validator::make(
			$request->all(),
			$rule,
			[]
		);

		if ($validate->fails()) {
			return $this->responseErrors("", $validate->errors());
		}

		if (!in_array($request->type, Auth::user()->getAccessTypes())) {
			return $this->responseErrors("Không có quyền tạo loại tài khoản này");
		}

		DB::beginTransaction();
		try {
			$object = new ThisModel();
			$object->name = $request->name;
			$object->email = $request->email;
			$object->password = bcrypt($request->password);
			$object->type = $request->type;
			$object->status = $request->status;

			$object->save();

			if ($object->type == ThisModel::G7) {
				$object->g7_id = $request->g7_id;
			} else if ($object->type == ThisModel::NHOM_G7) {
				$object->g7s()->sync($request->g7_ids);
			} else if ($object->type == ThisModel::NHAN_VIEN_G7) {
				$object->g7_id = Auth::user()->g7_id;
			}

			$object->save();

			$object->roles()->sync($request->roles);

			FileHelper::uploadFile($request->image, 'users', $object->id, ThisModel::class, 'image');

			DB::commit();
			return $this->responseSuccess();
		} catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
	}

	public function update(Request $request, $id)
	{
		$object = ThisModel::findOrFail($id);

		$rule = [
			'name' => 'required',
			'email' => 'required|email|unique:users,email,'.$id,
			'password' => 'nullable|min:6|regex:/^[a-zA-Z0-9\@\$\!\%\*\#\?\&]+$/',
			'password_confirm' => 'required_with:password|same:password',
			'status' => 'required|in:0,1',
		];

		if ($object->type == ThisModel::UPTEK || $object->type == ThisModel::G7) {
			$rule = array_merge($rule, [
				'roles' => 'required|array|min:1',
				'roles.*' => 'required|exists:roles,id'
			]);
		}

		if ($object->type == ThisModel::NHOM_G7) {
			$rule = array_merge($rule, [
				'g7_ids' => 'required|array|min:1',
				'g7_ids.*' => 'required|exists:g7_infos,id'
			]);
		}

		$validate = Validator::make(
			$request->all(),
			$rule,
			[]
		);

		if ($validate->fails()) {
			return $this->responseErrors("", $validate->errors());
		}

		DB::beginTransaction();
		try {
			$object->name = $request->name;
			$object->email = $request->email;
			if ($request->password != null) $object->password = bcrypt($request->password);
			$object->status = $request->status;
			if ($object->type == ThisModel::NHOM_G7) {
				$object->g7s()->sync($request->g7_ids);
			}
			$object->save();

			$object->roles()->sync($request->roles);

			if($request->image) {
				FileHelper::forceDeleteFiles($object->image->id, $object->id, ThisModel::class, 'image');
				FileHelper::uploadFile($request->image, 'users', $object->id, ThisModel::class, 'image');
			}

			DB::commit();
			return $this->responseSuccess();
		} catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
	}

	public function delete($id)
    {
		$object = ThisModel::findOrFail($id);
		if (!$object->canDelete()) {
			$message = array(
				"message" => "Không thể khóa!",
				"alert-type" => "warning"
			);
		} else {
			$object->status = 0;
			$object->save();
			$message = array(
				"message" => "Thao tác thành công!",
				"alert-type" => "success"
			);
		}
        return redirect()->route($this->route.'.index')->with($message);
	}


	// Xuất Excel
    public function exportExcel() {
        return (new FastExcel(ThisModel::all()))->download('danh_sach_tai_khoan.xlsx', function ($object) {
            return [
				'ID' => $object->id,
                'Tên' => $object->name,
                'email' => $object->email,
                'Loại' => $object->getTypeUser($object->type),
                'Trạng thái' => $object->status == 0 ? 'Khóa' : 'Hoạt động',
            ];
        });
    }

	// Xuất PDF
    public function exportPDF() {
        $data = ThisModel::all();
		PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView($this->view.'.pdf', compact('data'));
        return $pdf->download('danh_sach_tai_khoan.pdf');
    }

	public function changePass()
	{
		$user = ThisModel::find(Auth::user()->id);
		return view($this->view.'.change_pass', compact('user'));
	}

	public function updatePass(Request $request)
	{
		$rule = [
			'old_password' => 'required|',
			'password' => 'required|min:6|different:old_password|regex:/^[a-zA-Z0-9\@\$\!\%\*\#\?\&]+$/',
			'password_confirm' => 'required|same:password',
		];

		$validate = Validator::make(
			$request->all(),
			$rule,
			[]
		);

		if ($validate->fails()) {
			return $this->responseErrors("", $validate->errors());
		}

		$user = ThisModel::findOrFail(Auth::user()->id);
		if (Hash::check($request->old_password, $user->password)) {
			$user->fill([
			 'password' => Hash::make($request->password)
			 ])->save();

			 return $this->responseSuccess();
		 } else {
			throw new Exception($e->getMessage());
		 }
	}
}
