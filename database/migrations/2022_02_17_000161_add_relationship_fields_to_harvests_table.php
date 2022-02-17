<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToHarvestsTable extends Migration
{
    public function up()
    {
        Schema::table('harvests', function (Blueprint $table) {
            $table->unsignedBigInteger('plot_id')->nullable();
            $table->foreign('plot_id', 'plot_fk_5644278')->references('id')->on('plots');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id', 'unit_fk_5300059')->references('id')->on('unit_ages');
            $table->unsignedBigInteger('harvest_unit_id')->nullable();
            $table->foreign('harvest_unit_id', 'harvest_unit_fk_5300047')->references('id')->on('unit_quantities');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5300065')->references('id')->on('att_statuses');
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->foreign('priority_id', 'priority_fk_5716240')->references('id')->on('att_priorities');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479597')->references('id')->on('teams');
        });
    }
}
