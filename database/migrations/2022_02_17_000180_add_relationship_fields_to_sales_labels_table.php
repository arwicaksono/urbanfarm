<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSalesLabelsTable extends Migration
{
    public function up()
    {
        Schema::table('sales_labels', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id', 'unit_fk_5306901')->references('id')->on('unit_quantities');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479729')->references('id')->on('teams');
        });
    }
}
