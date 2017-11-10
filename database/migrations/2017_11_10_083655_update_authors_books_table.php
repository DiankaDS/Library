<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAuthorsBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('authors_books', function (Blueprint $table) {
            $table->dropForeign('authors_books_book_id_foreign');
            $table->foreign('book_id')->references('id')->on('lib_books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('authors_books', function (Blueprint $table) {
            //
        });
    }
}
