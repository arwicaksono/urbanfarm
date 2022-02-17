<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCashflowSalesTable extends Migration
{
    public function up()
    {
        Schema::table('cashflow_sales', function (Blueprint $table) {
            $table->unsignedBigInteger('packing_code_id')->nullable();
            $table->foreign('packing_code_id', 'packing_code_fk_5637506')->references('id')->on('packings');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id', 'unit_fk_5637508')->references('id')->on('unit_weights');
            $table->unsignedBigInteger('is_priority_id')->nullable();
            $table->foreign('is_priority_id', 'is_priority_fk_5759752')->references('id')->on('att_priorities');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_5637522')->references('id')->on('teams');
        });
    }
}
