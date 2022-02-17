<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagTaskPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_task', function (Blueprint $table) {
            $table->unsignedBigInteger('task_id');
            $table->foreign('task_id', 'task_id_fk_5899829')->references('id')->on('tasks')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5899829')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
