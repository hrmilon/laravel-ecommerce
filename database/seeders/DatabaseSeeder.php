<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Products;
use App\Models\User;
use App\Models\Admin;
use App\Models\Customer;
use Pest\ArchPresets\Custom;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 5 categories
        $categories = Category::factory(5)->create();

        // Create 10 users
        User::factory(10)->create(  )->each(function ($user) use ($categories) {
            // Create 5 products for each user and assign a random category to each product
            Products::factory(5)->create([
                'user_id' => $user->id,
                'category_id' => $categories->random()->id,
            ]);
        });

        // Create 2 admins
        Admin::factory(2)->create();
        Customer::factory(20)->create();
    }
}
