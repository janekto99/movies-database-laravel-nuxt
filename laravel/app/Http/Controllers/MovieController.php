<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie;
use App\Services\Helper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class MovieController extends Controller
{
    public function getFilters(): JsonResponse
    {
        $filters = [
            'genres' => Genre::all(),
            'countries' => Country::all(),
            'years' => Helper::generateYears(),
        ];

        return response()->json($filters);
    }

    public function getMoviesByName(string $name): JsonResponse
    {
        $movies = Movie::with(['genre', 'country'])
            ->where('name', 'like', '%' . $name . '%')
            ->limit(10)
            ->get();

        return response()->json($movies);
    }

    public function getMovieById(int $id): JsonResponse
    {
        $movie = Movie::with(['genre', 'country', 'actors'])->find($id);
        return response()->json($movie);
    }

    public function getMovies(Request $request): LengthAwarePaginator
    {
        $validated = $request->validate([
            'year' => ['sometimes', 'integer', 'min:1900', 'max:' . ((intval(date('Y')) + 1))],
            'genre' => ['sometimes', 'integer', 'exists:genres,id'],
            'country' => ['sometimes', 'integer', 'exists:countries,id'],
            'page' => ['sometimes', 'integer', 'min:1'],
        ]);

        $query = Movie::with(['genre', 'country', 'actors']);

        if (isset($validated['year'])) {
            $query->where('year', $validated['year']);
        }

        if (isset($validated['genre'])) {
            $query->where('genre_id', $validated['genre']);
        }

        if (isset($validated['country'])) {
            $query->where('country_id', $validated['country']);
        }

        return $query->paginate(10);
    }

    public function storeMovie(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'year' => 'required|integer',
                'genre_id' => 'required|integer',
                'country_id' => 'required|integer',
                'description' => 'required|string',
                'file' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'actors' => 'required|array',
                'actors.*' => 'exists:actors,id',
            ]);


            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('wallpapers', 'public');
                $data['wallpaper_path'] = $path;
            }

            $movie = Movie::create($data);

            $movie->actors()->attach($data['actors']);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }
}
