<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCashflowExpenseCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('cashflow_expense_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479649')->references('id')->on('teams');
        });
    }
}
