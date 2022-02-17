<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNutrientControlsTable extends Migration
{
    public function up()
    {
        Schema::create('nutrient_controls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->integer('number')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->integer('ppm')->nullable();
            $table->integer('ec')->nullable();
            $table->integer('ph')->nullable();
            $table->integer('temperature')->nullable();
            $table->string('is_problem')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
