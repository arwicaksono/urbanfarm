<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('business_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->integer('phone')->nullable();
            $table->integer('whatsapp')->nullable();
            $table->integer('telegram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linked_in')->nullable();
            $table->string('youtube')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('reddit')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
