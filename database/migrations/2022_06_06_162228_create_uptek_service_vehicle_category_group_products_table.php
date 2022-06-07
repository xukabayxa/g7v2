<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUptekServiceVehicleCategoryGroupProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uptek_service_vehicle_category_group_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('qty', 16, 2);
            $table->bigInteger('product_id');
            $table->bigInteger('parent_id');
            $table->bigInteger('service_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uptek_service_vehicle_category_group_products');
    }
}
