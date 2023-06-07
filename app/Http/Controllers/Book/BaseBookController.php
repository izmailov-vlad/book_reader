<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Interfaces\BookRepositoryInterface;

class BaseBookController extends Controller
{
    public BookRepositoryInterface $repository;

    /**
     * @param BookRepositoryInterface $service
     */
    public function __construct(BookRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
