<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeLeavesTable extends Migration
{
    public function up()
    {
        Schema::create('employee_leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
