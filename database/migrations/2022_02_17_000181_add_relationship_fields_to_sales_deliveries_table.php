<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSalesDeliveriesTable extends Migration
{
    public function up()
    {
        Schema::table('sales_deliveries', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479728')->references('id')->on('teams');
        });
    }
}
