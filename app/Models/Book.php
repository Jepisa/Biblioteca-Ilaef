<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function authors()
    {
        return $this->morphToMany(Author::class, 'authorable');
    }

    public function topics()
    {
        return $this->morphToMany(Topic::class, 'topicable');
    }

    public function images()
    {
        return $this->morphMany(Extraimage::class, 'extraimageable');
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}