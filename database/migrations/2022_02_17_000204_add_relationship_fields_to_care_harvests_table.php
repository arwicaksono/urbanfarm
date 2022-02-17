<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCareHarvestsTable extends Migration
{
    public function up()
    {
        Schema::table('care_harvests', function (Blueprint $table) {
            $table->unsignedBigInteger('problem_harvest_id')->nullable();
            $table->foreign('problem_harvest_id', 'problem_harvest_fk_5726549')->references('id')->on('harvests');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5726553')->references('id')->on('att_statuses');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5726562')->references('id')->on('teams');
        });
    }
}
