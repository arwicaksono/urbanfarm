<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCashflowPurchasesTable extends Migration
{
    public function up()
    {
        Schema::table('cashflow_purchases', function (Blueprint $table) {
            $table->unsignedBigInteger('is_priority_id')->nullable();
            $table->foreign('is_priority_id', 'is_priority_fk_5759753')->references('id')->on('att_priorities');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5637569')->references('id')->on('att_statuses');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5637577')->references('id')->on('teams');
        });
    }
}
