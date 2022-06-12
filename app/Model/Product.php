<?php

namespace App\Model;

use App\Model\BaseModel;
use App\Model\Common\ProductCategory;
use App\Model\G7\G7Product;
use App\Model\G7\G7ProductPrice;
use Illuminate\Database\Eloquent\Model;
use App\Model\Common\File;
use Illuminate\Support\Facades\Auth;
use App\Model\Common\User;

class Product extends BaseModel
{
    // Status = 1 =>> Hoạt động
    // Status = 0 =>> Khóa

    public const STATUSES = [
        [
            'id' => 1,
            'name' => 'Hoạt động',
            'type' => 'success'
        ],
        [
            'id' => 0,
            'name' => 'Khóa',
            'type' => 'danger'
        ]
    ];

    public function canDelete()
    {
        // Auth::user()->g7_id == $this->g7_id ? true : false;
        return false;
    }

    public function canEdit()
    {
        return Auth::user()->g7_id == $this->g7_id ? true : false;
    }

    public function g7_products()
    {
        return $this->hasMany(G7Product::class, 'root_product_id', 'id');
    }

    public function image()
    {
        return $this->morphOne(File::class, 'model');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function g7_price()
    {
        return $this->hasOne(G7ProductPrice::class, 'product_id')->where('g7_id', Auth::user()->g7_id);
    }

    public static function searchByFilter($request)
    {
        $result = self::with([
            'category',
            'image',
            'g7_price'
        ]);

        if (Auth::user()->g7_id) {
            $result = $result->where('g7_id', Auth::user()->g7_id);
        }

        if (!empty($request->name)) {
            $result = $result->where('name', 'like', '%' . $request->name . '%');
        }

        if (!empty($request->code)) {
            $result = $result->where('code', 'like', '%' . $request->code . '%');
        }

        if (!empty($request->product_category_id)) {
            $result = $result->where('product_category_id', $request->product_category_id);
        }

        if ($request->status === 0 || $request->status === '0' || !empty($request->status)) {
            $result = $result->where('status', $request->status);
        }

        $result = $result->orderBy('created_at', 'desc')->get();
        return $result;
    }

    public static function getForSelect()
    {
        return self::select(['id', 'name'])
            ->where('status', 1)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public static function getData($id)
    {
        return self::where('id', $id)
            ->select([
                '*', 'id as product_id', 'points'
            ])
            ->with([
                'category' => function ($q) {
                    $q->select(['id', 'name']);
                },
                'image',
                'g7_price'
            ])
            ->firstOrFail();
    }

    public function generateCode()
    {
        $this->code = User::find(Auth::user()->id)->g7Info->code .'.'. generateCode(6, $this->id);
        $this->save();
    }
}
