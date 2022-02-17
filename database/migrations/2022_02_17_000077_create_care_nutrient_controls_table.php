<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareNutrientControlsTable extends Migration
{
    public function up()
    {
        Schema::create('care_nutrient_controls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->integer('number')->nullable();
            $table->date('date')->nullable();
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();
            $table->string('action')->nullable();
            $table->string('is_done')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
