<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')
                ->constrained()
                ->cascadeOnDelete();
            // $table->integer('author_id')->unsigned();
            // $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->morphs('authorable');
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
        Schema::dropIfExists('authorables');
    }
}
