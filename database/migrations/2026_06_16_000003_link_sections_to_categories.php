<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tryout_sections', function (Blueprint $table): void {
            $table->dropUnique('tryout_sections_code_unique');
            $table->foreignId('tryout_category_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            $table->unique(['tryout_category_id', 'code']);
        });

        // Attach the default seeded sections (TWK/TIU/TKP) to the KEDINASAN category if present.
        $categoryId = DB::table('tryout_categories')->where('name', 'KEDINASAN')->value('id')
            ?? DB::table('tryout_categories')->orderBy('id')->value('id');

        if ($categoryId) {
            DB::table('tryout_sections')->whereNull('tryout_category_id')->update([
                'tryout_category_id' => $categoryId,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('tryout_sections', function (Blueprint $table): void {
            $table->dropUnique(['tryout_category_id', 'code']);
            $table->dropConstrainedForeignId('tryout_category_id');
            $table->unique('code');
        });
    }
};
