<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttCategoryCompsTable extends Migration
{
    public function up()
    {
        Schema::create('att_category_comps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
