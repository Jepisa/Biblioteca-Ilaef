<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    protected $fillable = ['views'];

    public function countable()
    {
        return $this->morphTo();
    }

    public static function mostRelevants($limit)
    {
        $relevants = Counter::orderBy('views')->limit($limit)->get();
        $result = collect();
        foreach ($relevants as $relevant) {
            $result =  $result->push($relevant->countable);
        }
        return  $result->unique();
    }
}
