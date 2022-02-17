<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDistributionsTable extends Migration
{
    public function up()
    {
        Schema::table('distributions', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id', 'customer_fk_5300243')->references('id')->on('sales_customers');
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->foreign('channel_id', 'channel_fk_5300242')->references('id')->on('sales_channels');
            $table->unsignedBigInteger('market_id')->nullable();
            $table->foreign('market_id', 'market_fk_5300248')->references('id')->on('sales_markets');
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->foreign('delivery_id', 'delivery_fk_5300252')->references('id')->on('sales_deliveries');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5300244')->references('id')->on('att_statuses');
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->foreign('priority_id', 'priority_fk_5716242')->references('id')->on('att_priorities');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479619')->references('id')->on('teams');
        });
    }
}
