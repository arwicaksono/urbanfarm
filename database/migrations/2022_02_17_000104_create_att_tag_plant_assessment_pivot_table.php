<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagPlantAssessmentPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_plant_assessment', function (Blueprint $table) {
            $table->unsignedBigInteger('plant_assessment_id');
            $table->foreign('plant_assessment_id', 'plant_assessment_id_fk_5300393')->references('id')->on('plant_assessments')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5300393')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
