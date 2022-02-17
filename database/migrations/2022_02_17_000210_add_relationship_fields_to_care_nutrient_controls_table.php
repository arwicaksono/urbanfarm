<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCareNutrientControlsTable extends Migration
{
    public function up()
    {
        Schema::table('care_nutrient_controls', function (Blueprint $table) {
            $table->unsignedBigInteger('problem_nc_id')->nullable();
            $table->foreign('problem_nc_id', 'problem_nc_fk_5726660')->references('id')->on('nutrient_controls');
            $table->unsignedBigInteger('efficacy_id')->nullable();
            $table->foreign('efficacy_id', 'efficacy_fk_5726664')->references('id')->on('att_efficacies');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5726665')->references('id')->on('att_statuses');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5726674')->references('id')->on('teams');
        });
    }
}
