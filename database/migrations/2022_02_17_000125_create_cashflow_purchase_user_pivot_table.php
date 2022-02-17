<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashflowPurchaseUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('cashflow_purchase_user', function (Blueprint $table) {
            $table->unsignedBigInteger('cashflow_purchase_id');
            $table->foreign('cashflow_purchase_id', 'cashflow_purchase_id_fk_5637573')->references('id')->on('cashflow_purchases')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5637573')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
