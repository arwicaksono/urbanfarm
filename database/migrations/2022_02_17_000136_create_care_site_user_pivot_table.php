<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareSiteUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('care_site_user', function (Blueprint $table) {
            $table->unsignedBigInteger('care_site_id');
            $table->foreign('care_site_id', 'care_site_id_fk_5726632')->references('id')->on('care_sites')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5726632')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
