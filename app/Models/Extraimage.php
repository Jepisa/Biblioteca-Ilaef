<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extraimage extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function extraimageable()
    {
        return $this->morphTo();
    }
}