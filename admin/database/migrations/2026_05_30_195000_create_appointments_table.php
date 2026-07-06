<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->foreignId('treatment_id')->nullable()->constrained()->nullOnDelete();
            $table->date('preferred_date')->nullable();
            $table->string('preferred_time')->nullable();    // e.g. "Morning", "5:30 PM"
            $table->text('message')->nullable();
            $table->string('status')->default('new');        // new | contacted | confirmed | completed | cancelled
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
