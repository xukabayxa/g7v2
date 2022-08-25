<?php

namespace App\Http\Controllers\G7;

use App\Model\Uptek\Service;
use App\Model\Uptek\ServiceProduct;
use App\Model\Uptek\ServiceVehicleCategory;
use App\Model\Uptek\ServiceVehicleCategoryGroup;
use App\Model\Uptek\ServiceVehicleCategoryGroupProduct;
use App\Model\Uptek\UptekService;
use Illuminate\Http\Request;
use App\Model\Uptek\Service as ThisModel;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;
use Validator;
use App\Model\Common\User;
use Auth;
use \stdClass;
use Response;
use Rap2hpoutre\FastExcel\FastExcel;
use PDF;
use App\Http\Controllers\Controller;
use \Carbon\Carbon;
use DB;
use App\Model\Common\ServiceType;
use App\Model\Common\VehicleCategory;
use App\Model\G7\BillService;
use App\Helpers\FileHelper;

class G7ServiceController extends Controller
{
    protected $view = 'g7.services';
    protected $route = 'G7Service';

    public function index()
    {
        return view($this->view.'.index');
    }

    public function show($id)
    {
        $object = ThisModel::getDataForEdit($id);
        return view($this->view.'.show', compact(['object']));
    }

    // Hàm lấy data cho bảng list
    public function searchData(Request $request)
    {
        $objects = ThisModel::searchByFilter($request);
        return Datatables::of($objects)
            ->editColumn('name', function ($object) {
                return "<a title='Xem chi tiết' href='".route('Service.show', $object->id)."'>".$object->name."</a>";
            })
            ->editColumn('updated_at', function ($object) {
                return Carbon::parse($object->updated_at)->format("d/m/Y");
            })
            ->editColumn('service_type', function ($object) {
                return $object->service_type->name;
            })
            ->editColumn('image', function ($object) {
                return ($object->image) ? "<img src=". $object->image->path ." style='max-width: 55px !important'>" : '-';
            })
            ->addColumn('action', function ($object) {
                $result = '';
                if($object->canEdit()) {
                    $result .= '<a href="' . route($this->route.'.edit', $object->id) . '" title="Sửa" class="btn btn-sm btn-primary edit"><i class="fas fa-pencil-alt"></i></a> ';
                }
                if ($object->canDelete()) {
                    
                    $result .= '<a href="' . route($this->route.'.delete', $object->id) . '" title="Xóa" class="btn btn-sm btn-danger confirm"><i class="fas fa-times"></i></a>';
                }
                if ($object->canRestore()) {
                    
                    $result .= '<a href="' . route($this->route.'.restore', $object->id) . '" title="Khôi phục lại" class="btn btn-sm btn-success confirm"><i class="fa fa-redo"></i></a>';
                }
                return $result;
            })
            ->addIndexColumn()
            ->rawColumns(['action','image','name'])
            ->make(true);
    }

    public function edit($id)
    {
        $object = ThisModel::getDataForEdit($id);
        return view($this->view.'.edit', compact(['object']));
    }

