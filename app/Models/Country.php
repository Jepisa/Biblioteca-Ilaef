<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function podcasts()
    {
        return $this->hasMany(Podcast::class);
    }

}
