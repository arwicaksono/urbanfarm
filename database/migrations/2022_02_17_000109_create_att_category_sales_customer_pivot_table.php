<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttCategorySalesCustomerPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_category_sales_customer', function (Blueprint $table) {
            $table->unsignedBigInteger('sales_customer_id');
            $table->foreign('sales_customer_id', 'sales_customer_id_fk_5306929')->references('id')->on('sales_customers')->onDelete('cascade');
            $table->unsignedBigInteger('att_category_id');
            $table->foreign('att_category_id', 'att_category_id_fk_5306929')->references('id')->on('att_categories')->onDelete('cascade');
        });
    }
}
