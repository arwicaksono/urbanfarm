<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagCareHarvestPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_care_harvest', function (Blueprint $table) {
            $table->unsignedBigInteger('care_harvest_id');
            $table->foreign('care_harvest_id', 'care_harvest_id_fk_5726554')->references('id')->on('care_harvests')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5726554')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
