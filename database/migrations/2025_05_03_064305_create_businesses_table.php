<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('business_type_id')->constrained('business_types')->onDelete('cascade');
            $table->foreignId('business_location_id')->constrained('business_locations')->onDelete('cascade');
            $table->string('contact_no');
            $table->string('email');
            $table->string('address');
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('businesses');
    }
};

