<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
             'company_id' => 2022,
         ]);
    }
}
