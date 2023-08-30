<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()
            ->count(10)
            ->has(
                \App\Models\Store::factory()
                    ->count(2)
                    ->has(
                        \App\Models\Product::factory()
                            ->count(10)
                    )
            )
            ->create();
    }
}
