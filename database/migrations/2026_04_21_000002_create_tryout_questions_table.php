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
        Schema::create('tryout_questions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('learning_package_id')->constrained()->cascadeOnDelete();
            $table->string('section', 24)->default('TWK')->index();
            $table->text('prompt');
            $table->string('attachment_path')->nullable();
            $table->unsignedInteger('order_number')->default(1);
            $table->unsignedSmallInteger('points')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['learning_package_id', 'order_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tryout_questions');
    }
};
