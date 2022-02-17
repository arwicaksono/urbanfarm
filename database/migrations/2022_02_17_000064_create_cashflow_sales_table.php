<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashflowSalesTable extends Migration
{
    public function up()
    {
        Schema::create('cashflow_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->integer('number')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->integer('sales_qty')->nullable();
            $table->integer('unit_price')->nullable();
            $table->float('discount', 5, 2)->nullable();
            $table->integer('total_price')->nullable();
            $table->string('is_income')->nullable();
            $table->string('is_active')->nullable();
            $table->string('is_problem')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
