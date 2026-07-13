<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            // Portrait home-hero image used only on phones, so a wide landscape
            // photo isn't cropped (face cut off) on tall narrow screens.
            $table->string('mobile_image_path')->nullable()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->dropColumn('mobile_image_path');
        });
    }
};
