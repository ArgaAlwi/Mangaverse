<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'cover', 'synopsis', 'author_id', 
        'publisher_id', 'isbn', 'published_year', 'pages', 
        'language', 'weight', 'price', 'discount', 'rating', 'stock', 'status'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
    // Relasi ke Ulasan
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}