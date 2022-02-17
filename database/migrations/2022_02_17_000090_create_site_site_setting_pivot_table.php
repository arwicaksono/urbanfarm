<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSiteSettingPivotTable extends Migration
{
    public function up()
    {
        Schema::create('site_site_setting', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id');
            $table->foreign('site_id', 'site_id_fk_5299798')->references('id')->on('sites')->onDelete('cascade');
            $table->unsignedBigInteger('site_setting_id');
            $table->foreign('site_setting_id', 'site_setting_id_fk_5299798')->references('id')->on('site_settings')->onDelete('cascade');
        });
    }
}
