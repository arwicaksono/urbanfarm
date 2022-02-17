<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagModuleObservationPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_module_observation', function (Blueprint $table) {
            $table->unsignedBigInteger('module_observation_id');
            $table->foreign('module_observation_id', 'module_observation_id_fk_5300408')->references('id')->on('module_observations')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5300408')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
