<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->integer('number')->nullable();
            $table->string('name')->nullable();
            $table->string('location')->nullable();
            $table->integer('elevation')->nullable();
            $table->integer('acreage')->nullable();
            $table->string('is_active')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
