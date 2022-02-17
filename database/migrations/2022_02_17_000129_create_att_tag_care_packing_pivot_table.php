<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagCarePackingPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_care_packing', function (Blueprint $table) {
            $table->unsignedBigInteger('care_packing_id');
            $table->foreign('care_packing_id', 'care_packing_id_fk_5726572')->references('id')->on('care_packings')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5726572')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
