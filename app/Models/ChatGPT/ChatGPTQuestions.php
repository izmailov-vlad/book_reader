<?php

namespace App\Models\ChatGPT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGPTQuestions extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'question'];

    protected $table = 'questions';
}
