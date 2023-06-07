<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Ужасы',
            'Фантастика',
            'Фэнтези',
            'Философия',
            'Психология',
            'Детектив',
            'Боевик',
            'Классическая литература',
            'Комедия',
            'Бизнес и инвестиции',
        ];

        $queryCategories = [
            'Horror',
            'Fantastic',
            'Fantasy',
            'Philosophy',
            'Psychology',
            'Detective',
            'Action',
            'Classic',
            'Comedy',
            'Business and investment',
        ];

        for ($i = 0; $i < 10; ++$i) {
            Category::factory()->state([
                'name' => $categories[$i],
                'query_name' => $queryCategories[$i],
            ])->create();
        }
    }
}
