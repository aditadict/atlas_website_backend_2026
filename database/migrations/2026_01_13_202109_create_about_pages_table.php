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
        Schema::create('about_pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('years_experience')->default(0);
            $table->integer('systems_delivered')->default(0);
            $table->integer('industries_served')->default(0);
            $table->json('headline')->nullable(); // {en: "", id: ""}
            $table->json('subheadline')->nullable(); // {en: "", id: ""}
            $table->json('mission')->nullable(); // {en: "", id: ""}
            $table->json('vision')->nullable(); // {en: "", id: ""}
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
