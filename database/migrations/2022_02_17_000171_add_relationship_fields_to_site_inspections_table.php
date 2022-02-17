<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSiteInspectionsTable extends Migration
{
    public function up()
    {
        Schema::table('site_inspections', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->nullable();
            $table->foreign('site_id', 'site_fk_5300372')->references('id')->on('sites');
            $table->unsignedBigInteger('weather_id')->nullable();
            $table->foreign('weather_id', 'weather_fk_5300375')->references('id')->on('site_weathers');
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->foreign('priority_id', 'priority_fk_5300378')->references('id')->on('att_priorities');
            $table->unsignedBigInteger('person_in_charge_id')->nullable();
            $table->foreign('person_in_charge_id', 'person_in_charge_fk_5300381')->references('id')->on('users');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479596')->references('id')->on('teams');
        });
    }
}
