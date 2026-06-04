<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $defaultCategories = [
            ['name' => 'Food', 'icon' => '🍔', 'color' => '#FF6B6B'],
            ['name' => 'Travel', 'icon' => '✈️', 'color' => '#4ECDC4'],
            ['name' => 'Fuel', 'icon' => '⛽', 'color' => '#FFE66D'],
            ['name' => 'Shopping', 'icon' => '🛍️', 'color' => '#95E1D3'],
            ['name' => 'Bills', 'icon' => '📄', 'color' => '#F38181'],
            ['name' => 'Entertainment', 'icon' => '🎬', 'color' => '#AA96DA'],
            ['name' => 'Health', 'icon' => '🏥', 'color' => '#FCBAD3'],
            ['name' => 'Other', 'icon' => '📦', 'color' => '#6C757D'],
        ];

        // Get all users to create default categories for each
        $users = \App\Models\User::all();

        foreach ($users as $user) {
            foreach ($defaultCategories as $category) {
                Category::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'name' => $category['name'],
                    ],
                    [
                        'icon' => $category['icon'],
                        'color' => $category['color'],
                        'is_default' => true,
                    ]
                );
            }
        }
    }
}

// Made with Bob
