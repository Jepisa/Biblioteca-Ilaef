<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePodcastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('announcer')->nullable();//Locutor/a
            $table->text('synopsis');
            $table->text('note')->nullable();
            $table->integer('year');
            $table->string('platform')->nullable();
            $table->string('oganization')->nullable();
            $table->string('editorial');
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages');
            $table->string('city')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->integer('duration')->nullable();
            $table->string('isbn')->nullable();
            $table->string('downloadable')->nullable();
            $table->string('url')->nullable();
            $table->string('coverImage')->nullable();
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
        Schema::dropIfExists('podcasts');
    }
}
