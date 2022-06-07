<?php

namespace App\Model\Uptek;

use App\Model\Common\VehicleCategory;
use Illuminate\Database\Eloquent\Model;

class UptekServiceVehicleCategory extends Model
{
    protected $table = 'uptek_service_vehicle_categories';

    public function groups()
    {
        return $this->hasMany(UptekServiceVehicleCategoryGroup::class, 'parent_id','id');
    }

    public function syncGroups($items) {
        $items = $items ?: [];
        $ids = array_map('getId', $items);
        $delete_items = UptekServiceVehicleCategoryGroup::where('parent_id', $this->id)->whereNotIn('id', $ids)->get();
        foreach ($delete_items as $i) {
            $i->removeFromDB();
        }
        foreach ($items as $i) {
            if (isset($i['id'])) $item = UptekServiceVehicleCategoryGroup::where('parent_id', $this->id)->where('id', $i['id'])->first();
            else $item = new UptekServiceVehicleCategoryGroup();
            $item->parent_id = $this->id;
            $item->service_id = $this->service_id;
            $item->name = $i['name'];
            $item->service_price = $i['service_price'];
            $item->points = $i['points'];
            $item->save();

            $item->syncProducts($i['products']);
        }
    }

    public function removeFromDB() {
        foreach($this->groups as $g) {
            $g->removeFromDB();
        }
        $this->delete();
    }
}
