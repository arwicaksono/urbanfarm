<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlotStagesTable extends Migration
{
    public function up()
    {
        Schema::create('plot_stages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('period')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
