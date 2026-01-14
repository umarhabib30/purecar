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
            $table->string('Bhp')->nullable();
            $table->string('Kph')->nullable();
            $table->string('Transmission')->nullable();
            $table->integer('EngineCapacity')->nullable();
            $table->integer('NumberOfCylinders')->nullable();
            
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
                'Bhp',
                'Kph',
                'Transmission',
                'EngineCapacity',
                'EngineCapacity',
                'NumberOfCylinders'
            ]);
        });
    }
};
