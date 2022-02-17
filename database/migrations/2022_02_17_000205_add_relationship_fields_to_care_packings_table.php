<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCarePackingsTable extends Migration
{
    public function up()
    {
        Schema::table('care_packings', function (Blueprint $table) {
            $table->unsignedBigInteger('problem_packing_id')->nullable();
            $table->foreign('problem_packing_id', 'problem_packing_fk_5726567')->references('id')->on('packings');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_5726571')->references('id')->on('att_statuses');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5726580')->references('id')->on('teams');
        });
    }
}
