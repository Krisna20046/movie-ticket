<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Film;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films = [
            [
                'judul' => 'Inception',
                'deskripsi' => 'A thief who steals corporate secrets through the use of dream-sharing technology.',
                'durasi' => 148,
                'genre' => 'Sci-Fi',
                'rating' => rand(3, 10)
            ],
            [
                'judul' => 'The Shawshank Redemption',
                'deskripsi' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                'durasi' => 142,
                'genre' => 'Drama',
                'rating' => rand(3, 10)
            ],
            [
                'judul' => 'The Dark Knight',
                'deskripsi' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham.',
                'durasi' => 152,
                'genre' => 'Action',
                'rating' => rand(3, 10)
            ],
            [
                'judul' => 'Pulp Fiction',
                'deskripsi' => 'The lives of two mob hitmen, a boxer, a gangster and his wife, and a pair of diner bandits intertwine.',
                'durasi' => 154,
                'genre' => 'Crime',
                'rating' => rand(3, 10)
            ],
            [
                'judul' => 'The Godfather',
                'deskripsi' => 'The aging patriarch of an organized crime dynasty transfers control to his reluctant son.',
                'durasi' => 175,
                'genre' => 'Crime',
                'rating' => rand(3, 10)
            ],
            [
                'judul' => 'Fight Club',
                'deskripsi' => 'An insomniac office worker and a devil-may-care soapmaker form an underground fight club.',
                'durasi' => 139,
                'genre' => 'Drama',
                'rating' => rand(3, 10)
            ],
            [
                'judul' => 'Forrest Gump',
                'deskripsi' => 'The presidencies of Kennedy and Johnson, the events of Vietnam, Watergate, and other history.',
                'durasi' => 142,
                'genre' => 'Drama',
                'rating' => rand(3, 10)
            ],
            [
                'judul' => 'The Matrix',
                'deskripsi' => 'A computer hacker learns about the true nature of reality.',
                'durasi' => 136,
                'genre' => 'Sci-Fi',
                'rating' => rand(3, 10)
            ],
            [
                'judul' => 'Goodfellas',
                'deskripsi' => 'The story of Henry Hill and his life in the mob.',
                'durasi' => 146,
                'genre' => 'Biography',
                'rating' => rand(3, 10)
            ],
            [
                'judul' => 'The Silence of the Lambs',
                'deskripsi' => 'A young FBI cadet must receive the help of an incarcerated cannibal killer.',
                'durasi' => 118,
                'genre' => 'Crime',
                'rating' => rand(3, 10)
            ],
            [
                'judul' => 'Interstellar',
                'deskripsi' => 'A team of explorers travel through a wormhole in space.',
                'durasi' => 169,
                'genre' => 'Sci-Fi',
                'rating' => rand(3, 10)
            ],
            [
                'judul' => 'Parasite',
                'deskripsi' => 'Greed and class discrimination threaten the newly formed symbiotic relationship.',
                'durasi' => 132,
                'genre' => 'Comedy',
                'rating' => rand(3, 10)
            ]
        ];

        foreach ($films as $film) {
            Film::create($film);
        }
    }
}