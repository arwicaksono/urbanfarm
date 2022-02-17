<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPlotsTable extends Migration
{
    public function up()
    {
        Schema::table('plots', function (Blueprint $table) {
            $table->unsignedBigInteger('plot_prefix_id')->nullable();
            $table->foreign('plot_prefix_id', 'plot_prefix_fk_5644383')->references('id')->on('plot_codes');
            $table->unsignedBigInteger('activity_id')->nullable();
            $table->foreign('activity_id', 'activity_fk_5644261')->references('id')->on('plot_stages');
            $table->unsignedBigInteger('module_id')->nullable();
            $table->foreign('module_id', 'module_fk_5644262')->references('id')->on('modules');
            $table->unsignedBigInteger('nutrient_brand_id')->nullable();
            $table->foreign('nutrient_brand_id', 'nutrient_brand_fk_5644263')->references('id')->on('purchase_brands');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id', 'unit_fk_5644385')->references('id')->on('unit_quantities');
            $table->unsignedBigInteger('variety_id')->nullable();
            $table->foreign('variety_id', 'variety_fk_5644266')->references('id')->on('plot_varieties');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5644276')->references('id')->on('teams');
        });
    }
}
