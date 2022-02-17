<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCarePlantAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::table('care_plant_assessments', function (Blueprint $table) {
            $table->unsignedBigInteger('problem_pa_id')->nullable();
            $table->foreign('problem_pa_id', 'problem_pa_fk_5726641')->references('id')->on('plant_assessments');
            $table->unsignedBigInteger('efficacy_id')->nullable();
            $table->foreign('efficacy_id', 'efficacy_fk_5726645')->references('id')->on('att_efficacies');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5726646')->references('id')->on('att_statuses');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5726655')->references('id')->on('teams');
        });
    }
}
