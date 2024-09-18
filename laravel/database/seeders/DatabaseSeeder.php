<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Actor;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $jsonData = Storage::disk('local')->get('movies.json');
        $movies = json_decode($jsonData, true);

        $uniqueGenres = collect($movies)->pluck('genres')->flatten()->unique();
        $uniqueActors = collect($movies)->pluck('cast')->flatten()->unique();

        $countries = [
            'USA',
            'Czechia',
            'Germany',
            'Sweden',
            'Poland',
            'Austria',
            'Denmark',
            'France',
            'Spain',
            'India',
        ];

        foreach ($countries as $country) {
            Country::firstOrCreate([
                'name' => $country
            ]);
        }

        foreach ($uniqueGenres as $genreName) {
            Genre::firstOrCreate(['name' => $genreName]);
        }

        foreach ($uniqueActors as $actor) {
            Actor::firstOrCreate([
                'name' => $actor,
                'country_id' => rand(1, 10),
                'birthday' => '01.01.2000',
                'description' => 'Famous actor..',
            ]);
        }

        foreach ($movies as $movie) {
            $genreId = isset($movie['genres'][0]) ? Genre::where('name', $movie['genres'][0])->first()->id : 1;

            $newMovie = Movie::create([
                'name' => $movie['title'],
                'year' => $movie['year'],
                'genre_id' => $genreId,
                'country_id' => rand(1, 10),
                'description' => $movie['extract'] ?? '',
                'wallpaper_path' => $movie['thumbnail'] ?? null,
            ]);

            foreach($movie['cast'] as $actor) {
                $actorId = Actor::where('name', $actor)->first()->id;
                DB::table('movie_actor')->insert([
                    'movie_id' => $newMovie->id,
                    'actor_id' => $actorId
                ]);
            }
        }
    }
}
