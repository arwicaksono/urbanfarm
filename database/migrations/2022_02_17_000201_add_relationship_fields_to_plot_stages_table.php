<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPlotStagesTable extends Migration
{
    public function up()
    {
        Schema::table('plot_stages', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5644353')->references('id')->on('teams');
        });
    }
}
