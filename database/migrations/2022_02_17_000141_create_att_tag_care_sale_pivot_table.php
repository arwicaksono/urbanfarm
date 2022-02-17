<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagCareSalePivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_care_sale', function (Blueprint $table) {
            $table->unsignedBigInteger('care_sale_id');
            $table->foreign('care_sale_id', 'care_sale_id_fk_5726684')->references('id')->on('care_sales')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5726684')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
