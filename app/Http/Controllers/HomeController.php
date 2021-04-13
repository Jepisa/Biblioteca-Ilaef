<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Advertisement;
use App\Models\Counter;
use App\Models\Recent;
use App\Models\Recommended;
use App\Models\Relevant;

class HomeController extends Controller
{
    function __invoke()
    {
        // $advertisements = Advertisement::displayable();
        // $recommended = Recommended::all();
        $relevant = Counter::mostRelevants(20);
        $recent = Recent::recents(20);
        
        return view('welcome', compact('relevant', 'recent'));
    }
}
