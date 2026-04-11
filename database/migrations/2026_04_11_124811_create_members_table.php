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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('photo_profile')->nullable();
            $table->enum('pendidikan_terakhir', [
                'SD',
                'SMP',
                'SMA/SMK',
                'D1',
                'D2',
                'D3',
                'D4',
                'S1',
                'S2',
                'S3',
            ])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
