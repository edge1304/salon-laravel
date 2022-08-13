<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id');
            $table->string('product_seo_image')->nullable();
            $table->string('product_seo_title')->nullable();
            $table->string('product_name')->unique();
            $table->string('product_slug')->unique();
            $table->string('product_title_content')->nullable();
            $table->string('product_content')->nullable();
            $table->unsignedBigInteger('product_price')->default(0);
            $table->unsignedBigInteger('product_import_price')->default(0);
            $table->unsignedBigInteger('product_vat')->default(0);
            $table->unsignedBigInteger('product_tradiscount')->default(0);
            $table->unsignedBigInteger('product_price_fake')->default(0); //
            $table->unsignedBigInteger('product_part')->default(0); // part thưởng cho nhân viên
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
        Schema::dropIfExists('products');
    }
}
