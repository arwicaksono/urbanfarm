<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminPlansTable extends Migration
{
    public function up()
    {
        Schema::create('admin_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->longText('feature')->nullable();
            $table->integer('price')->nullable();
            $table->integer('discount')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
