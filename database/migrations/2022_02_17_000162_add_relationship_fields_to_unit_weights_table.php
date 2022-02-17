<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUnitWeightsTable extends Migration
{
    public function up()
    {
        Schema::table('unit_weights', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479780')->references('id')->on('teams');
        });
    }
}
