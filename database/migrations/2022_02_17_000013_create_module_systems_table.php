<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleSystemsTable extends Migration
{
    public function up()
    {
        Schema::create('module_systems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
