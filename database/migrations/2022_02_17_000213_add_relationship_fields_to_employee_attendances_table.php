<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeeAttendancesTable extends Migration
{
    public function up()
    {
        Schema::table('employee_attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('name_id')->nullable();
            $table->foreign('name_id', 'name_fk_5798165')->references('id')->on('users');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5798174')->references('id')->on('teams');
        });
    }
}
