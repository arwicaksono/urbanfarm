<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareSaleUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('care_sale_user', function (Blueprint $table) {
            $table->unsignedBigInteger('care_sale_id');
            $table->foreign('care_sale_id', 'care_sale_id_fk_5726688')->references('id')->on('care_sales')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5726688')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
