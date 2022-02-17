<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSiteWaterSourcesTable extends Migration
{
    public function up()
    {
        Schema::table('site_water_sources', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479751')->references('id')->on('teams');
        });
    }
}
