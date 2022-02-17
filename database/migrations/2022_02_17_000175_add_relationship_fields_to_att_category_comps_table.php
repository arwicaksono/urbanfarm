<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAttCategoryCompsTable extends Migration
{
    public function up()
    {
        Schema::table('att_category_comps', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479782')->references('id')->on('teams');
        });
    }
}
