<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributionUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('distribution_user', function (Blueprint $table) {
            $table->unsignedBigInteger('distribution_id');
            $table->foreign('distribution_id', 'distribution_id_fk_5300246')->references('id')->on('distributions')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5300246')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
