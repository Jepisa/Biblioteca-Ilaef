<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recent extends Model
{
    use HasFactory;


    public static function recents($limit)
    {
        $books = Book::orderBy('created_at')->limit($limit)->get();
        $podcasts = Podcast::orderBy('created_at')->limit($limit)->get();
        
        return $books;
    }
}
