<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCashflowExpensesTable extends Migration
{
    public function up()
    {
        Schema::table('cashflow_expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'category_fk_5307631')->references('id')->on('cashflow_expense_categories');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479650')->references('id')->on('teams');
        });
    }
}
