<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            // Background image used at the top of inner pages
            // (Treatments, Doctors, Offers, Contact, Blog, CMS pages, …).
            $table->string('inner_banner_path')->nullable()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->dropColumn('inner_banner_path');
        });
    }
};
