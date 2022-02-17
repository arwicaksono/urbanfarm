<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleObservationsTable extends Migration
{
    public function up()
    {
        Schema::create('module_observations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->integer('number')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('is_problem')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
