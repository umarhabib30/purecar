<?php

// Migration: create_mot_histories_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mot_histories', function (Blueprint $table) {
            $table->id();
            $table->string('vrm');
            $table->date('test_date');
            $table->string('test_number');
            $table->string('test_result');
            $table->string('odometer_reading')->nullable();
            $table->string('odometer_unit')->nullable();
            $table->date('expiry_date')->nullable();
            $table->text('advisory_notices')->nullable();
            $table->timestamps();
            
            $table->index('vrm');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mot_histories');
    }
};