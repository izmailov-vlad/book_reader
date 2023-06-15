<?php

use App\Http\Controllers\Book\BooksPopularController;
use App\Http\Controllers\ChatGPT\ApiController;
use App\Http\Controllers\Book\BookByIdController;
use App\Http\Controllers\Book\BookByQueryController;
use App\Http\Controllers\Book\BooksByCategoryIdController;
use App\Http\Controllers\Book\BooksCategoriesController;
use App\Http\Controllers\Book\BooksMainContentController;
use App\Http\Controllers\Book\BooksNewPublishedController;
use App\Http\Controllers\Book\Detail\BookDetailController;
use App\Http\Controllers\Book\Favorite\BookFavoriteController;
use App\Http\Controllers\User\DeleteUserController;
use App\Http\Controllers\User\GetCurrentUserAuthController;
use App\Http\Controllers\User\GoogleAuthController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\LogoutController;
use App\Http\Controllers\User\RefreshTokenController;
use App\Http\Controllers\User\RegistrationController;
use App\Http\Controllers\User\UpdatePhotoController;
use App\Http\Controllers\User\UserEditController;
use App\Http\Controllers\UserWishesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user/set-wishes', [UserWishesController::class, 'setWishes']);
    Route::post('/user/logout', LogoutController::class);
    Route::post('/user/delete', DeleteUserController::class);
    Route::get('/user/have-wishes', [UserWishesController::class, 'isUserHaveWishes']);
    Route::post('/user/update-photo', UpdatePhotoController::class);
    Route::post('/user/edit', UserEditController::class);
    Route::get('/book/new-books', BooksNewPublishedController::class);
    Route::get('/book/popular-books', BooksPopularController::class);
    Route::post('/book/change-favorite', [BookFavoriteController::class, 'changeFavorite']);
    Route::get('/user/favorite', [BookFavoriteController::class, 'userFavorite']);
    Route::get('/user/get-curr-user', GetCurrentUserAuthController::class);
    Route::get('/book/book-by-query', BookByQueryController::class);
    Route::get('/book/book-by-id', BookByIdController::class);
    Route::get('/book/books-by-category-id', BooksByCategoryIdController::class);
    Route::get('/book/books-by-categories', BooksMainContentController::class);
    Route::get('/book/categories', BooksCategoriesController::class);
    Route::post('/book/store-comment', [BookDetailController::class, 'storeComment']);
    Route::get('/book/comments', [BookDetailController::class, 'getComments']);
    Route::post('/book/rate', [BookDetailController::class, 'rateBook']);
    Route::post('/book/comment/change-like-status', [BookDetailController::class, 'changeCommentLikeStatus']);
});

Route::get("/chat-gpt/questions", [ApiController::class, "questions"]);
Route::get("/chat-gpt/ask-question", [ApiController::class, "index"]);


// Google auth
Route::post('/login/google', [GoogleAuthController::class, 'loginWithGoogle']);

Route::get('/user/auth/refresh', RefreshTokenController::class);
Route::post('/user/login', LoginController::class);
Route::post('/user/register', RegistrationController::class);
