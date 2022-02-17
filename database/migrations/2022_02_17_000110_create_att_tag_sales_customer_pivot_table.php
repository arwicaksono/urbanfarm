<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagSalesCustomerPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_sales_customer', function (Blueprint $table) {
            $table->unsignedBigInteger('sales_customer_id');
            $table->foreign('sales_customer_id', 'sales_customer_id_fk_5306930')->references('id')->on('sales_customers')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5306930')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
