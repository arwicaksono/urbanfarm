<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagPackingPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_packing', function (Blueprint $table) {
            $table->unsignedBigInteger('packing_id');
            $table->foreign('packing_id', 'packing_id_fk_5300076')->references('id')->on('packings')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5300076')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
