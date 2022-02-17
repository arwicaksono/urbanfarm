<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagCashflowSalePivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_cashflow_sale', function (Blueprint $table) {
            $table->unsignedBigInteger('cashflow_sale_id');
            $table->foreign('cashflow_sale_id', 'cashflow_sale_id_fk_5637512')->references('id')->on('cashflow_sales')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5637512')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
