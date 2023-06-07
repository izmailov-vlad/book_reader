<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    public static function exists($bookId, $userId)
    {
        return static::where(['book_id'=> $bookId, 'user_id' => $userId])->exists();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function take($bookId, $userId) {
        return static::where(['book_id' => $bookId, 'user_id' => $userId])->first();
    }

    protected $fillable = [
        'book_id',
        'user_id',
    ];
}
