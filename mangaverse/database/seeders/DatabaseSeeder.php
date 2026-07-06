<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Genre;
use App\Models\Comic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Users (Admin, Staff, Customer)
        User::create([
            'name' => 'Admin Mangaverse',
            'email' => 'admin@mangaverse.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Customer Satu',
            'email' => 'customer@mangaverse.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // 2. Create Authors
        $author1 = Author::create(['name' => 'Gege Akutami', 'slug' => Str::slug('Gege Akutami')]);
        $author2 = Author::create(['name' => 'Haruichi Furudate', 'slug' => Str::slug('Haruichi Furudate')]);

        // 3. Create Publishers
        $pub1 = Publisher::create(['name' => 'Shueisha', 'slug' => Str::slug('Shueisha')]);
        $pub2 = Publisher::create(['name' => 'Elex Media Komputindo', 'slug' => Str::slug('Elex Media Komputindo')]);

        // 4. Create Genres
        $genreAction = Genre::create(['name' => 'Action', 'slug' => 'action']);
        $genreFantasy = Genre::create(['name' => 'Fantasy', 'slug' => 'fantasy']);
        $genreSports = Genre::create(['name' => 'Sports', 'slug' => 'sports']);
        $genreComedy = Genre::create(['name' => 'Comedy', 'slug' => 'comedy']);

        // 5. Create Comics
        $comic1 = Comic::create([
            'title' => 'Jujutsu Kaisen Vol. 1',
            'slug' => Str::slug('Jujutsu Kaisen Vol 1'),
            'synopsis' => 'Yuji Itadori adalah siswa SMA dengan atletisitas luar biasa. Suatu hari, untuk menyelamatkan temannya yang diserang Kutukan, dia memakan jari Ryomen Sukuna...',
            'author_id' => $author1->id,
            'publisher_id' => $pub1->id,
            'isbn' => '978-4-08-881516-9',
            'published_year' => 2018,
            'pages' => 192,
            'weight' => 200,
            'price' => 45000,
            'stock' => 50,
            'rating' => 4.9,
            'status' => 'Available',
        ]);
        $comic1->genres()->attach([$genreAction->id, $genreFantasy->id]);

        $comic2 = Comic::create([
            'title' => 'Haikyuu!! Vol. 1',
            'slug' => Str::slug('Haikyuu Vol 1'),
            'synopsis' => 'Shoyo Hinata mulai bermain voli setelah melihat "Raksasa Kecil" bermain. Di SMA Karasuno, dia bertemu dengan rivalnya, Tobio Kageyama...',
            'author_id' => $author2->id,
            'publisher_id' => $pub1->id,
            'isbn' => '978-4-08-870453-1',
            'published_year' => 2012,
            'pages' => 200,
            'weight' => 210,
            'price' => 40000,
            'stock' => 30,
            'rating' => 4.8,
            'status' => 'Available',
        ]);
        $comic2->genres()->attach([$genreSports->id, $genreComedy->id]);
    }
}