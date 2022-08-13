<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_details', function (Blueprint $table) {
            $table->id();
            $table->integer('form_export_id');
            $table->integer('product_id');
            $table->integer('user_id')->nullable(); // đây là id nhân viên , ko phải customer
            $table->integer('user_id2')->nullable(); // đây là id nhân viên , ko phải customer
            $table->integer('quantity')->default(1);
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('vat')->default(0);
            $table->unsignedBigInteger('ck')->default(0);
            $table->unsignedBigInteger('discount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('export_details');
    }
}
