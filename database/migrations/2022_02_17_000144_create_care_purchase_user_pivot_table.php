<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarePurchaseUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('care_purchase_user', function (Blueprint $table) {
            $table->unsignedBigInteger('care_purchase_id');
            $table->foreign('care_purchase_id', 'care_purchase_id_fk_5726707')->references('id')->on('care_purchases')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5726707')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
