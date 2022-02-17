<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttCategoryPurchaseSubstancePivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_category_purchase_substance', function (Blueprint $table) {
            $table->unsignedBigInteger('purchase_substance_id');
            $table->foreign('purchase_substance_id', 'purchase_substance_id_fk_5307008')->references('id')->on('purchase_substances')->onDelete('cascade');
            $table->unsignedBigInteger('att_category_id');
            $table->foreign('att_category_id', 'att_category_id_fk_5307008')->references('id')->on('att_categories')->onDelete('cascade');
        });
    }
}
