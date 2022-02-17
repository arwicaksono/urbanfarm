<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagDistributionPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_distribution', function (Blueprint $table) {
            $table->unsignedBigInteger('distribution_id');
            $table->foreign('distribution_id', 'distribution_id_fk_5300254')->references('id')->on('distributions')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5300254')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
