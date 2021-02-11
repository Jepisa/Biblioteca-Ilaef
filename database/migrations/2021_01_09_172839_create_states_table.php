<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');
            
            $table->string('country_code', 2);
            $table->string('fips_code')->nullable()->default(null);
            $table->string('iso2')->nullable()->default(null);
            $table->decimal('latitude', 10,8)->nullable()->default(null);
            $table->decimal('longitude', 10,8)->nullable()->default(null);
            $table->tinyInteger('flag');
            $table->string('wikiDataId')->nullable()->default(null);
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
        Schema::dropIfExists('states');
    }
}
