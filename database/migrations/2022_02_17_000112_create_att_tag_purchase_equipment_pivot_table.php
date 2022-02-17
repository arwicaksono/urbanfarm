<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttTagPurchaseEquipmentPivotTable extends Migration
{
    public function up()
    {
        Schema::create('att_tag_purchase_equipment', function (Blueprint $table) {
            $table->unsignedBigInteger('purchase_equipment_id');
            $table->foreign('purchase_equipment_id', 'purchase_equipment_id_fk_5306996')->references('id')->on('purchase_equipments')->onDelete('cascade');
            $table->unsignedBigInteger('att_tag_id');
            $table->foreign('att_tag_id', 'att_tag_id_fk_5306996')->references('id')->on('att_tags')->onDelete('cascade');
        });
    }
}
