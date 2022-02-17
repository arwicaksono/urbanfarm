<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToModuleActivitiesTable extends Migration
{
    public function up()
    {
        Schema::table('module_activities', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479760')->references('id')->on('teams');
        });
    }
}
