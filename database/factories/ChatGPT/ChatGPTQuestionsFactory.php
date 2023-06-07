<?php

namespace Database\Factories\ChatGPT;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChatGPT\ChatGPTQuestions>
 */
class ChatGPTQuestionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => 'Расскажи вкратце о книге',
        ];
    }
}
