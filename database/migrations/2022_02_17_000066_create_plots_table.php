<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlotsTable extends Migration
{
    public function up()
    {
        Schema::create('plots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->integer('number')->nullable();
            $table->integer('plot_qty')->nullable();
            $table->date('date_start')->nullable();
            $table->time('time_start')->nullable();
            $table->date('date_end')->nullable();
            $table->time('time_end')->nullable();
            $table->string('is_active')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
