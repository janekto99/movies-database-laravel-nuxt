<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function getReviews(int $id)
    {
        return Review::where('movie_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function storeReview(Request $request)
    {
        $data = $request->validate([
            'movie_id' => 'required|integer',
            'review' => 'required|string',
        ]);

        $data['user_id'] = Auth::id();

        $review = Review::create($data);

        $review->load('user');

        return response()->json($review);
    }
}
