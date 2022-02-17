<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUnitQuantitiesTable extends Migration
{
    public function up()
    {
        Schema::table('unit_quantities', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479772')->references('id')->on('teams');
        });
    }
}
