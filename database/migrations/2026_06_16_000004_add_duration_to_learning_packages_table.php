<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('learning_packages', function (Blueprint $table): void {
            $table->unsignedInteger('duration_minutes')->default(0)->after('question_count');
        });
    }

    public function down(): void
    {
        Schema::table('learning_packages', function (Blueprint $table): void {
            $table->dropColumn('duration_minutes');
        });
    }
};
