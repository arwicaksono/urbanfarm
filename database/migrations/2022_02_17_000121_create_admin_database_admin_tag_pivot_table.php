<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminDatabaseAdminTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('admin_database_admin_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_database_id');
            $table->foreign('admin_database_id', 'admin_database_id_fk_5378747')->references('id')->on('admin_databases')->onDelete('cascade');
            $table->unsignedBigInteger('admin_tag_id');
            $table->foreign('admin_tag_id', 'admin_tag_id_fk_5378747')->references('id')->on('admin_tags')->onDelete('cascade');
        });
    }
}
