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
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('industry');
            $table->json('system_type');
            $table->json('title');
            $table->json('scope');
            $table->json('outcome');
            $table->boolean('featured')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('featured');
            $table->index('order');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
