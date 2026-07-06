<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_info', function (Blueprint $table) {
            $table->string('tawkto_src')->nullable()->after('map_embed');
            $table->string('whatsapp_message')->nullable()->after('whatsapp');
        });
    }

    public function down(): void
    {
        Schema::table('company_info', function (Blueprint $table) {
            $table->dropColumn(['tawkto_src', 'whatsapp_message']);
        });
    }
};
