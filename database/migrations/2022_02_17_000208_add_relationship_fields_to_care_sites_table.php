<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCareSitesTable extends Migration
{
    public function up()
    {
        Schema::table('care_sites', function (Blueprint $table) {
            $table->unsignedBigInteger('problem_si_id')->nullable();
            $table->foreign('problem_si_id', 'problem_si_fk_5726622')->references('id')->on('site_inspections');
            $table->unsignedBigInteger('efficacy_id')->nullable();
            $table->foreign('efficacy_id', 'efficacy_fk_5726626')->references('id')->on('att_efficacies');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5726627')->references('id')->on('att_statuses');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5726636')->references('id')->on('teams');
        });
    }
}
