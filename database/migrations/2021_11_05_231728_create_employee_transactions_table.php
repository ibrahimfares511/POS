<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee');
            $table->integer('op');
            $table->string('op_name', 50);
            $table->double('val');
            $table->text('note')-null();
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
        Schema::dropIfExists('employee_transactions');
    }
}
