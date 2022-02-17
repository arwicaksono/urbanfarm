<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleModuleActivityPivotTable extends Migration
{
    public function up()
    {
        Schema::create('module_module_activity', function (Blueprint $table) {
            $table->unsignedBigInteger('module_id');
            $table->foreign('module_id', 'module_id_fk_5716187')->references('id')->on('modules')->onDelete('cascade');
            $table->unsignedBigInteger('module_activity_id');
            $table->foreign('module_activity_id', 'module_activity_id_fk_5716187')->references('id')->on('module_activities')->onDelete('cascade');
        });
    }
}
