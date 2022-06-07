<?php

namespace App\Model\Uptek;

use App\Model\Product;
use App\Model\Common\VehicleCategory;
use Illuminate\Database\Eloquent\Model;

class UptekServiceVehicleCategoryGroupProduct extends Model
{
    protected $table = 'uptek_service_vehicle_category_group_products';

    public $timestamps = false;

    public function product ()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}
