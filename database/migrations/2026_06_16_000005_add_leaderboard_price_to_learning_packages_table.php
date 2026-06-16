<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('learning_packages', function (Blueprint $table): void {
            $table->unsignedBigInteger('leaderboard_price')->default(0)->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('learning_packages', function (Blueprint $table): void {
            $table->dropColumn('leaderboard_price');
        });
    }
};
