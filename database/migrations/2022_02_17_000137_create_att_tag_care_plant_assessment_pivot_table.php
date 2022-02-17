<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagCarePlantAssessmentPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_care_plant_assessment', function (Blueprint $table) {
            $table->unsignedBigInteger('care_plant_assessment_id');
            $table->foreign('care_plant_assessment_id', 'care_plant_assessment_id_fk_5726647')->references('id')->on('care_plant_assessments')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5726647')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
