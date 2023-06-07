<?php

namespace App\Http\Controllers\Book;

use App\Http\Requests\Book\BookMainContentRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class BooksMainContentController extends BaseBookController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(BookMainContentRequest $request)
    {
        try {
            $request->validated();
            $books = $this->repository->getBooksMainContent();
            return ['categoriesBooks' => $books];
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
        }
    }
}
