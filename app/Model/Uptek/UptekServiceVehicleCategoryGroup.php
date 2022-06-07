<?php

namespace App\Model\Uptek;

use App\Model\Product;
use App\Model\Common\VehicleCategory;
use Illuminate\Database\Eloquent\Model;

class UptekServiceVehicleCategoryGroup extends Model
{
    protected $table = 'uptek_service_vehicle_category_groups';

    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(UptekServiceVehicleCategoryGroupProduct::class, 'parent_id','id');
    }

    public function service ()
    {
        return $this->belongsTo(Service::class, 'service_id','id');
    }

    public function syncProducts($items) {
        UptekServiceVehicleCategoryGroupProduct::where('parent_id', $this->id)->delete();
        if ($items) {
            foreach ($items as $i) {
                $item = new UptekServiceVehicleCategoryGroupProduct();
                $item->parent_id = $this->id;
                $item->service_id = $this->service_id;
                $item->product_id = $i['product_id'];
                $item->qty = $i['qty'];
                $item->save();
            }
        }
    }

    public function removeFromDB() {
        foreach($this->products as $p) {
            $p->removeFromDB();
        }
        $this->delete();
    }
}
