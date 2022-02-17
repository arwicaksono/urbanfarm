<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeeLeavesTable extends Migration
{
    public function up()
    {
        Schema::table('employee_leaves', function (Blueprint $table) {
            $table->unsignedBigInteger('name_id')->nullable();
            $table->foreign('name_id', 'name_fk_5798176')->references('id')->on('users');
            $table->unsignedBigInteger('leave_type_id')->nullable();
            $table->foreign('leave_type_id', 'leave_type_fk_5798204')->references('id')->on('emp_leave_types');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5798183')->references('id')->on('teams');
        });
    }
}
