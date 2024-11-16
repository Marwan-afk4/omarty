<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\City;
use App\Models\Country;
use App\Models\Location;
use App\Models\User;
use App\Models\Zone;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Building::factory(5)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
