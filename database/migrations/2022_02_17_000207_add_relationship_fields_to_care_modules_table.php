<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCareModulesTable extends Migration
{
    public function up()
    {
        Schema::table('care_modules', function (Blueprint $table) {
            $table->unsignedBigInteger('problem_mo_id')->nullable();
            $table->foreign('problem_mo_id', 'problem_mo_fk_5726603')->references('id')->on('module_observations');
            $table->unsignedBigInteger('efficacy_id')->nullable();
            $table->foreign('efficacy_id', 'efficacy_fk_5726607')->references('id')->on('att_efficacies');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5726608')->references('id')->on('att_statuses');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5726617')->references('id')->on('teams');
        });
    }
}
