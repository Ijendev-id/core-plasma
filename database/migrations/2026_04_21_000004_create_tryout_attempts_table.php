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
        Schema::create('tryout_attempts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('learning_package_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('score')->default(0)->index();
            $table->unsignedInteger('twk_score')->default(0);
            $table->unsignedInteger('tiu_score')->default(0);
            $table->unsignedInteger('tkp_score')->default(0);
            $table->unsignedInteger('answered_count')->default(0);
            $table->unsignedInteger('correct_count')->default(0);
            $table->unsignedInteger('duration_seconds')->default(0);
            $table->string('status', 24)->default('in_progress')->index();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->index(['learning_package_id', 'score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tryout_attempts');
    }
};
