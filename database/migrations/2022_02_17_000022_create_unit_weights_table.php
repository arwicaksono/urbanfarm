<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitWeightsTable extends Migration
{
    public function up()
    {
        Schema::create('unit_weights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('metric')->nullable();
            $table->string('imperial')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
