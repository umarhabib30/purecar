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
        Schema::create('counters', function (Blueprint $table) {
            $table->id();
            $table->integer('advert_id')->nullable();
            $table->enum('counter_type', ['call', 'text', 'email', 'page_view'])->nullable();
            
            // Add created_at column
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            // Add updated_at column
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable()->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counters');
    }
};
