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
        Schema::table('cars', function (Blueprint $table) {
            // Add the new columns
            $table->string('Rpm')->nullable();
            $table->string('RigidArtic')->nullable();
            $table->string('BodyShape')->nullable();
            $table->integer('NumberOfAxles')->nullable();
            $table->integer('FuelTankCapacity')->nullable();
            $table->integer('GrossVehicleWeight')->nullable();
            $table->string('FuelCatalyst')->nullable();
            $table->string('Aspiration')->nullable();
            $table->string('FuelSystem')->nullable();
            $table->string('FuelDelivery')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // Drop the new columns
            $table->dropColumn([
                'Rpm',
                'RigidArtic',
                'BodyShape',
                'NumberOfAxles',
                'FuelTankCapacity',
                'GrossVehicleWeight',
                'FuelCatalyst',
                'Aspiration',
                'FuelSystem',
                'FuelDelivery'
            ]);
        });
    }
};
