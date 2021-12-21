<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKmongOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kmong_orders', function (Blueprint $table) {
            $table->id()->unsigned();

            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('goods_id');
            $table->unsignedTinyInteger('status')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'member_id'], algorithm: 'btree');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kmong_orders');
    }
}
