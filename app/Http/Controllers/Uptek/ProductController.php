<?php

namespace App\Http\Controllers\Uptek;

use Illuminate\Http\Request;
use App\Model\Product as ThisModel;
use App\Model\Common\Unit;
use Yajra\DataTables\DataTables;
use Validator;
use \stdClass;
use Response;
use Rap2hpoutre\FastExcel\FastExcel;
use PDF;
use App\Http\Controllers\Controller;
use \Carbon\Carbon;
use DB;
use App\Helpers\FileHelper;
use App\Model\Common\User;
use Auth;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
	protected $view = 'uptek.products';
	protected $route = 'Product';

	public function index()
	{
		return view($this->view.'.index');
	}

	public function filterDataForBill(Request $request)
	{
		$data = ThisModel::where('g7_id', Auth::user()->g7_id)->with([
			'image',
			'g7_price'
		]);
		if($request->has('category_id')) {
			$data->where('product_category_id', $request->category_id);
		}
		if($request->has('name')) {
			$data->where('name', 'like', '%'.$request->name.'%');
		}
		$data = $data->orderBy('name', 'ASC')->get();

		$json = new stdClass();
		if($data) {
			$json->success = true;
			$json->data = $data;
			$json->draw = $request->draw;
			return Response::json($json);
		} else {
			$json->success = false;
			$json->messages = "Có lỗi xảy ra";
			return Response::json($json);
		}
	}

	// Hàm lấy data cho bảng list
    public function searchData(Request $request)
    {
		$objects = ThisModel::searchByFilter($request);
        return Datatables::of($objects)
			->addColumn('custom_name', function ($object) {
				return "<a title='Xem chi tiết' href='javascript:void(0)' class='show-product'>".$object->name."</a>";
			})
			->editColumn('price', function ($object) {
				return formatCurrent($object->price);
			})
			->editColumn('created_at', function ($object) {
				return Carbon::parse($object->created_at)->format("d/m/Y");
			})
			->editColumn('created_by', function ($object) {
				return $object->user_create->name ? $object->user_create->name : '';
			})
			->editColumn('updated_by', function ($object) {
				return $object->user_update->name ? $object->user_update->name : '';
			})
			->editColumn('category', function ($object) {
					return $object->category ? $object->category->name : '';
			})
            ->editColumn('price', function ($object) {
                return formatCurrency($object->price);
            })
            ->editColumn('g7_price', function ($object) use ($request) {
                if ($request->type === 'edit-price') {
                    return '<input class="form-control product-price" type="text" data-product_id="'.$object->id.'" value="'. formatCurrency($object->g7_price ? $object->g7_price->price : 0).'">';
                } else {
                    return formatCurrency($object->g7_price ? $object->g7_price->price : 0);
                }
            })
			->addColumn('action', function ($object) {
				$result = '';
				if($object->canEdit()) {
					$result = '<a href="javascript:void(0)" title="Sửa" class="btn btn-sm btn-primary edit"><i class="fas fa-pencil-alt"></i></a> ';
				}
				$result .= '<a href="javascript:void(0)" title="Xem chi tiết" class="btn btn-sm btn-primary show-product"><i class="fas fa-eye"></i></a> ';
				if ($object->canDelete()) {
					$result .= '<a href="' . route($this->route.'.delete', $object->id) . '" title="Xóa" class="btn btn-sm btn-danger confirm"><i class="fas fa-times"></i></a>';
				}
				return $result;
			})
			->addIndexColumn()
			->rawColumns(['custom_name','action', 'g7_price'])
			->make(true);
    }

	public function store(Request $request)
	{
		$validate = Validator::make(
			$request->all(),
			[
				// 'name' => 'required|unique:products,name',
				'name' => [
					'required',
					Rule::unique('products')->where(function($q) {
						$q->where('g7_id', Auth::user()->g7_id);
					})
				],
				'product_category_id' => 'required|exists:product_categories,id',
				'unit_id' => 'required|exists:units,id',
				'price' => 'required|integer',
				'points' =>'nullable|integer',
				'image' => 'required|file|mimes:jpg,jpeg,png|max:3000'
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
			$object = new ThisModel();
			$object->name = $request->name;
			$object->code = randomString(20);
			$object->product_category_id = $request->product_category_id;
			$object->barcode = $request->barcode;
			$object->unit_id = $request->unit_id;
			$object->unit_name = Unit::find($request->unit_id)->name;
			$object->price = $request->price;
			$object->points = $request->points ?: 0;
			$object->note = $request->note;
			$object->status = 1;
			if(Auth::user()->type == User::G7 || Auth::user()->type == User::NHAN_VIEN_G7) {
				$object->g7_id = Auth::user()->g7_id;
			}
			$object->save();

			$object->generateCode();

			FileHelper::uploadFile($request->image, 'products', $object->id, ThisModel::class, 'image',1);

			DB::commit();
			$json->success = true;
			$json->message = "Thao tác thành công!";
			return Response::json($json);
		} catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
	}

	public function update(Request $request, $id)
	{
		$validate = Validator::make(
			$request->all(),
			[
				'name' => 'required|unique:products,name,'.$id,
				'product_category_id' => 'required|exists:product_categories,id',
				'unit_id' => 'required|exists:units,id',
				'price' => 'required|integer',
				'points' => 'integer'
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
			$object = ThisModel::findOrFail($id);
			if ($request->status == 0 && !$object->canDelete()) {
				$json->success = false;
				$json->message = "Không thể khóa hàng hóa này!";
				return Response::json($json);
			}

			if (!$object->canEdit()) {
				$json->success = false;
				$json->message = "Bạn không có quyền sửa hàng hóa này";
				return Response::json($json);
			}

			$object->name = $request->name;
			$object->product_category_id = $request->product_category_id;
			$object->barcode = $request->barcode;
			$object->unit_id = $request->unit_id;
			$object->unit_name = Unit::find($request->unit_id)->name;
			$object->price = $request->price;
			$object->points = $request->points;
			$object->note = $request->note;
			$object->status = $request->status;
			$object->save();
			if($request->image) {
				FileHelper::forceDeleteFiles($object->image->id, $object->id, ThisModel::class, 'image');
				FileHelper::uploadFile($request->image, 'products', $object->id, ThisModel::class, 'image',1);
			}

			foreach ($object->g7_products as $g7_product) {
				$g7_product->name = $object->name;
				$g7_product->product_category_id = $object->product_category_id;
				$g7_product->unit_id = $object->unit_id;
				$g7_product->unit_name = $object->unit_name;
				$g7_product->save();
			}

			DB::commit();
			$json->success = true;
			$json->message = "Thao tác thành công!";
			return Response::json($json);
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
				"message" => "Không thể xóa!",
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


	public function getData(Request $request, $id) {
        $json = new stdclass();
        $json->success = true;
        $json->data = ThisModel::getData($id);
        return Response::json($json);
	}

	// Xuất Excel
	public function exportExcel(Request $request)
	{
		return (new FastExcel(ThisModel::searchByFilter($request)))->download('danh_sach_hang_hoa.xlsx', function ($object) {
			if(Auth::user()->type == User::G7 || Auth::user()->type == User::NHOM_G7) {
				return [
					'ID' => $object->id,
					'Mã' => $object->code,
					'Tên' => $object->name,
					'Loại' => $object->category->name,
					'Giá đề xuất' => formatCurrency($object->price),
					'Giá bán' => formatCurrency($object->g7_price->price),
					'Điểm tích lũy' => $object->point,
					'Trạng thái' => $object->status == 0 ? 'Khóa' : 'Hoạt động',
				];
			} else {
				return [
					'ID' => $object->id,
					'Mã' => $object->code,
					'Tên' => $object->name,
					'Loại' => $object->category->name,
					'Giá đề xuất' => formatCurrency($object->price),
					'Điểm tích lũy' => $object->point,
					'Trạng thái' => $object->status == 0 ? 'Khóa' : 'Hoạt động',
				];
			}
		});
	}

	// Xuất PDF
	public function exportPDF(Request $request) {
		$data = ThisModel::searchByFilter($request);
		$pdf = PDF::loadView($this->view.'.pdf', compact('data'));
		return $pdf->download('danh_sach_hang_hoa.pdf');
	}
}
