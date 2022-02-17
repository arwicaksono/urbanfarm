<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlotCodesTable extends Migration
{
    public function up()
    {
        Schema::create('plot_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('prefix')->nullable();
            $table->string('plant')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
