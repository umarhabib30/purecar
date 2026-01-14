<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateStatusColumnInAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update invalid statuses to 'inactive'
        DB::table('adverts')
            ->whereNotIn('status', ['active', 'inactive'])
            ->update(['status' => 'inactive']);

        Schema::table('adverts', function (Blueprint $table) {
            // Alter the 'status' column to allow only 'active' and 'inactive'
            $table->enum('status', ['active', 'inactive'])->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adverts', function (Blueprint $table) {
            // Revert the 'status' column to its original state
            $table->enum('status', ['renew', 'expire', 'active'])->default('active')->change();
        });
    }
}
