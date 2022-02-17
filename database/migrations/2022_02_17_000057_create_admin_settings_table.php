<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('copyright')->nullable();
            $table->boolean('dark_mode')->default(0)->nullable();
            $table->boolean('rtl')->default(0)->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
