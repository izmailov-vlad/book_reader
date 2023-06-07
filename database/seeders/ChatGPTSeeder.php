<?php

namespace Database\Seeders;

use App\Models\ChatGPT\ChatGPTQuestions;
use Database\Factories\ChatGPT\ChatGPTQuestionsFactory;
use Illuminate\Database\Seeder;

class ChatGPTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chatGPTQuestions = [
            'Какую тему или идею исследует эта книга?',
            'Каковы основные персонажи и их характеристики?',
            'Какой жанр лучше всего описывает эту книгу?',
            'Каковы наиболее заметные моменты в развитии сюжета книги?',
            'Какие ключевые сообщения или уроки можно извлечь из этой книги?',
            'Какая атмосфера или настроение создается в этой книге?',
            'Какие особенности стиля писателя можно заметить в этой книге?',
            'Каковы темы или идеи, которые читатель может осознать только после того, как закончит эту книгу?',
            'Какие были основные вызовы, с которыми столкнулись главные персонажи в этой книге?',
            'Какие изображения или символы наиболее важны для понимания этой книги,',
        ];

        for ($i = 0; $i < 10; ++$i) {
            ChatGPTQuestions::factory()->state(['question' => $chatGPTQuestions[$i]])->create();
        }
    }
}
