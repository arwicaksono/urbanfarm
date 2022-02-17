<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleComponentModuleObservationPivotTable extends Migration
{
    public function up()
    {
        Schema::create('module_component_module_observation', function (Blueprint $table) {
            $table->unsignedBigInteger('module_observation_id');
            $table->foreign('module_observation_id', 'module_observation_id_fk_5306567')->references('id')->on('module_observations')->onDelete('cascade');
            $table->unsignedBigInteger('module_component_id');
            $table->foreign('module_component_id', 'module_component_id_fk_5306567')->references('id')->on('module_components')->onDelete('cascade');
        });
    }
}
