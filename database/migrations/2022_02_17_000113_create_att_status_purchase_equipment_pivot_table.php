<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttStatusPurchaseEquipmentPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_status_purchase_equipment', function (Blueprint $table) {
            $table->unsignedBigInteger('purchase_equipment_id');
            $table->foreign('purchase_equipment_id', 'purchase_equipment_id_fk_5306997')->references('id')->on('purchase_equipments')->onDelete('cascade');
            $table->unsignedBigInteger('att_status_id');
            $table->foreign('att_status_id', 'att_status_id_fk_5306997')->references('id')->on('att_statuses')->onDelete('cascade');
        });
    }
}
