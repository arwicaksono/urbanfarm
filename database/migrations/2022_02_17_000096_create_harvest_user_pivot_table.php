<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHarvestUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('harvest_user', function (Blueprint $table) {
            $table->unsignedBigInteger('harvest_id');
            $table->foreign('harvest_id', 'harvest_id_fk_5300060')->references('id')->on('harvests')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5300060')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
