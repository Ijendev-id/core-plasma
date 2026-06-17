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
        Schema::table('learning_packages', function (Blueprint $table): void {
            // B-tree indexes to speed up ORDER BY on the inventory table.
            $table->index('name');
            $table->index('participants_count');
            $table->index('price');
            $table->index('question_count');

            // FULLTEXT index to power MATCH ... AGAINST search on name + category.
            $table->fullText(['name', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning_packages', function (Blueprint $table): void {
            $table->dropFullText(['name', 'category']);
            $table->dropIndex(['name']);
            $table->dropIndex(['participants_count']);
            $table->dropIndex(['price']);
            $table->dropIndex(['question_count']);
        });
    }
};
