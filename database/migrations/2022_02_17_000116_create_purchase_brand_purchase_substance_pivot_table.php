<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseBrandPurchaseSubstancePivotTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_brand_purchase_substance', function (Blueprint $table) {
            $table->unsignedBigInteger('purchase_substance_id');
            $table->foreign('purchase_substance_id', 'purchase_substance_id_fk_5307010')->references('id')->on('purchase_substances')->onDelete('cascade');
            $table->unsignedBigInteger('purchase_brand_id');
            $table->foreign('purchase_brand_id', 'purchase_brand_id_fk_5307010')->references('id')->on('purchase_brands')->onDelete('cascade');
        });
    }
}
