<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSalesMarketsTable extends Migration
{
    public function up()
    {
        Schema::table('sales_markets', function (Blueprint $table) {
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->foreign('channel_id', 'channel_fk_5599554')->references('id')->on('sales_channels');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->foreign('payment_id', 'payment_fk_6010052')->references('id')->on('sales_payments');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479730')->references('id')->on('teams');
        });
    }
}
