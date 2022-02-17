<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareHarvestUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('care_harvest_user', function (Blueprint $table) {
            $table->unsignedBigInteger('care_harvest_id');
            $table->foreign('care_harvest_id', 'care_harvest_id_fk_5726558')->references('id')->on('care_harvests')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5726558')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
