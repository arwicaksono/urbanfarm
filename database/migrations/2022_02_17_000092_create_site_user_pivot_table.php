<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('site_user', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id');
            $table->foreign('site_id', 'site_id_fk_5397772')->references('id')->on('sites')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5397772')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
