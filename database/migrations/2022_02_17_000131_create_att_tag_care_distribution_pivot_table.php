<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagCareDistributionPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_care_distribution', function (Blueprint $table) {
            $table->unsignedBigInteger('care_distribution_id');
            $table->foreign('care_distribution_id', 'care_distribution_id_fk_5726590')->references('id')->on('care_distributions')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5726590')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
