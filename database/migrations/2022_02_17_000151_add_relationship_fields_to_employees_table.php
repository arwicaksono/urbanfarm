<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeesTable extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_name_id')->nullable();
            $table->foreign('employee_name_id', 'employee_name_fk_5299857')->references('id')->on('users');
            $table->unsignedBigInteger('position_id')->nullable();
            $table->foreign('position_id', 'position_fk_5340016')->references('id')->on('employee_positions');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5340017')->references('id')->on('employee_statuses');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479746')->references('id')->on('teams');
        });
    }
}
