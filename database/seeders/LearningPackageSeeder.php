<?php

namespace Database\Seeders;

use App\Models\LearningPackage;
use Illuminate\Database\Seeder;

class LearningPackageSeeder extends Seeder
{
    /**
     * Seed package inventory data.
     */
    public function run(): void
    {
        $featuredPackages = [
            [
                'name' => 'CPNS 2024 Ultimate Prep',
                'slug' => 'cpns-2024-ultimate-prep',
                'category' => 'KEDINASAN',
                'question_count' => 110,
                'participants_count' => 1200,
                'price' => 149000,
                'status' => 'published',
                'icon' => 'graduation',
                'tone' => 'blue',
                'show_participant_preview' => true,
                'published_at' => now()->subDays(18),
            ],
            [
                'name' => 'UTK Master 2025',
                'slug' => 'utk-master-2025',
                'category' => 'UNIVERSITY',
                'question_count' => 155,
                'participants_count' => 2450,
                'price' => 199000,
                'status' => 'published',
                'icon' => 'rocket',
                'tone' => 'amber',
                'show_participant_preview' => false,
                'published_at' => now()->subDays(12),
            ],
            [
                'name' => 'BUMN Elite Selection',
                'slug' => 'bumn-elite-selection',
                'category' => 'CAREER',
                'question_count' => 85,
                'participants_count' => 0,
                'price' => 250000,
                'status' => 'draft',
                'icon' => 'briefcase',
                'tone' => 'muted',
                'show_participant_preview' => false,
                'published_at' => null,
            ],
            [
                'name' => 'STAN Intensive Bootcamp',
                'slug' => 'stan-intensive-bootcamp',
                'category' => 'KEDINASAN',
                'question_count' => 200,
                'participants_count' => 4120,
                'price' => 299000,
                'status' => 'published',
                'icon' => 'school',
                'tone' => 'blue',
                'show_participant_preview' => false,
                'published_at' => now()->subDays(6),
            ],
        ];

        foreach ($featuredPackages as $package) {
            LearningPackage::query()->updateOrCreate(
                ['slug' => $package['slug']],
                $package,
            );
        }

        $categories = ['KEDINASAN', 'UNIVERSITY', 'CAREER'];
        $icons = ['graduation', 'rocket', 'briefcase', 'school'];
        $tones = ['blue', 'amber', 'muted'];

        for ($number = 5; $number <= 124; $number++) {
            $status = $number <= 117 ? 'published' : 'draft';
            $category = $categories[$number % count($categories)];

            LearningPackage::query()->updateOrCreate(
                ['slug' => "tryout-bank-{$number}"],
                [
                    'name' => "Tryout Bank {$number}",
                    'category' => $category,
                    'question_count' => 70 + ($number % 9 * 15),
                    'participants_count' => $status === 'published' ? 40 + ($number * 3) : 0,
                    'price' => [99000, 149000, 199000, 249000][$number % 4],
                    'status' => $status,
                    'icon' => $icons[$number % count($icons)],
                    'tone' => $tones[$number % count($tones)],
                    'show_participant_preview' => false,
                    'published_at' => $status === 'published' ? now()->subDays($number % 30) : null,
                ],
            );
        }
    }
}
