<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('customer_id');
            $table->integer('from_id');
            $table->unsignedBigInteger('must_receive')->default(0);
            $table->unsignedBigInteger('receive')->default(0);
            $table->unsignedBigInteger('must_payment')->default(0);
            $table->unsignedBigInteger('payment')->default(0);
            $table->string('note')->nullable();
            $table->string('debt_type');
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
        Schema::dropIfExists('debts');
    }
}
