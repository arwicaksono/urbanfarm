<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToModuleSystemsTable extends Migration
{
    public function up()
    {
        Schema::table('module_systems', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479762')->references('id')->on('teams');
        });
    }
}
