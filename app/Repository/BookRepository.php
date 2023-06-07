<?php

namespace App\Repository;

use App\Http\ExternalApi\GoogleBooksApi;
use App\Interfaces\BookRepositoryInterface;
use App\Models\BookRating;
use App\Models\Category;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Favorite;
use App\Models\User;
use Auth;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Collection;

class BookRepository implements BookRepositoryInterface
{
    public GoogleBooksApi $googleBooksApi;
    public BookAdapter $bookAdapter;

    /**
     * @param GoogleBooksApi $googleBooksApi
     */
    public function __construct(GoogleBooksApi $googleBooksApi, BookAdapter $bookAdapter)
    {
        $this->googleBooksApi = $googleBooksApi;
        $this->bookAdapter = $bookAdapter;
    }

    /**
     * @throws GuzzleException
     */
    public function getBookById(string $bookId): array
    {
        $book = $this->googleBooksApi->getBookById($bookId);
        return $this->bookAdapter->mapToClientBook($book, Auth::user(), $bookId);
    }

    /**
     * @throws GuzzleException
     */
    public function getBooksByQuery(string $query, int $startIndex, int $maxResult): array
    {
        $books = $this->googleBooksApi->getBookByQuery($query, $startIndex, $maxResult);
        return ['items' => array_map(function ($book) {
            return $this->bookAdapter->mapToClientBook($book, Auth::user(), $book['id']);
        }, $books['items']),
        ];
    }

    /**
     * @throws GuzzleException
     */
    public function getBooksByCategoryId(int $categoryId, int $startIndex, int $maxResult): array
    {
        $category = Category::find($categoryId);
        $books = $this->googleBooksApi->getBooksByCategoryName($category->getAttributeValue('name'), $startIndex, $maxResult);
        return ['items' => array_map(function ($book) {
            return $this->bookAdapter->mapToClientBook($book, Auth::user(), $book['id']);
        }, $books['items']),
        ];
    }

    /**
     * @throws GuzzleException
     */
    public function getBooksMainContent(): array
    {
        $categories = Category::all();
        $result = array();
        for ($i = 0; $i < count($categories); ++$i) {
            $booksByCategory = $this->googleBooksApi->getBooksByCategoryName($categories[$i]->name, 0, 10);
            $result[] = [
                'category' => [
                    'id' => $categories[$i]->id,
                    'name' => $categories[$i]->name,
                ],
                'books' => $booksByCategory,
            ];
        }
        return $result;
    }

    public function getCategories(): Collection
    {
        return Category::all();
    }

    /**
     * @throws GuzzleException
     */
    public function getNewPublishedBooksByUserWishes(): array
    {
        $wishes = Auth::user()->wishes()->get();
        $categories = [];
        foreach ($wishes as $wish) {
            $categories[] = Category::where('id', '=', $wish->id)->get();
        }
        $categoriesQuery = '';
        for ($i = 0; $i < count($categories); $i++) {
            $categoriesQuery .= $categories[$i]->value('name') . ', ';
        }

        if (str_ends_with($categoriesQuery, "+")) {
            $categoriesQuery = substr($categoriesQuery, 0, -1);
        }

        return $this->googleBooksApi->getBookByQuery("Книги жанра $categoriesQuery&orderBy=newest", 0, 10);
    }

    public function changeBookFavorite(string $bookId): bool
    {
        $user = Auth::user();
        $favoriteBookExist = Favorite::exists($bookId, $user->id);
        if ($favoriteBookExist) {
            Favorite::take($bookId, $user->id)->delete();
        } else {
            $favorite = new Favorite([
                    'book_id' => $bookId,
                    'user_id' => $user->id,
                ]
            );
            $favorite->save();
        }

        return !$favoriteBookExist;
    }

    public function addComment($data, string $bookId): bool
    {
        $comment = new Comment();
        $user = Auth::user();
        $comment->user_id = $user->id;
        $comment->book_id = $bookId;
        $comment->body = $data['comment'];
        $comment->save();
        return true;
    }

    public function getComments(string $bookId): Collection
    {

        return Comment::with('user')
            ->where('book_id', '=', $bookId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($comment) {
                $comment['liked'] = (bool)$comment->likes->where('user_id', Auth::user()->id)->value('liked');
                unset($comment['likes']);
                return $comment;
            });
    }

    /**
     * @throws GuzzleException
     */
    public function changeCommentLikeStatus(int $commentId): bool
    {
        $isLiked = (new CommentLike)->isLikedByUser($commentId, Auth::user()->id) ?? false;
        $comment = Comment::find($commentId);
        $isLiked && $comment['likes_count'] > 0 ? $comment->decrement('likes_count') : $comment->increment('likes_count');
        $comment->likes()->updateOrCreate([
            'user_id' => Auth::user()->id,
            'comment_id' => $comment->id,
        ], [
            'liked' => !$isLiked,
        ]);
        $comment->save();
        return true;
    }

    public function rateBook(string $bookId, int $userId, int $rate): int
    {
        $rating = BookRating::where(['book_id' => $bookId, 'user_id' => $userId])->first();

        if ($rating) {
            $rating->rating = $rate;
        } else {
            $rating = new BookRating([
                'book_id' => $bookId,
                'user_id' => $userId,
                'rating' => $rate
            ]);
        }
        $rating->save();

        return $rating->rating;
    }

    public function getUserFavoriteBooks(int $userId)
    {
        $favoriteBooks = Favorite::where('user_id', $userId)->get();
        $bookIds = $favoriteBooks->pluck('book_id')->toArray();
        $books = $this->googleBooksApi->getBooksByIds($bookIds);
        return array_map(function ($book) {
            return $this->bookAdapter->mapToClientBook($book, Auth::user(), $book['id']);
        }, $books);
    }
}
