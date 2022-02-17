<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashflowSaleUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('cashflow_sale_user', function (Blueprint $table) {
            $table->unsignedBigInteger('cashflow_sale_id');
            $table->foreign('cashflow_sale_id', 'cashflow_sale_id_fk_5637518')->references('id')->on('cashflow_sales')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5637518')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
