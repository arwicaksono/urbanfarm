<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarePreOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('care_pre_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->integer('number')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->integer('qty')->nullable();
            $table->date('date_due')->nullable();
            $table->time('time_due')->nullable();
            $table->date('date_delivery')->nullable();
            $table->time('time_delivery')->nullable();
            $table->string('payment')->nullable();
            $table->string('is_done')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
