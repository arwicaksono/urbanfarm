<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagCashflowIncomePivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_cashflow_income', function (Blueprint $table) {
            $table->unsignedBigInteger('cashflow_income_id');
            $table->foreign('cashflow_income_id', 'cashflow_income_id_fk_5307620')->references('id')->on('cashflow_incomes')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5307620')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
