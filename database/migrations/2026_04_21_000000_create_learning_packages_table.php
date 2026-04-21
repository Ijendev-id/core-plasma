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
        Schema::create('learning_packages', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category', 60);
            $table->unsignedInteger('question_count')->default(0);
            $table->unsignedInteger('participants_count')->default(0);
            $table->unsignedBigInteger('price')->default(0);
            $table->string('status', 24)->default('draft')->index();
            $table->string('icon', 32)->default('graduation');
            $table->string('tone', 24)->default('blue');
            $table->boolean('show_participant_preview')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['category', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_packages');
    }
};
