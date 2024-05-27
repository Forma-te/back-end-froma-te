<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /**
        User::factory()->create([
           'name' => 'Test User',
           'email' => 'test@example.com',
        ]);
        */

        User::create([
            'name' => 'Moises Bumba',
            'email' => 'moises-alberto@hotmail.com',
            'password' => Hash::make('123456'),

        ]);


    }
}
