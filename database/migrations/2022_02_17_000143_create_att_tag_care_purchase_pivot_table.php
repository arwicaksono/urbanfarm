<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagCarePurchasePivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_care_purchase', function (Blueprint $table) {
            $table->unsignedBigInteger('care_purchase_id');
            $table->foreign('care_purchase_id', 'care_purchase_id_fk_5726703')->references('id')->on('care_purchases')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5726703')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
