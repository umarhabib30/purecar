<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id('car_id');
            $table->bigInteger('advert_id')->unsigned()->nullable(false);;
            $table->string('model');
            $table->string('make');
            $table->string('fuel_type');
            $table->string('transmission_type');
            $table->string('body_type');
            $table->string('variant')->nullable();
            $table->string('keyword')->nullable();
            $table->decimal('price', 10, 2);
            $table->year('year');
            $table->string('seller_type');
            $table->string('image')->nullable();
            $table->integer('miles')->nullable();
            $table->integer('engine_size')->nullable();
            $table->integer('doors')->nullable();
            $table->integer('seats')->nullable();
            $table->string('colors')->nullable();
            $table->string('gear_box')->nullable();
            $table->string('license_plate')->nullable();
            $table->timestamps();

    // Foreign key constraint linking to adverts
    $table->foreign('advert_id')->references('advert_id')->on('adverts')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
