<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_info', function (Blueprint $table) {
            // External payment portal/gateway link, shown as a "Payment" nav item.
            $table->string('payment_url')->nullable()->after('website');
        });
    }

    public function down(): void
    {
        Schema::table('company_info', function (Blueprint $table) {
            $table->dropColumn('payment_url');
        });
    }
};
