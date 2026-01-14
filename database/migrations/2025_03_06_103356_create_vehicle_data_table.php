<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('vehicle_data', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate');
            $table->json('data'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_data');
    }
};

