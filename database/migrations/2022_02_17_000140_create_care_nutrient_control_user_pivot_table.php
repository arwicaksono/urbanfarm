<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareNutrientControlUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('care_nutrient_control_user', function (Blueprint $table) {
            $table->unsignedBigInteger('care_nutrient_control_id');
            $table->foreign('care_nutrient_control_id', 'care_nutrient_control_id_fk_5726670')->references('id')->on('care_nutrient_controls')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5726670')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
