<?php

namespace App\Repository;

use App\Models\BookRating;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\User;
use Auth;

class BookAdapter
{
    public function mapToClientBook($book, User $user, string $bookId)
    {
        $book['isFavorite'] = Favorite::exists($book['id'], Auth::user()->id);
        $comments = Comment::with('user')
            ->where('book_id', '=', $bookId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($comment) {
                $comment['liked'] = (bool)$comment->likes->where('user_id', Auth::user()->id)->value('liked');
                unset($comment['likes']);
                return $comment;
            });
        $rating = BookRating::where(['book_id' => $bookId, 'user_id' => $user->id])->first();
        $bookRatings = BookRating::where('book_id', $bookId)->get();
        $averageRating = $bookRatings->avg('rating');
        $averageRating = is_null($averageRating) ? 0 : round($averageRating, 2);
        $book['rate'] = is_null($rating) ? 0 : $rating->rating;
        $book['volumeInfo']['averageRating'] = $averageRating;
        $book['comments'] = $comments;
        $book['likesCount'] = Favorite::where('book_id', $bookId)->count();
        return $book;
    }
}
