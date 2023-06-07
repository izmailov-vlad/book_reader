<?php

namespace App\Http\Controllers\Book;

use App\Http\Requests\Book\BookByIdRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class BookByIdController extends BaseBookController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(BookByIdRequest $request)
    {
        try {
            $request->validated();
            $bookId = $request->query('book_id');
            return $this->repository->getBookById($bookId);
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
        }
    }
}
