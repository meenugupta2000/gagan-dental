<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('treatment_categories', function (Blueprint $table) {
            // Top-nav grouping: 'dental' or 'skin'. Drives the two mega-menus.
            $table->string('group', 20)->default('dental')->after('slug');
        });

        // Pre-assign already-seeded categories: everything defaults to Dental,
        // except the aesthetics/skin category.
        DB::table('treatment_categories')
            ->where('slug', 'facial-aesthetics')
            ->update(['group' => 'skin']);
    }

    public function down(): void
    {
        Schema::table('treatment_categories', function (Blueprint $table) {
            $table->dropColumn('group');
        });
    }
};
