<?php

use App\ExcelImports\ImportVehicleData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class ImportVehicleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('vehicle_manufacts')->truncate();
        DB::table('vehicle_types')->truncate();
        DB::table('vehicle_categories')->truncate();
        Excel::import(new ImportVehicleData(), storage_path('G7-Dong xe.xlsx'));
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
