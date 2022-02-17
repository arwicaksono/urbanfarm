<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarePlantAssessmentUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('care_plant_assessment_user', function (Blueprint $table) {
            $table->unsignedBigInteger('care_plant_assessment_id');
            $table->foreign('care_plant_assessment_id', 'care_plant_assessment_id_fk_5726651')->references('id')->on('care_plant_assessments')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5726651')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
