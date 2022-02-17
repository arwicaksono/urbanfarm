<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagSiteInspectionPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_site_inspection', function (Blueprint $table) {
            $table->unsignedBigInteger('site_inspection_id');
            $table->foreign('site_inspection_id', 'site_inspection_id_fk_5300376')->references('id')->on('site_inspections')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5300376')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
