<?php

namespace App\Http\Controllers\Book;

use App\Http\Requests\Book\BooksByCategoryIdRequest;
use App\Http\Resources\Book\BooksByCategoryIdResource;
use Exception;
use Illuminate\Support\Facades\Log;

class BooksByCategoryIdController extends BaseBookController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(BooksByCategoryIdRequest $request)
    {
        try {
            $request->validated();
            $categoryId = $request->query('category_id');
            $startIndex = $request->query('startIndex');
            $maxResult = $request->query('maxResult');
            $books = $this->repository->getBooksByCategoryId(
                $categoryId,
                $startIndex ?: 0,
                $maxResult ?: 10,
            );
            return new BooksByCategoryIdResource($books);
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
        }
    }
}
