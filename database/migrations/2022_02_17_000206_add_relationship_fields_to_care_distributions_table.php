<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCareDistributionsTable extends Migration
{
    public function up()
    {
        Schema::table('care_distributions', function (Blueprint $table) {
            $table->unsignedBigInteger('problem_dist_id')->nullable();
            $table->foreign('problem_dist_id', 'problem_dist_fk_5726585')->references('id')->on('distributions');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5726589')->references('id')->on('att_statuses');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5726598')->references('id')->on('teams');
        });
    }
}
