<?php

namespace Database\Factories;

use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Place>
 */
class PlaceFactory extends Factory
{
    protected $model = Place::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->slug(),
            'order' => $this->faker->numberBetween(1, 50),
            'name_en' => $this->faker->city(),
            'name_ar' => $this->faker->city(),
            'excerpt_en' => $this->faker->sentence(),
            'excerpt_ar' => $this->faker->sentence(),
            'body_en' => $this->faker->paragraph(),
            'body_ar' => $this->faker->paragraph(),
            'image_path' => 'images/places/baghdad.svg',
            'is_published' => true,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}