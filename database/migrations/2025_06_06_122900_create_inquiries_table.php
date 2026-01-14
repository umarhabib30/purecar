<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advert_id');
            $table->string('advert_name', 255);
            $table->string('seller_email');
            $table->string('full_name', 255);
            $table->string('email');
            $table->string('phone_number');
            $table->text('message');
            $table->timestamps();

         
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};