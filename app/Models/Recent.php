<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recent extends Model
{
    use HasFactory;


    public static function recents($limit)
    {
        $contents = ContentList::orderBy('created_at', 'desc')->limit($limit)->get();
        
        return $contents;
    }
}
