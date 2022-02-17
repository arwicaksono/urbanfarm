<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBusinessSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('business_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479796')->references('id')->on('teams');
        });
    }
}
