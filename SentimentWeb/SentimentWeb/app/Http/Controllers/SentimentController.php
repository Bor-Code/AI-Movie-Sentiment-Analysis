<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SentimentController extends Controller
{
    // Wikipedia'dan çekilen garantili HD posterler
    private $movies = [
        [
            'id' => 1,
            'title' => 'The Dark Knight',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/8/8a/Dark_Knight.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/8/8a/Dark_Knight.jpg'
        ],
        [
            'id' => 2,
            'title' => 'Inception',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/2/2e/Inception_%282010%29_theatrical_poster.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/2/2e/Inception_%282010%29_theatrical_poster.jpg'
        ],
        [
            'id' => 3,
            'title' => 'Interstellar',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/b/bc/Interstellar_film_poster.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/b/bc/Interstellar_film_poster.jpg'
        ],
        [
            'id' => 4,
            'title' => 'Joker',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/e/e1/Joker_%282019_film%29_poster.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/e/e1/Joker_%282019_film%29_poster.jpg'
        ],
        [
            'id' => 5,
            'title' => 'Avengers: Endgame',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/0/0d/Avengers_Endgame_poster.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/0/0d/Avengers_Endgame_poster.jpg'
        ],
        [
            'id' => 6,
            'title' => 'Fight Club',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/f/fc/Fight_Club_poster.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/f/fc/Fight_Club_poster.jpg'
        ],
        [
            'id' => 7,
            'title' => 'The Matrix',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/c/c1/The_Matrix_Poster.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/c/c1/The_Matrix_Poster.jpg'
        ],
        [
            'id' => 8,
            'title' => 'The Godfather',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/1/1c/Godfather_ver1.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/1/1c/Godfather_ver1.jpg'
        ],
        [
            'id' => 9,
            'title' => 'Pulp Fiction',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/3/3b/Pulp_Fiction_%281994%29_poster.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/3/3b/Pulp_Fiction_%281994%29_poster.jpg'
        ],
        [
            'id' => 10,
            'title' => 'Forrest Gump',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/6/67/Forrest_Gump_poster.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/6/67/Forrest_Gump_poster.jpg'
        ],
        [
            'id' => 11,
            'title' => 'The Shawshank Redemption',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/8/81/ShawshankRedemptionMoviePoster.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/8/81/ShawshankRedemptionMoviePoster.jpg'
        ],
        [
            'id' => 12,
            'title' => 'The Lord of the Rings: Return of the King',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/2/23/The_Lord_of_the_Rings%2C_The_Return_of_the_King.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/2/23/The_Lord_of_the_Rings%2C_The_Return_of_the_King.jpg'
        ],
        [
            'id' => 13,
            'title' => 'Titanic',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/1/18/Titanic_%281997_film%29_poster.png',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/1/18/Titanic_%281997_film%29_poster.png'
        ],
        [
            'id' => 14,
            'title' => 'The Lion King',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/3/3d/The_Lion_King_poster.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/3/3d/The_Lion_King_poster.jpg'
        ],
        [
            'id' => 15,
            'title' => 'Back to the Future',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/d/d2/Back_to_the_Future.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/d/d2/Back_to_the_Future.jpg'
        ],
        [
            'id' => 16,
            'title' => 'Parasite',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/5/53/Parasite_%282019_film%29.png',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/5/53/Parasite_%282019_film%29.png'
        ],
        [
            'id' => 17,
            'title' => 'Whiplash',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/0/01/Whiplash_poster.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/0/01/Whiplash_poster.jpg'
        ],
        [
            'id' => 18,
            'title' => 'Star Wars: A New Hope',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/8/87/StarWarsMoviePoster1977.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/8/87/StarWarsMoviePoster1977.jpg'
        ],
        [
            'id' => 19,
            'title' => 'Terminator 2',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/8/85/Terminator2poster.jpg',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/8/85/Terminator2poster.jpg'
        ],
        [
            'id' => 20,
            'title' => 'Spirited Away',
            'image' => 'https://upload.wikimedia.org/wikipedia/en/d/db/Spirited_Away_Japanese_poster.png',
            'backdrop' => 'https://upload.wikimedia.org/wikipedia/en/d/db/Spirited_Away_Japanese_poster.png'
        ]
    ];

    public function index()
    {
        $randomMovie = $this->movies[array_rand($this->movies)];
        return view('sentiment', compact('randomMovie'));
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'review' => 'required|string|min:2',
            'movie_id' => 'required|integer'
        ]);

        $currentMovie = collect($this->movies)->firstWhere('id', $request->input('movie_id'));

        try {
            $response = Http::post('http://127.0.0.1:8000/predict', [
                'text' => $request->input('review')
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return view('sentiment', [
                    'randomMovie' => $currentMovie,
                    'result' => $data
                ]);
            } else {
                return back()->with('error', 'API hatası.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Sunucu hatası: ' . $e->getMessage());
        }
    }
}