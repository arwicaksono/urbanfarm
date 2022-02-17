<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagCarePreOrderPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_care_pre_order', function (Blueprint $table) {
            $table->unsignedBigInteger('care_pre_order_id');
            $table->foreign('care_pre_order_id', 'care_pre_order_id_fk_5721295')->references('id')->on('care_pre_orders')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5721295')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
