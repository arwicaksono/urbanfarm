<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPurchaseCompaniesTable extends Migration
{
    public function up()
    {
        Schema::table('purchase_companies', function (Blueprint $table) {
            $table->unsignedBigInteger('contact_person_id')->nullable();
            $table->foreign('contact_person_id', 'contact_person_fk_5306965')->references('id')->on('purchase_contacts');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'category_fk_5306967')->references('id')->on('att_categories');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5487625')->references('id')->on('teams');
        });
    }
}
