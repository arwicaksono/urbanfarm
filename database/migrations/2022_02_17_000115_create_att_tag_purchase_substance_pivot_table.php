<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagPurchaseSubstancePivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_purchase_substance', function (Blueprint $table) {
            $table->unsignedBigInteger('purchase_substance_id');
            $table->foreign('purchase_substance_id', 'purchase_substance_id_fk_5307009')->references('id')->on('purchase_substances')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5307009')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
