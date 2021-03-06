<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topicables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')
                ->constrained()
                ->cascadeOnDelete();
            // $table->integer('topic_id')->unsigned();
            // $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
            $table->morphs('topicable');
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
        Schema::dropIfExists('topicables');
    }
}
