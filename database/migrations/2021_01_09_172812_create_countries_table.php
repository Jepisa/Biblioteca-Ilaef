<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('iso3', 3)->nullable()->default(null);
            $table->string('iso2', 3)->nullable()->default(null);
            $table->string('phonecode')->nullable()->default(null);
            $table->string('capital')->nullable()->default(null);
            $table->string('currency')->nullable()->default(null);
            $table->string('native')->nullable()->default(null);
            $table->string('region')->nullable()->default(null);
            $table->string('subregion')->nullable()->default(null);
            $table->text('timezones')->nullable()->default(null);
            $table->decimal('latitude', 10, 8)->nullable()->default(null);
            $table->decimal('longitude', 10, 8)->nullable()->default(null);
            $table->string('emoji', 191)->nullable()->default(null);
            $table->string('emojiU', 191)->nullable()->default(null);

            $table->timestamps();

            $table->tinyInteger('flag')->default(1);
            $table->string('wikiDataId')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
