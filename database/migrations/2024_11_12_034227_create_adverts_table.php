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
        Schema::create('adverts', function (Blueprint $table) {
        $table->id('advert_id');
        $table->unsignedBigInteger('user_id'); // Foreign key column
        $table->string('image')->nullable(); // Store image path or URL
        $table->string('name');
        $table->string('license_plate')->unique();
        $table->integer('miles');
        $table->string('engine');
        $table->string('owner');
        $table->text('description')->nullable();
        $table->date('date_posted')->default(now());
        $table->date('expiry_date')->nullable(false);;
        $table->enum('status', ['renew', 'expire', 'active'])->default('active');
        $table->unsignedInteger('view_count')->default(0);
        $table->unsignedInteger('message_count')->default(0);
        $table->unsignedInteger('call_count')->default(0);
        $table->timestamps();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adverts');
    }
};
