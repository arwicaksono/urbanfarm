<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPlotVarietiesTable extends Migration
{
    public function up()
    {
        Schema::table('plot_varieties', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id', 'brand_fk_5644356')->references('id')->on('purchase_brands');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5644361')->references('id')->on('teams');
        });
    }
}
