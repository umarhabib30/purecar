<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->double('ExtraUrban')->after('imported');
            $table->double('UrbanCold')->after('ExtraUrban');
            $table->double('Combined')->after('UrbanCold');
        });
    }

    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['ExtraUrban', 'UrbanCold', 'Combined']);
        });
    }
};
