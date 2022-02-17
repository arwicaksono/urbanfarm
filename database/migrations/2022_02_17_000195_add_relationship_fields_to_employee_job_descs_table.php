<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeeJobDescsTable extends Migration
{
    public function up()
    {
        Schema::table('employee_job_descs', function (Blueprint $table) {
            $table->unsignedBigInteger('position_id')->nullable();
            $table->foreign('position_id', 'position_fk_5307656')->references('id')->on('employee_positions');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479743')->references('id')->on('teams');
        });
    }
}
