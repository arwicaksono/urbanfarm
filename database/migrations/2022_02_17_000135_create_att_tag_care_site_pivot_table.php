<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagCareSitePivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_care_site', function (Blueprint $table) {
            $table->unsignedBigInteger('care_site_id');
            $table->foreign('care_site_id', 'care_site_id_fk_5726628')->references('id')->on('care_sites')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5726628')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
