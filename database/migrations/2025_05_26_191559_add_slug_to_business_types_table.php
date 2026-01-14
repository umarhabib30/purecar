<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToBusinessTypesTable extends Migration
{
    public function up()
    {
        Schema::table('business_types', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name');
        });
    }

    public function down()
    {
        Schema::table('business_types', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}