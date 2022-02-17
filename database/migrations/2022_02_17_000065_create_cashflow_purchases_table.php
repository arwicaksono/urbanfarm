<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashflowPurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('cashflow_purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->integer('number')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('name')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('unit_price')->nullable();
            $table->float('discount', 5, 2)->nullable();
            $table->integer('total_price')->nullable();
            $table->string('is_expense')->nullable();
            $table->string('is_problem')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
