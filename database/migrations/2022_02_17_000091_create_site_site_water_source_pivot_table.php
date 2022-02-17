<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSiteWaterSourcePivotTable extends Migration
{
    public function up()
    {
        Schema::create('site_site_water_source', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id');
            $table->foreign('site_id', 'site_id_fk_5299799')->references('id')->on('sites')->onDelete('cascade');
            $table->unsignedBigInteger('site_water_source_id');
            $table->foreign('site_water_source_id', 'site_water_source_id_fk_5299799')->references('id')->on('site_water_sources')->onDelete('cascade');
        });
    }
}
