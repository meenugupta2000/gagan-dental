<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_info', function (Blueprint $table) {
            $table->string('mail_host')->nullable()->after('tawkto_src');
            $table->string('mail_port')->nullable()->after('mail_host');
            $table->string('mail_username')->nullable()->after('mail_port');
            $table->string('mail_password')->nullable()->after('mail_username');
            $table->string('mail_encryption')->nullable()->after('mail_password'); // tls / ssl / null
            $table->string('mail_from_address')->nullable()->after('mail_encryption');
            $table->string('mail_from_name')->nullable()->after('mail_from_address');
        });
    }

    public function down(): void
    {
        Schema::table('company_info', function (Blueprint $table) {
            $table->dropColumn(['mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name']);
        });
    }
};
