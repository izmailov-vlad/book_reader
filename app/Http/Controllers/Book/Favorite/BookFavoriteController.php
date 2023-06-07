<?php

namespace App\Http\Controllers\Book\Favorite;

use App\Http\Controllers\Book\BaseBookController;
use App\Http\Requests\Book\Favorite\BookFavoriteRequest;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookFavoriteController extends BaseBookController
{
    public function changeFavorite(Request $request)
    {
        $bookId = $request->query('book_id');
        $isFavorite = $this->repository->changeBookFavorite($bookId);
        return ['success' => $isFavorite];
    }

    public function userFavorite(BookFavoriteRequest $request)
    {
        try {
            $request->validated();
            return [
                'items' => $this->repository->getUserFavoriteBooks(Auth::user()->id),
            ];
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            abort(404, $exception->getMessage());
        }
    }
}
