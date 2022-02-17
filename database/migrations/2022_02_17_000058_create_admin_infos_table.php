<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminInfosTable extends Migration
{
    public function up()
    {
        Schema::create('admin_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->longText('other')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
