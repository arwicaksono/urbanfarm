<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTasksTable extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5899828')->references('id')->on('att_statuses');
            $table->unsignedBigInteger('assigned_to_id')->nullable();
            $table->foreign('assigned_to_id', 'assigned_to_fk_5899833')->references('id')->on('users');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5899837')->references('id')->on('teams');
        });
    }
}
