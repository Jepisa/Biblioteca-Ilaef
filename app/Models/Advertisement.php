<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'owner', 'image', 'url', 'launching', 'expiration', 'position', 'status'];

    static function displayable()
    {
        $today = date('Y-m-d');
        $advertisements = Advertisement::where('status', '=', true)
                                        ->where('launching', '<=', $today)
                                        ->where('expiration', '>=', $today)
                                        ->orderBy('position', 'asc')
                                        ->get();
        return $advertisements;
    }
}
