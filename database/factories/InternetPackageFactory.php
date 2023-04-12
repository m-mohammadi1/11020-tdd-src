<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InternetPackage>
 */
class InternetPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => $this->faker->randomDigit(),
            'title' => $this->faker->randomDigit(),
            'price' => $this->faker->numberBetween(10_000, 100_000_000),
            'duration' => [15, 30, 60, 120, 360][rand(0, 4)],
            'traffic' => [100, 150, 2048, 15096, 43360][rand(0, 4)],
        ];
    }
}
