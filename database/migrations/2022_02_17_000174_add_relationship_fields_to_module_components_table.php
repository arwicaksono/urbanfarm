<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToModuleComponentsTable extends Migration
{
    public function up()
    {
        Schema::table('module_components', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id', 'brand_fk_5300928')->references('id')->on('purchase_brands');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_5300929')->references('id')->on('purchase_companies');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'category_fk_5300930')->references('id')->on('att_category_comps');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5479761')->references('id')->on('teams');
        });
    }
}
