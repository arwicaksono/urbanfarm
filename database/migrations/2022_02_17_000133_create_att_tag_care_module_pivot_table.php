<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagCareModulePivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_care_module', function (Blueprint $table) {
            $table->unsignedBigInteger('care_module_id');
            $table->foreign('care_module_id', 'care_module_id_fk_5726609')->references('id')->on('care_modules')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5726609')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
