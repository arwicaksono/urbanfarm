<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSalesPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('sales_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_6009124')->references('id')->on('teams');
        });
    }
}
