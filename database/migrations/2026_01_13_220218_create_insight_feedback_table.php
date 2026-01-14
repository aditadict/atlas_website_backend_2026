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
        Schema::create('insight_feedback', function (Blueprint $table) {
            $table->id();
            $table->uuid('insight_id');
            $table->string('ip_address')->nullable();
            $table->boolean('is_helpful'); // true for helpful, false for not helpful
            $table->timestamps();

            $table->foreign('insight_id')->references('id')->on('insights')->onDelete('cascade');
            $table->index(['insight_id', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insight_feedback');
    }
};
