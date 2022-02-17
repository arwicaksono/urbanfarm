<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseCompanySalesLabelPivotTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_company_sales_label', function (Blueprint $table) {
            $table->unsignedBigInteger('sales_label_id');
            $table->foreign('sales_label_id', 'sales_label_id_fk_5306902')->references('id')->on('sales_labels')->onDelete('cascade');
            $table->unsignedBigInteger('purchase_company_id');
            $table->foreign('purchase_company_id', 'purchase_company_id_fk_5306902')->references('id')->on('purchase_companies')->onDelete('cascade');
        });
    }
}
