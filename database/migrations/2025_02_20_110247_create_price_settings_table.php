<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('price_settings', function (Blueprint $table) {
        $table->id();
        $table->decimal('min_price', 10, 2);
        $table->decimal('max_price', 10, 2);
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('price_settings');
    }
};
