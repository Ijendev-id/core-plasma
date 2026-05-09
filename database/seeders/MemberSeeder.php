<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MemberSeeder extends Seeder
{
    /**
     * Seed student/member data.
     */
    public function run(): void
    {
        $members = [
            ['name' => 'Dinda Kartika', 'email' => 'dinda@example.test', 'pendidikan_terakhir' => 'S1'],
            ['name' => 'Fajar Ramadhan', 'email' => 'fajar@example.test', 'pendidikan_terakhir' => 'SMA/SMK'],
            ['name' => 'Rafi Mahendra', 'email' => 'rafi@example.test', 'pendidikan_terakhir' => 'D3'],
            ['name' => 'Salsa Nabila', 'email' => 'salsa@example.test', 'pendidikan_terakhir' => 'S1'],
            ['name' => 'Arif Pratama', 'email' => 'arif@example.test', 'pendidikan_terakhir' => 'D4'],
            ['name' => 'Dafa Apriel', 'email' => 'dafa@example.test', 'pendidikan_terakhir' => 'SMA/SMK'],
            ['name' => 'Sarah Smith', 'email' => 'sarah@example.test', 'pendidikan_terakhir' => 'S1'],
            ['name' => 'Kevin Hobbs', 'email' => 'kevin@example.test', 'pendidikan_terakhir' => 'S1'],
        ];

        foreach ($members as $member) {
            $model = Member::query()->firstOrNew(['email' => $member['email']]);

            $model->forceFill([
                'uuid' => $model->uuid ?? (string) Str::uuid(),
                'name' => $member['name'],
                'password' => 'password',
                'photo_profile' => null,
                'pendidikan_terakhir' => $member['pendidikan_terakhir'],
            ])->save();
        }
    }
}
