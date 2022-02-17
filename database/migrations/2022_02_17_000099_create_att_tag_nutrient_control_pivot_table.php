<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagNutrientControlPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_nutrient_control', function (Blueprint $table) {
            $table->unsignedBigInteger('nutrient_control_id');
            $table->foreign('nutrient_control_id', 'nutrient_control_id_fk_5300181')->references('id')->on('nutrient_controls')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5300181')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
