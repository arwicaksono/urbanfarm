<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSitesTable extends Migration
{
    public function up()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id', 'unit_fk_5299804')->references('id')->on('unit_areas');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479753')->references('id')->on('teams');
        });
    }
}
