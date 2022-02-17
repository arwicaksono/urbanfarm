<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPurchaseEquipmentsTable extends Migration
{
    public function up()
    {
        Schema::table('purchase_equipments', function (Blueprint $table) {
            $table->unsignedBigInteger('source_id')->nullable();
            $table->foreign('source_id', 'source_fk_5306994')->references('id')->on('purchase_companies');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'category_fk_5306995')->references('id')->on('att_categories');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5487623')->references('id')->on('teams');
        });
    }
}
