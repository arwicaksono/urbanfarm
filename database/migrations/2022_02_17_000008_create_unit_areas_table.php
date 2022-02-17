<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitAreasTable extends Migration
{
    public function up()
    {
        Schema::create('unit_areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('metric')->nullable();
            $table->string('imperial')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
