<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('duration')->nullable();          // e.g. "30–45 mins" or "2 visits"
            $table->foreignId('treatment_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('badge')->nullable();             // e.g. "Popular", "New"
            $table->decimal('actual_price', 12, 2)->nullable();
            $table->decimal('deal_price', 12, 2)->nullable();
            $table->longText('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('show_on_home')->default(false);
            $table->timestamps();
        });

        Schema::create('treatment_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treatment_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatment_images');
        Schema::dropIfExists('treatments');
    }
};
