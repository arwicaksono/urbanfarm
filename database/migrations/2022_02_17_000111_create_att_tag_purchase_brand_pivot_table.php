<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagPurchaseBrandPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_purchase_brand', function (Blueprint $table) {
            $table->unsignedBigInteger('purchase_brand_id');
            $table->foreign('purchase_brand_id', 'purchase_brand_id_fk_5306952')->references('id')->on('purchase_brands')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5306952')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
