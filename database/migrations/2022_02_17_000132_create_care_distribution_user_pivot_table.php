<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareDistributionUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('care_distribution_user', function (Blueprint $table) {
            $table->unsignedBigInteger('care_distribution_id');
            $table->foreign('care_distribution_id', 'care_distribution_id_fk_5726594')->references('id')->on('care_distributions')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5726594')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
