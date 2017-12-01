<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('giving_id')->unsigned();
            $table->foreign('giving_id')->references('id')->on('users');
            $table->integer('taker_id')->unsigned();
            $table->foreign('taker_id')->references('id')->on('users');
            $table->date('date_start');
            $table->date('date_end');
            $table->boolean('is_return')->default(0); // 0 if not return
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
