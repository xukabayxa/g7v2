<?php

namespace App\ExcelImports;

use App\Model\Common\VehicleCategory;
use App\Model\Common\VehicleManufact;
use App\Model\Common\VehicleType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportVehicleData implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if ($row['hang_xe'] && $row['loai_xe'] && $row['dong_xe']) {
                $manufact = VehicleManufact::firstOrCreate([
                    'name' => $row['hang_xe']
                ]);
                $category = VehicleCategory::firstOrCreate([
                    'name' => $row['dong_xe']
                ]);
                $type = VehicleType::firstOrCreate([
                    'name' => $row['loai_xe'],
                    'vehicle_manufact_id' => $manufact->id,
                    'vehicle_category_id' => $category->id
                ]);
                var_dump($type->name);
            }
        }
    }

}
