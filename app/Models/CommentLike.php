<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    protected $fillable = ['liked', 'user_id', 'comment_id'];

    public function isLikedByUser($commentId, $userId): ?bool
    {
        return CommentLike::where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->value('liked');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
