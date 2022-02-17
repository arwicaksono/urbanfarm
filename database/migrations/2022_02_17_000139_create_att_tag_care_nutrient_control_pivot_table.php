<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagCareNutrientControlPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_care_nutrient_control', function (Blueprint $table) {
            $table->unsignedBigInteger('care_nutrient_control_id');
            $table->foreign('care_nutrient_control_id', 'care_nutrient_control_id_fk_5726666')->references('id')->on('care_nutrient_controls')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5726666')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
