<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }

    public function likeCount(int $commentId): int
    {
        return $this->likes()->where('$comment_id', '=', $commentId)->where('liked', true)->count();
    }

    public function userLike()
    {
        if (!auth()->check()) {
            return null;
        }

        return $this->likes()->where('user_id', auth()->id())->first();
    }

    public function updateLikesCount()
    {
        $this->likes_count = $this->likes()->where('liked', true)->count();
        $this->save();
    }


    protected $fillable = [
        "book_id",
        "user_id",
        'body',
    ];
}
