<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagHarvestPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_harvest', function (Blueprint $table) {
            $table->unsignedBigInteger('harvest_id');
            $table->foreign('harvest_id', 'harvest_id_fk_5300064')->references('id')->on('harvests')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5300064')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
