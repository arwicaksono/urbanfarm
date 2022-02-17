<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUnitTemperaturesTable extends Migration
{
    public function up()
    {
        Schema::table('unit_temperatures', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479779')->references('id')->on('teams');
        });
    }
}
