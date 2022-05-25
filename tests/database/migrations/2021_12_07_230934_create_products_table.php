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
            $table->integer('id')->primary();
            $table->string('code');
            $table->string('name');
            $table->integer('category_id');
            $table->integer('unit_id');
            $table->double('quan');
            $table->double('pieces');
            $table->double('total_pieces');
            $table->double('saleprice_p');
            $table->double('price_p');
            $table->double('pricelist_p');
            $table->double('min_quantity');
            $table->string('status', 1)->default('1');
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
