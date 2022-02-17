<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCareSalesTable extends Migration
{
    public function up()
    {
        Schema::table('care_sales', function (Blueprint $table) {
            $table->unsignedBigInteger('problem_sale_id')->nullable();
            $table->foreign('problem_sale_id', 'problem_sale_fk_5726679')->references('id')->on('cashflow_sales');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5726683')->references('id')->on('att_statuses');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5726692')->references('id')->on('teams');
        });
    }
}
