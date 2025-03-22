<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $random = rand(1,15);
        return [
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'name' => fake()->sentence(2),
            'price' => fake()->numberBetween(10, 1000),
            'image' => "https://picsum.photos/150?random=". $random,
        ];
    }
}