    public function create()
    {
        return view($this->view.'.create', compact([]));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $rule = [
            'products' => 'nullable|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.qty' => 'required|numeric|min:0|max:99999999|not_in:0',
            'service_vehicle_categories' => 'required|array|min:1',
            'service_vehicle_categories.*.vehicle_category_id' => 'required|exists:vehicle_categories,id',
            'service_vehicle_categories.*.groups' => 'required|array|min:1',
            'service_vehicle_categories.*.groups.*.name' => 'required|max:255',
            'service_vehicle_categories.*.groups.*.service_price' => 'required|numeric|min:0|max:999999999',
            'service_vehicle_categories.*.groups.*.points' => 'required|numeric|min:0|max:999999999',
            'service_vehicle_categories.*.groups.*.products' => 'required|array|min:1',
            'service_vehicle_categories.*.groups.*.products.*.product_id' => 'required|exists:products,id',
            'service_vehicle_categories.*.groups.*.products.*.qty' => 'required|numeric|min:0|max:99999999|not_in:0',
            'service_type_id' => 'required|exists:service_types,id',
//            'name' => 'required|max:255|unique:services,name',
            'name' => ['required', 'max:255',
                Rule::unique('services')->where(function ($query) use($user) {
                    return $query->where('g7_id', $user->g7_id)
                        ;
                }),
            ],
            'image' => 'required|file|mimes:jpg,jpeg,png|max:3000',
//			'points' => 'required|integer'
        ];

        $translate = [
            'products.min' => 'Bắt buộc phải chọn',
            'products.*.qty.min' => 'Không hợp lệ',
            'products.*.qty.max' => 'Không hợp lệ',
            'products.*.qty.not_in' => 'Không hợp lệ',
        ];

        $validate = Validator::make(
            $request->all(),
            $rule,
            $translate
        );

        $json = new stdClass();

        if ($validate->fails()) {
            $json->success = false;
            $json->errors = $validate->errors();
            $json->message = "Tạo thất bại!";
            return Response::json($json);
        }

        DB::beginTransaction();
        try {
            $object = new ThisModel();
            $object->name = $request->name;
            $object->points = $request->points;
            $object->status = $request->status ?? 1;
            $object->service_type_id = $request->service_type_id;
            $object->g7_id = auth()->user()->g7_id;
            $object->save();

            $object->generateCode();

            $object->syncVehicleCategories($request->service_vehicle_categories);
            $object->syncProducts($request->products);
            FileHelper::uploadFile($request->image, 'services', $object->id, ThisModel::class, 'image',1);

            DB::commit();
            $json->success = true;
            $json->message = 'Tạo thành công';
            return Response::json($json);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $rule = [
            'products' => 'nullable|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.qty' => 'required|numeric|min:0|max:99999999|not_in:0',
            'service_vehicle_categories' => 'required|array|min:1',
            'service_vehicle_categories.*.vehicle_category_id' => 'required|exists:vehicle_categories,id',
            'service_vehicle_categories.*.groups' => 'required|array|min:1',
            'service_vehicle_categories.*.groups.*.name' => 'required|max:255',
            'service_vehicle_categories.*.groups.*.service_price' => 'required|numeric|min:0|max:999999999',
            'service_vehicle_categories.*.groups.*.points' => 'required|numeric|min:0|max:999999999',
            'service_vehicle_categories.*.groups.*.products' => 'required|array|min:1',
            'service_vehicle_categories.*.groups.*.products.*.product_id' => 'required|exists:products,id',
            'service_vehicle_categories.*.groups.*.products.*.qty' => 'required|numeric|min:0|max:99999999|not_in:0',
            'service_type_id' => 'required|exists:service_types,id',
//            'name' => 'required|max:255|unique:services,name,'.$id,
            'name' => ['required', 'max:255',
                Rule::unique('services')->where(function ($query) use($user, $id) {
                    return $query->where('g7_id', $user->g7_id)
                        ;
                })->ignore($id),
            ],

            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:3000',
            'points' => 'required|integer'
        ];

        $translate = [
            'products.min' => 'Bắt buộc phải chọn',
            'products.*.qty.min' => 'Không hợp lệ',
            'products.*.qty.max' => 'Không hợp lệ',
            'products.*.qty.not_in' => 'Không hợp lệ',

        ];

        $validate = Validator::make(
            $request->all(),
            $rule,
            $translate
        );

        $json = new stdClass();

        if ($validate->fails()) {
            $json->success = false;
            $json->errors = $validate->errors();
            $json->message = "Sửa thất bại!";
            return Response::json($json);
        }

        $object = ThisModel::findOrFail($id);

        $group_ids = [];
        foreach ($request->service_vehicle_categories as $svc) {
            foreach ($svc['groups'] as $g) {
                if (isset($g['id'])) array_push($group_ids, $g['id']);
            }
        }

        foreach ($object->service_vehicle_category_groups as $g) {
            if (!in_array($g->id, $group_ids)) {
                $used = BillService::where('group_id', $g->id)->first();
                if ($used) {
                    $json->success = false;
                    $json->message = "Nhóm ".$g->name." đã được đại lý G7 sử dụng. Không thể xóa";
                    return Response::json($json);
                }
            }
        }

        DB::beginTransaction();
        try {
            $object->name = $request->name;
            $object->points = $request->points;
            $object->service_type_id = $request->service_type_id;
            $object->updated_by = auth()->user()->id;
            $object->save();
            $object->syncVehicleCategories($request->service_vehicle_categories);
            $object->syncProducts($request->products);

            if ($request->image) {
                FileHelper::forceDeleteFiles($object->image->id, $object->id, ThisModel::class, 'image');
                FileHelper::uploadFile($request->image, 'services', $object->id, ThisModel::class, 'image',1);
            }

            DB::commit();
            $json->success = true;
            $json->message = 'Sửa thành công';
            return Response::json($json);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id) {
        $object = ThisModel::findOrFail($id);
        $object->status = 0;
        $object->save();
        $message = array(
            "message" => "Thao tác thành công!",
            "alert-type" => "success"
        );
        return redirect()->route($this->route.'.index')->with($message);
    }

    public function restore($id) {
        $object = ThisModel::findOrFail($id);
        $object->status = 1;
        $object->save();
        $message = array(
            "message" => "Thao tác thành công!",
            "alert-type" => "success"
        );
        return redirect()->route($this->route.'.index')->with($message);
    }


    public function searchDataForBill(Request $request)
    {
        $objects = ThisModel::searchDataForBill($request);

        return Datatables::of($objects)
            ->editColumn('price', function ($object) {
                return formatCurrency($object->price);
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function getDataForBill(Request $request) {
        $json = new stdclass();
        if (!$request->detail_id) {
            $json->success = false;
            $json->message = "Thiếu thông tin";
            return Response::json($json);
        }
        $json->success = true;
        $json->data = ThisModel::getDataForBill($request->detail_id);
        return Response::json($json);
    }

    public function searchAllForBill(Request $request) {
        $json = new stdclass();
        if (!$request->vehicle_category_id) {
            $json->success = false;
            $json->message = "Thiếu thông tin";
            return Response::json($json);
        }
        $json->success = true;
        $json->data = ThisModel::searchAllForBill($request->vehicle_category_id);
        return Response::json($json);
    }

    public function getServiceUptek() {
        $user = auth()->user();

        $servicesUptek = UptekService::query()->with([
            'products' => function($q) {
                $q->with([
                    'product' => function($q) {
                        $q->with([
                            'category' => function($q) {
                                $q->select(['id', 'name']);
                            }
                        ]);
                    }
                ]);
            },
            'service_vehicle_categories' => function($q) {
                $q->with([
                    'groups' => function($q) {
                        $q->with([
                            'products' => function($q) {
                                $q->with([
                                    'product'
                                ]);
                            },
                        ]);
                    }
                ]);
            },
            'image'
        ])->get();

        DB::beginTransaction();
        try {
            // xóa tất cả dịch vụ uptek cũ
            $serviceUptekCurrent = Service::query()
                ->where(['g7_id' => $user->g7_id, 'is_uptek' => true])
                ->whereNotIn('updated_by', [$user->id]);

            foreach ($serviceUptekCurrent->get() as $serivce_uptek_current) {
                $serivce_uptek_current->products()->delete();

                foreach ($serivce_uptek_current->service_vehicle_categories as $uptek_service_vehicle_category_current) {
                    foreach ($uptek_service_vehicle_category_current->groups as $uptek_service_vehicle_category_group_current) {
                        $uptek_service_vehicle_category_group_current->products()->delete();
                    }
                    $uptek_service_vehicle_category_current->groups()->delete();
                }
                $serivce_uptek_current->service_vehicle_categories()->delete();
            }

            $serviceUptekCurrent->delete();
            ////
            foreach ($servicesUptek as $service_uptek) {
                $attribute_service_uptek = ($service_uptek->getAttributes());
                unset($attribute_service_uptek['id']);
                $attribute_service_uptek['g7_id'] = $user->g7_id;
                $attribute_service_uptek['is_uptek'] = 1;
                $service = new Service();
                $service->fill($attribute_service_uptek);
                $service->save();
                $service->generateCode();
                $service->save();

                foreach ($service_uptek->service_vehicle_categories as $uptek_service_vehicle_category) {
                    $service_vehicle_category = new ServiceVehicleCategory();
                    $service_vehicle_category->service_id = $service->id;
                    $service_vehicle_category->vehicle_category_id = $uptek_service_vehicle_category->vehicle_category_id;
                    $service_vehicle_category->save();

                    foreach ($uptek_service_vehicle_category->groups as $uptek_group) {
                        $service_vehicle_category_group = new ServiceVehicleCategoryGroup();
                        $service_vehicle_category_group->name = $uptek_group->name;
                        $service_vehicle_category_group->parent_id = $service_vehicle_category->id;
                        $service_vehicle_category_group->service_id = $service->id;
                        $service_vehicle_category_group->points = $uptek_group->points;
                        $service_vehicle_category_group->service_price = $uptek_group->service_price;
                        $service_vehicle_category_group->save();

                        foreach ($uptek_group->products as $uptek_product) {
                            $service_vehicle_category_group_products = new ServiceVehicleCategoryGroupProduct();
                            $service_vehicle_category_group_products->qty = $uptek_product->qty;
                            $service_vehicle_category_group_products->product_id = $uptek_product->product_id;
                            $service_vehicle_category_group_products->parent_id  = $service_vehicle_category_group->id;
                            $service_vehicle_category_group_products->service_id  = $service->id;

                            $service_vehicle_category_group_products->save();
                        }
                    }
                }

                foreach ($service_uptek->products as $uptekProduct ) {
                    $service_products = new ServiceProduct();
                    $service_products->qty = $uptekProduct->qty;
                    $service_products->service_id = $service->id;
                    $service_products->product_id = $uptekProduct->product_id;

                    $service_products->save();
                }

            }

            DB::commit();
            $message = array(
                "message" => "Thao tác thành công!",
                "alert-type" => "success"
            );

            return redirect()->back()->with($message);
        }catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }

    }
}
