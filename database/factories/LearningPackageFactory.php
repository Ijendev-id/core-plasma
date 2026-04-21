<?php

namespace Database\Factories;

use App\Models\LearningPackage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<LearningPackage>
 */
class LearningPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $status = fake()->randomElement(['published', 'draft']);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'category' => fake()->randomElement(['KEDINASAN', 'UNIVERSITY', 'CAREER']),
            'question_count' => fake()->numberBetween(50, 220),
            'participants_count' => fake()->numberBetween(0, 4500),
            'price' => fake()->randomElement([149000, 199000, 250000, 299000]),
            'status' => $status,
            'icon' => fake()->randomElement(['graduation', 'rocket', 'briefcase', 'school']),
            'tone' => fake()->randomElement(['blue', 'amber', 'muted']),
            'show_participant_preview' => false,
            'published_at' => $status === 'published' ? now() : null,
        ];
    }
}
