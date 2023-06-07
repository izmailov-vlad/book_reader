<?php

namespace App\Http\Controllers\Book\Detail;

use App\Http\Controllers\Book\BaseBookController;
use App\Http\Requests\Book\Detail\BookDetailLikeCommentRequest;
use App\Http\Requests\Book\Detail\BookDetailRateBookRequest;
use App\Http\Requests\Book\Detail\StoreCommentRequest;
use App\Http\Resources\Book\Detail\BookGetCommentsResource;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Log;

class BookDetailController extends BaseBookController
{
    public function changeFavorite(Request $request)
    {
        $bookId = $request->query('book_id');
        $isFavorite = $this->repository->changeBookFavorite($bookId);
        return ['success' => $isFavorite];
    }

    public function getComments(Request $request)
    {
        try {
            $bookId = $request->query('book_id');
            if (!$bookId) {
                abort(404);
            }
            $comments = $this->repository->getComments($bookId);
            return new BookGetCommentsResource($comments);
        } catch (Exception $exception) {
            Log::error($exception);
            abort(500, 'An error occurred while retrieving comments.');
        }
    }

    public function storeComment(StoreCommentRequest $request)
    {
        try {
            $data = $request->validated();
            $bookId = $request->query('book_id');
            return ['success' => $this->repository->addComment($data, $bookId)];
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            return ['error' => $exception];
        }
    }

    public function changeCommentLikeStatus(BookDetailLikeCommentRequest $request): JsonResponse
    {
        $request->validated();
        $commentId = $request->query('comment_id');
        $result = $this->repository->changeCommentLikeStatus($commentId);
        return response()->json(['success' => $result]);
    }

    public function rateBook(BookDetailRateBookRequest $request)
    {
        $user = Auth::user();
        $bookId = $request->query('book_id');
        $newRate = $request->query('rate');
        $newRate = $this->repository->rateBook($bookId, $user->id, $newRate);
        return [
            'success' => true,
            'value' => $newRate,
        ];
    }
}
