<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPackingsTable extends Migration
{
    public function up()
    {
        Schema::table('packings', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5300077')->references('id')->on('att_statuses');
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->foreign('priority_id', 'priority_fk_5716241')->references('id')->on('att_priorities');
            $table->unsignedBigInteger('person_in_charge_id')->nullable();
            $table->foreign('person_in_charge_id', 'person_in_charge_fk_5300079')->references('id')->on('users');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479603')->references('id')->on('teams');
        });
    }
}
