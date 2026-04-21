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
        Schema::create('tryout_answers', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tryout_question_id')->constrained()->cascadeOnDelete();
            $table->string('label', 4);
            $table->text('answer_text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();

            $table->unique(['tryout_question_id', 'label']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tryout_answers');
    }
};
