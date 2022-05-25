<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('customer');
            $table->double('val');
            $table->double('forhim');
            $table->string('date', 50);
            $table->integer('user');
            $table->string('time', 50);
            $table->text('note')->nullable();
            $table->integer('del')->default(0);
            $table->integer('del_user')->default(0);
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
        Schema::dropIfExists('supply');
    }
}
