<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarePackingUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('care_packing_user', function (Blueprint $table) {
            $table->unsignedBigInteger('care_packing_id');
            $table->foreign('care_packing_id', 'care_packing_id_fk_5726576')->references('id')->on('care_packings')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5726576')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
