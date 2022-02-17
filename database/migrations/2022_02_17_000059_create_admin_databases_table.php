<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminDatabasesTable extends Migration
{
    public function up()
    {
        Schema::create('admin_databases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->longText('cause')->nullable();
            $table->longText('prevention')->nullable();
            $table->longText('treatment')->nullable();
            $table->longText('recommendation')->nullable();
            $table->longText('source')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
