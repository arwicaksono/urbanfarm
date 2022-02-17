<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagSalesMarketPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_sales_market', function (Blueprint $table) {
            $table->unsignedBigInteger('sales_market_id');
            $table->foreign('sales_market_id', 'sales_market_id_fk_5306878')->references('id')->on('sales_markets')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5306878')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
