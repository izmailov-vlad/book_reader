<?php

namespace App\Http\Controllers\ChatGPT;

use App\Http\Controllers\Controller;
use App\Models\ChatGPT\ChatGPTQuestions;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use OpenAI\Laravel\Facades\OpenAI;

class ApiController extends Controller
{

    public function index(Request $request)
    {
        $messages = [
            ['role' => 'system', 'content' => 'Reply on question about book'],
            ['role' => 'user', 'content' => $request->query('content')],
        ];
        $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages,
        ]);

        return Arr::get($result, 'choices.0.message');
    }

    public function questions(Request $request)
    {
        return response()->json(['questions' => ChatGPTQuestions::all()]);
    }
}
