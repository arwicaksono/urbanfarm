<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToModulesTable extends Migration
{
    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->unsignedBigInteger('site_code_id')->nullable();
            $table->foreign('site_code_id', 'site_code_fk_5860615')->references('id')->on('sites');
            $table->unsignedBigInteger('system_id')->nullable();
            $table->foreign('system_id', 'system_fk_5299912')->references('id')->on('module_systems');
            $table->unsignedBigInteger('lighting_id')->nullable();
            $table->foreign('lighting_id', 'lighting_fk_5299926')->references('id')->on('module_components');
            $table->unsignedBigInteger('reservoir_id')->nullable();
            $table->foreign('reservoir_id', 'reservoir_fk_5716184')->references('id')->on('module_components');
            $table->unsignedBigInteger('pump_id')->nullable();
            $table->foreign('pump_id', 'pump_fk_5306709')->references('id')->on('module_components');
            $table->unsignedBigInteger('mounting_id')->nullable();
            $table->foreign('mounting_id', 'mounting_fk_5306710')->references('id')->on('module_components');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id', 'unit_fk_5716186')->references('id')->on('unit_capacities');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479763')->references('id')->on('teams');
        });
    }
}
