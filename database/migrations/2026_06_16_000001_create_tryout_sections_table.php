<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tryout_sections', function (Blueprint $table): void {
            $table->id();
            $table->string('code', 24)->unique();
            $table->string('name')->nullable();
            $table->timestamps();
        });

        foreach (['TWK', 'TIU', 'TKP'] as $code) {
            DB::table('tryout_sections')->insert([
                'code' => $code,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tryout_sections');
    }
};
