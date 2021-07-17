<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ContentList;
use App\Models\Ebook;
use Illuminate\Http\Request;

class SearchContentController extends Controller
{
    public function search(Request $request)
    {
        // si search es null, se busca '%%' y trae todos menos los que tengan null en la columna
        // ya se limpian los espacios, no hace falta trim
        // $search_types = ['Todo', 'Autor', 'Título', 'Editorial', 'Tema', 'ISBN'];

        $search_types = ['all', 'authors', 'title', 'editorial', 'topics', 'isbn'];
        $search_type = $request->searchType;
        $search = $request->search;

        if (!in_array($search_type, $search_types)) return redirect()->route('home');

        if ($search_type != 'all') {
            $contents = ContentList::where($search_type, 'like', '%' . $search . '%')->get();
        } else {
            $contents = ContentList::where('authors', 'like', '%' . $search . '%')
                                    ->orWhere('title', 'like', '%' . $search . '%')
                                    ->orWhere('editorial', 'like', '%' . $search . '%')
                                    ->orWhere('topics', 'like', '%' . $search . '%')
                                    ->orWhere('isbn', 'like', '%' . $search . '%')
                                    ->get();
        }

        return dd($contents);
    }
}
