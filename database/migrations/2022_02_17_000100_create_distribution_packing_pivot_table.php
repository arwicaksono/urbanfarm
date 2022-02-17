<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributionPackingPivotTable extends Migration
{
    public function up()
    {
        Schema::create('distribution_packing', function (Blueprint $table) {
            $table->unsignedBigInteger('distribution_id');
            $table->foreign('distribution_id', 'distribution_id_fk_5300247')->references('id')->on('distributions')->onDelete('cascade');
            $table->unsignedBigInteger('packing_id');
            $table->foreign('packing_id', 'packing_id_fk_5300247')->references('id')->on('packings')->onDelete('cascade');
        });
    }
}
