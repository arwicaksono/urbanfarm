<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPlantAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::table('plant_assessments', function (Blueprint $table) {
            $table->unsignedBigInteger('plot_id')->nullable();
            $table->foreign('plot_id', 'plot_fk_5644277')->references('id')->on('plots');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id', 'unit_fk_5300392')->references('id')->on('unit_ages');
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->foreign('priority_id', 'priority_fk_5300395')->references('id')->on('att_priorities');
            $table->unsignedBigInteger('person_in_charge_id')->nullable();
            $table->foreign('person_in_charge_id', 'person_in_charge_fk_5300398')->references('id')->on('users');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479593')->references('id')->on('teams');
        });
    }
}
