<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_info', function (Blueprint $table) {
            // Per-division contact numbers & emails.
            $table->string('tickets_phone')->nullable()->after('phone');
            $table->string('tickets_email')->nullable()->after('tickets_phone');
            $table->string('packages_phone')->nullable()->after('tickets_email');
            $table->string('packages_email')->nullable()->after('packages_phone');
            $table->string('visa_phone')->nullable()->after('packages_email');
            $table->string('visa_email')->nullable()->after('visa_phone');
        });

        Schema::table('company_info', function (Blueprint $table) {
            foreach (['alt_phone', 'support_email'] as $col) {
                if (Schema::hasColumn('company_info', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('company_info', function (Blueprint $table) {
            $table->dropColumn(['tickets_phone', 'tickets_email', 'packages_phone', 'packages_email', 'visa_phone', 'visa_email']);
            $table->string('alt_phone')->nullable();
            $table->string('support_email')->nullable();
        });
    }
};
