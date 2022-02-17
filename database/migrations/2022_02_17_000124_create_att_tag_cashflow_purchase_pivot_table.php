<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagCashflowPurchasePivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_cashflow_purchase', function (Blueprint $table) {
            $table->unsignedBigInteger('cashflow_purchase_id');
            $table->foreign('cashflow_purchase_id', 'cashflow_purchase_id_fk_5637570')->references('id')->on('cashflow_purchases')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5637570')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
