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
        Schema::create('contacts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->string('email');
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->string('service')->nullable();
            $table->text('message');
            $table->enum('language', ['en', 'id'])->default('en');
            $table->enum('status', ['new', 'read', 'responded', 'archived'])->default('new');
            $table->timestamps();

            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
