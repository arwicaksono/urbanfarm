<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarePreOrderUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('care_pre_order_user', function (Blueprint $table) {
            $table->unsignedBigInteger('care_pre_order_id');
            $table->foreign('care_pre_order_id', 'care_pre_order_id_fk_5721297')->references('id')->on('care_pre_orders')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5721297')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
