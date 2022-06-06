<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColTypeToAccumulatePoints extends Migration
{

    public function up()
    {
        Schema::table('accumulate_points', function (Blueprint $table) {
            $table->integer('type')->default(1);
        });
    }

    public function down()
    {
        Schema::table('accumulate_points', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
