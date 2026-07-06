<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_info', function (Blueprint $table) {
            // Background image for the home page "positive impact" CTA banner.
            $table->string('cta_image_path')->nullable()->after('menu_image_path');
        });
    }

    public function down(): void
    {
        Schema::table('company_info', function (Blueprint $table) {
            $table->dropColumn('cta_image_path');
        });
    }
};
