<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotDataTable extends Migration
{
    public function up()
    {
        Schema::create('mot_data', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate')->nullable();
            $table->json('mot_history')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mot_data');
    }
}
