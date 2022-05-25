<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atendance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee');
            $table->string('presence', 50)->nullable();
            $table->string('leave', 50)->nullable();
            $table->double('hours')->nullable();
            $table->string('date', 50);
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
        Schema::dropIfExists('atendance');
    }
}
