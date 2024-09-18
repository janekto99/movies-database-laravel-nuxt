<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RatingController extends Controller
{
    public function storeRating(Request $request): JsonResponse
    {
        $data = $request->validate([
            'movie_id' => 'required|integer',
            'rating' => 'required|integer',
        ]);

        $data['user_id'] = Auth::id();

        $rating = Rating::updateOrCreate([
            'movie_id' => $data['movie_id'],
            'user_id' => $data['user_id'],
        ], $data);

        return response()->json($rating);
    }

    public function getAvgRatingByMovie(int $id): float|int
    {
        $rating = Rating::where('movie_id', $id)->pluck('rating')->avg();
        return (100/5)*$rating;
    }

    public function getUserRating(int $id): JsonResponse
    {
        if(!Auth::id()){
            return response()->json(0);
        }

        $userId = Auth::id();

        $rate = Rating::where('user_id', $userId)
            ->where('movie_id', $id)
            ->value('rating');

        return response()->json($rate);
    }
}
