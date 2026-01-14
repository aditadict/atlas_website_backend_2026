<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('insights', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->json('title');
            $table->json('excerpt');
            $table->json('content');
            $table->json('category');
            $table->string('read_time')->default('5 min');
            $table->boolean('published')->default(false);
            $table->string('featured_image')->nullable();
            $table->timestamps();

            $table->index('slug');
            $table->index('published');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insights');
    }
};
