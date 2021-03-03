<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function books()
    {
        return $this->morphedByMany(Book::class, 'topicable');
    }

    public function podcasts()
    {
        return $this->morphedByMany(Podcast::class, 'topicable');
    }
}
