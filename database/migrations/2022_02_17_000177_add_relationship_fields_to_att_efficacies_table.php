<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAttEfficaciesTable extends Migration
{
    public function up()
    {
        Schema::table('att_efficacies', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479783')->references('id')->on('teams');
        });
    }
}
