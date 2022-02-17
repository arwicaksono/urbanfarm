<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareModuleUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('care_module_user', function (Blueprint $table) {
            $table->unsignedBigInteger('care_module_id');
            $table->foreign('care_module_id', 'care_module_id_fk_5726613')->references('id')->on('care_modules')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5726613')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
