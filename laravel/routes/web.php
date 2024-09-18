<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return ['Laravel' => app()->version()];
//});

Route::prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'getMovies']);
    Route::get('filters', [MovieController::class, 'getFilters']);
    Route::get('search/{name}', [MovieController::class, 'getMoviesByName']);
    Route::get('{movie}', [MovieController::class, 'getMovieById']);
    Route::post('/', [MovieController::class, 'storeMovie']);
});

Route::prefix('actors')->group(function () {
    Route::get('/', [ActorController::class, 'getActors']);
    Route::get('{actor}', [ActorController::class, 'getActorById']);
    Route::post('/', [ActorController::class, 'storeActor']);
});

Route::prefix('reviews')->group(function () {
    Route::get('movies/{movie_id}', [ReviewController::class, 'getReviews']);

    Route::middleware('auth')->group(function () {
        Route::post('/', [ReviewController::class, 'storeReview']);
    });
});

Route::prefix('ratings')->group(function () {
    Route::get('movies/{movie_id}', [RatingController::class, 'getAvgRatingByMovie']);
    Route::get('user/{movie}', [RatingController::class, 'getUserRating']);
    Route::middleware('auth')->group(function () {
        Route::post('/', [RatingController::class, 'storeRating']);
    });
});

require __DIR__.'/auth.php';
