<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHarvestPackingPivotTable extends Migration
{
    public function up()
    {
        Schema::create('harvest_packing', function (Blueprint $table) {
            $table->unsignedBigInteger('packing_id');
            $table->foreign('packing_id', 'packing_id_fk_5300084')->references('id')->on('packings')->onDelete('cascade');
            $table->unsignedBigInteger('harvest_id');
            $table->foreign('harvest_id', 'harvest_id_fk_5300084')->references('id')->on('harvests')->onDelete('cascade');
        });
    }
}
