<?php

namespace App\Http\Controllers\Book;

use App\Http\Requests\Book\BookByQueryRequest;
use App\Http\Resources\Book\BooksByQueryResource;
use Exception;
use Illuminate\Support\Facades\Log;

class BookByQueryController extends BaseBookController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(BookByQueryRequest $request)
    {
        try {
            $request->validated();
            $query = $request->query('query');
            $startIndex = $request->query('startIndex');
            $maxResult = $request->query('maxResult');
            $books = $this->repository->getBooksByQuery(
                $query . '&subject:' . $query . '&inauthor:' . $query. '&inpublisher:' . $query,
                $startIndex ?: 0,
                $maxResult ?: 10,
            );
            return new BooksByQueryResource($books);
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
        }
    }
}
