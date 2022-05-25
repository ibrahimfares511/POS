<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('customer')->nullable();
            $table->integer('user');
            $table->string('date', 50)->default('0');
            $table->string('time', 50)->default('0');
            $table->double('balanc')->default(0);
            $table->double('subtotal')->default(0);
            $table->double('discount')->default(0);
            $table->string('dis_type', 15)->nullable();
            $table->double('val_discount')->default(0);
            $table->double('total')->default(0);
            $table->string('op', 50);
            $table->string('op_ar', 50)->nullable();
            $table->double('profits')->default(0);
            $table->integer('del')->default(0);
            $table->integer('user_del')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
