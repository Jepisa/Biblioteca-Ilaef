<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    /**
     * Show the navbar search results.
     *
     * @param Request $request
     * @return View
     */
    public function showNavbarSearchResults(Request $request)
    {
        // Check that the search keyword is present.

        if (! $request->filled('adminlteSearch')) {
            return back();
        }

        // Get the search keyword.

        $keyword = $request->input('adminlteSearch');

        Log::info("A navbar search was triggered with next keyword => {$keyword}");

        // TODO: Create the search logic and return adequate response (maybe a view
        // with the results).
        // ...
        return back();
    }
}