<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (env('APP_ENV') != 'production') {
            User::factory()->create([
                'name' => 'kyledoesdev',
                'email' => 'kyledoesdev@gmail.com',
                'password' => bcrypt('password'),
            ]);
        }
    }
}
