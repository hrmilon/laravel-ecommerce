<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory(5)
            ->has(Products::factory()->count(20))
            ->create();

        User::factory(10)->create();
        Admin::factory(2)->create();
    }
}
