<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer');
            $table->integer('user');
            $table->integer('del')->default(0);
            $table->integer('del_user')->nullable();
            $table->double('val');
            $table->double('forhim');
            $table->string('date', 50);
            $table->string('time', 50);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('exchange');
    }
}
