<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagCashflowExpensePivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_cashflow_expense', function (Blueprint $table) {
            $table->unsignedBigInteger('cashflow_expense_id');
            $table->foreign('cashflow_expense_id', 'cashflow_expense_id_fk_5307632')->references('id')->on('cashflow_expenses')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5307632')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
