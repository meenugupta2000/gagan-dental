<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_sections', function (Blueprint $table) {
            // Doctor / clinic profile shown on the dedicated public About page.
            $table->string('doctor_name')->nullable()->after('description');
            $table->string('doctor_title')->nullable()->after('doctor_name');     // e.g. "The Smile Design Specialist"
            $table->string('doctor_photo_path')->nullable()->after('doctor_title');
            $table->unsignedSmallInteger('experience_years')->nullable()->after('doctor_photo_path');
            $table->string('clinic_since')->nullable()->after('experience_years'); // e.g. "2008"

            $table->text('intro')->nullable()->after('clinic_since');              // lead paragraph on the About page
            $table->longText('body')->nullable()->after('intro');                  // rich HTML — the main story/content
            $table->text('qualifications')->nullable()->after('body');             // one credential per line
            $table->text('philosophy')->nullable()->after('qualifications');       // highlighted mission / quote

            // Up to four headline stats (value + label), e.g. "18+" / "Years of Experience".
            $table->string('stat1_value')->nullable()->after('philosophy');
            $table->string('stat1_label')->nullable()->after('stat1_value');
            $table->string('stat2_value')->nullable()->after('stat1_label');
            $table->string('stat2_label')->nullable()->after('stat2_value');
            $table->string('stat3_value')->nullable()->after('stat2_label');
            $table->string('stat3_label')->nullable()->after('stat3_value');
            $table->string('stat4_value')->nullable()->after('stat3_label');
            $table->string('stat4_label')->nullable()->after('stat4_value');
        });
    }

    public function down(): void
    {
        Schema::table('about_sections', function (Blueprint $table) {
            $table->dropColumn([
                'doctor_name', 'doctor_title', 'doctor_photo_path', 'experience_years', 'clinic_since',
                'intro', 'body', 'qualifications', 'philosophy',
                'stat1_value', 'stat1_label', 'stat2_value', 'stat2_label',
                'stat3_value', 'stat3_label', 'stat4_value', 'stat4_label',
            ]);
        });
    }
};
