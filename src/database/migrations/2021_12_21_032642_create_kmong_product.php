<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKmongProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kmong_products', function (Blueprint $table) {
            $table->id()->unsigned();

            $table->string('goodsname')->fulltext();
            $table->bigInteger('price')->default(0);
            $table->unsignedTinyInteger('display')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(columns: ['display', 'price'], algorithm: 'btree');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kmong_products');
    }
}
