<?php

namespace App\Http\Controllers\Book;

use App\Http\Requests\Book\BooksNewPublishedRequest;
use App\Http\Resources\Error\ErrorResource;
use Exception;
use Illuminate\Support\Facades\Log;

class BooksNewPublishedController extends BaseBookController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(BooksNewPublishedRequest $request): ErrorResource|array
    {
        try {
            $request->validated();
            $newBooksByWishes = $this->repository->getNewPublishedBooksByUserWishes();
            return ['data' => $newBooksByWishes];
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            return new ErrorResource($exception);
        }
    }
}
