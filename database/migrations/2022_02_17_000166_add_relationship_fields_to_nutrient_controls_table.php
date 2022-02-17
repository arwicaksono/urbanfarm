<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToNutrientControlsTable extends Migration
{
    public function up()
    {
        Schema::table('nutrient_controls', function (Blueprint $table) {
            $table->unsignedBigInteger('module_id')->nullable();
            $table->foreign('module_id', 'module_fk_5300184')->references('id')->on('modules');
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->foreign('priority_id', 'priority_fk_5300194')->references('id')->on('att_priorities');
            $table->unsignedBigInteger('person_in_charge_id')->nullable();
            $table->foreign('person_in_charge_id', 'person_in_charge_fk_5300185')->references('id')->on('users');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479594')->references('id')->on('teams');
        });
    }
}
