<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        $relevants = Counter::orderBy('views', 'desc')->limit($limit)->get();
        $result = collect();
        foreach ($relevants as $relevant) {
            $content = $relevant->countable;
            $modelName = get_class($content);

            $content->type = self::nameModelType($modelName);
            $result =  $result->push($content);
        }
        return  $result->unique();
    }

    private static function nameModelType($modelName)
    {
        $nameModel = Str::slug($modelName);
        return $nameModel;
    }
}
