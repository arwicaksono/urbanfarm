<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCarePreOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('care_pre_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id', 'customer_fk_5567747')->references('id')->on('sales_customers');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id', 'product_fk_5567748')->references('id')->on('plot_plants');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id', 'unit_fk_5599456')->references('id')->on('unit_quantities');
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->foreign('priority_id', 'priority_fk_5716243')->references('id')->on('att_priorities');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479625')->references('id')->on('teams');
        });
    }
}
