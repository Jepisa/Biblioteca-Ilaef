<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('authorCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'authorsName' => 'string',
        ]);

        $authors = explode(",", $request->authorsName);

        $existAuthors = [];
        $newAuthors = [];


        foreach ($authors as $authorName) {
            $savedAuthor = Author::where('name', '=', $authorName)->first();
            

            if($savedAuthor->name == $authorName)
            {
                $existAuthors[] = $authorName;
            }
            else 
            {
                Author::create([
                    'name' => $authorName,
                ]);

                $newAuthors[] = $authorName;
            }
        }

        $existAuthors = implode(", ", $existAuthors);
        $newAuthors = implode(", ", $newAuthors);

        $notification = "Estos autores se crearon exitosamente: $newAuthors. \r\n Estos ya estaban en nuestra base de datos: $existAuthors" ;
        $request->session()->flash('notification', $notification);

        return redirect()->back();
         
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        //
    }
}
