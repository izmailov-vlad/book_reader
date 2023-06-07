<?php

namespace App\Interfaces;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface BookRepositoryInterface
{
    public function getBookById(string $bookId): array;

    public function getBooksByQuery(string $query, int $startIndex, int $maxResult): array;

    public function getBooksByCategoryId(int $categoryId, int $startIndex, int $maxResult): array;

    public function getBooksMainContent(): array;

    public function getCategories(): Collection;

    public function getNewPublishedBooksByUserWishes(): array;

    public function changeBookFavorite(string $bookId): bool;

    public function addComment($data, string $bookId): bool;

    public function getComments(string $bookId): Collection;

    public function changeCommentLikeStatus(int $commentId): bool;

    public function rateBook(string $bookId, int $userId, int $rate) : int;

    public function getUserFavoriteBooks(int $userId);
}
