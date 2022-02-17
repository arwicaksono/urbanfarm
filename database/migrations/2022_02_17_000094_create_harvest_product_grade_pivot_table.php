<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHarvestProductGradePivotTable extends Migration
{
    public function up()
    {
        Schema::create('harvest_product_grade', function (Blueprint $table) {
            $table->unsignedBigInteger('harvest_id');
            $table->foreign('harvest_id', 'harvest_id_fk_5537025')->references('id')->on('harvests')->onDelete('cascade');
            $table->unsignedBigInteger('product_grade_id');
            $table->foreign('product_grade_id', 'product_grade_id_fk_5537025')->references('id')->on('product_grades')->onDelete('cascade');
        });
    }
}
