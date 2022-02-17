<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashflowExpensesTable extends Migration
{
    public function up()
    {
        Schema::create('cashflow_expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('amount')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
