<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleKeeperDataTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_keeper_data', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate')->nullable();
            $table->json('vehicle_data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_keeper_data');
    }
}
