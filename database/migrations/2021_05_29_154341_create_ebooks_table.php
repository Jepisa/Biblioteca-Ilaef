<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('synopsis')->nullable();
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
            $table->string('isbn')->nullable()->unique();
            $table->string('downloadable')->nullable();
            $table->text('url')->nullable();
            $table->string('coverImage');
            $table->string('backCoverImage')->nullable();

            $table->string('format')->nullable();
            $table->string('compatibility');
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
        Schema::dropIfExists('ebooks');
    }
}
