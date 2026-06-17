<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tryout_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 60)->unique();
            $table->timestamps();
        });

        // Seed from existing categories used by learning packages, plus defaults.
        $names = DB::table('learning_packages')
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->merge(['KEDINASAN', 'UNIVERSITY', 'CAREER'])
            ->map(fn ($name): string => strtoupper(trim((string) $name)))
            ->filter()
            ->unique();

        foreach ($names as $name) {
            DB::table('tryout_categories')->insert([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tryout_categories');
    }
};
