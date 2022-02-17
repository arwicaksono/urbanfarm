<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagPlotPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_plot', function (Blueprint $table) {
            $table->unsignedBigInteger('plot_id');
            $table->foreign('plot_id', 'plot_id_fk_5644269')->references('id')->on('plots')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5644269')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
