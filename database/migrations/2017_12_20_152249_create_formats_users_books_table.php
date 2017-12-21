<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatsUsersBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formats_users_books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_book_id')->unsigned();
            $table->foreign('user_book_id')->references('id')->on('user_books');
            $table->integer('format_id')->unsigned();
            $table->foreign('format_id')->references('id')->on('formats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formats_users_books');
    }
}
