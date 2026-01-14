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
        Schema::create('advert_images', function (Blueprint $table) {
            $table->id('image_id');
            $table->unsignedBigInteger('advert_id'); // Foreign key to adverts table
            $table->string('image_url'); // URL or path to the image
            $table->timestamps();
            $table->foreign('advert_id')->references('advert_id')->on('adverts')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advert_images');
    }
};
