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
        dd(ContentList::all());
        // if($request->searchType == 'title'){
        //     $books = Book::where('title', 'like', '%' . $request->search . '%')->get();
        //     // $ebooks = Ebook::where('title', 'like', '%' . $request->search . '%')->get();
        //     $ebooks = collect(['uno' => 'Familia', 'dos' => 'Empresa']);

        //     $results = $books->merge($ebooks);
        //     dd($results);
        // }
        // return 'NO';
    }
}
