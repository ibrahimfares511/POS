<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('order_id');
            $table->integer('item');
            $table->string('item_name');
            $table->integer('no_item')->default(0);
            $table->string('unit', 50)->default('0');
            $table->double('quan')->default(0);
            $table->double('price')->default(0);
            $table->double('discount')->nullable()->default(0);
            $table->double('total')->default(0);
            $table->double('profits')->default(0);
            $table->integer('user');
            $table->string('date', 50);
            $table->string('time', 50);
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
        Schema::dropIfExists('order_details');
    }
}
