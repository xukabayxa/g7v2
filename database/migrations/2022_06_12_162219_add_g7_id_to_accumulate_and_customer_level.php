<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddG7IdToAccumulateAndCustomerLevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_levels', function (Blueprint $table) {
            $table->unsignedBigInteger('g7_id')->nullable();
            $table->foreign('g7_id')->references('id')->on('g7_infos');
        });
        Schema::table('accumulate_points', function (Blueprint $table) {
            $table->unsignedBigInteger('g7_id')->nullable();
            $table->foreign('g7_id')->references('id')->on('g7_infos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_levels', function (Blueprint $table) {
            $table->dropForeign(['g7_id']);
			$table->dropColumn('g7_id');
        });
        Schema::table('accumulate_points', function (Blueprint $table) {
            $table->dropForeign(['g7_id']);
			$table->dropColumn('g7_id');
        });
    }
}
