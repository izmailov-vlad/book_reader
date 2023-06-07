<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ChatGPT\ChatGPTQuestions;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();

         User::factory()->create([
             'name' => 'TestUser',
             'email' => 'test@example.com',
         ]);
         $this->call(CategorySeeder::class);
        $this->call(ChatGPTSeeder::class);
    }
}
