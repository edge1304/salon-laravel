<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_entries', function (Blueprint $table) {
            $table->id();
            $table->string('accounting_entry_type')->default('receive'); // kiểu mặc định là thu
            $table->string('accounting_entry_name');
            $table->boolean('is_cost')->default(true); // là chi phí hay ko, true là có ->true không tạo công nợ
            $table->boolean('is_default')->default(true); // mặc định hay ko . mặc định thì ko cho phép sửa , xóa
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
        Schema::dropIfExists('accounting_entries');
    }
}
