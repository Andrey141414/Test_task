<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_and_genre', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('id_book')->unsigned();
            $table->foreign('id_book')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('id_genre')->unsigned();
            $table->foreign('id_genre')->references('id')->on('genres')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_and_genre');
    }
};
