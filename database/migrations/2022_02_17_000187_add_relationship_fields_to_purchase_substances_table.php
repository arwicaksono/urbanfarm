<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPurchaseSubstancesTable extends Migration
{
    public function up()
    {
        Schema::table('purchase_substances', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id', 'unit_fk_5307013')->references('id')->on('unit_weights');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5487627')->references('id')->on('teams');
        });
    }
}
