<?php

namespace App\Http\Controllers\Book;

use App\Http\Requests\Book\BookCategoriesRequest;
use App\Http\Resources\Book\BookCategoriesResource;
use Exception;
use Illuminate\Support\Facades\Log;

class BooksCategoriesController extends BaseBookController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(BookCategoriesRequest $request)
    {
        try {
            $request->validated();
            $categories = $this->repository->getCategories();
            return new BookCategoriesResource($categories);
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
        }
    }
}
