<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToBusinessLocationsTable extends Migration
{
    public function up()
    {
        Schema::table('business_locations', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('business_locations', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}