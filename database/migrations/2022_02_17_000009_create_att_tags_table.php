<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagsTable extends Migration
{
    public function up()
    {
        Schema::create('att_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('group')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
