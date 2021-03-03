<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('synopsis');
            $table->text('note')->nullable();
            $table->integer('year')->nullable();
            $table->string('collection')->nullable();
            $table->string('edition')->nullable();
            $table->string('editorial');
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages');
            $table->string('city')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->integer('pages')->nullable();
            $table->string('isbn');
            $table->string('downloadable')->nullable();
            $table->string('url')->nullable();
            $table->string('coverImage');
            $table->string('backCoverImage')->nullable();
            $table->string('audiobook')->nullable();
            $table->string('format');
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
        Schema::dropIfExists('books');
    }
}
