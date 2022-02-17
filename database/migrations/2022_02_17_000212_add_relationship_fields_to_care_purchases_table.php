<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCarePurchasesTable extends Migration
{
    public function up()
    {
        Schema::table('care_purchases', function (Blueprint $table) {
            $table->unsignedBigInteger('problem_purchase_id')->nullable();
            $table->foreign('problem_purchase_id', 'problem_purchase_fk_5726698')->references('id')->on('cashflow_purchases');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5726702')->references('id')->on('att_statuses');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5726711')->references('id')->on('teams');
        });
    }
}
