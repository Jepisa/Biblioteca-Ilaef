<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Books\StoreBookRequest;
use Illuminate\Support\Str;
use App\Models\Author;
use App\Models\Book;
use App\Models\Country;
use App\Models\Language;
use App\Models\Topic;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();

        return view('content.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::all();
        $topics = Topic::all();
        $languages = Language::all();
        $countries = Country::all();

        return view('content.books.create', compact('authors', 'topics', 'languages', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\Books\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {   
        $validated = $request->validated();

        //Authors
            $authors = explode(",", $validated['authorsName']);

            $existAuthors = [];
            $newAuthors = [];

            $createdAuthors = [];

            $authorsOfTheBook = [];

        
            foreach ($authors as $authorName) {
                $savedAuthor = Author::where('name', '=', $authorName)->first();
                if($savedAuthor){
                    if($savedAuthor->name == $authorName)
                    {
                        $existAuthors[] = $authorName;

                        $authorsOfTheBook[] = $savedAuthor->id;
                    }
                }
                else 
                {
                    $createdAuthor = Author::create([
                        'name' => $authorName,
                    ]);

                    $newAuthors[] = $createdAuthor->name;

                    $createdAuthors[] = $createdAuthor->name;

                    $authorsOfTheBook[] = $createdAuthor->id;

                }
            }

            $existAuthors = implode(", ", $existAuthors);
            $newAuthors = implode(", ", $newAuthors);

            $notificationAuthors = "Estos autores se crearon exitosamente: $newAuthors. \r\n Estos ya estaban en nuestra base de datos: $existAuthors" ;
            $request->session()->flash('notificationAuthors', $notificationAuthors);
        //Topics
            $topics = explode(",", $validated['topicsName']);

            $existTopics = [];
            $newTopics = [];

            $createdTopics = [];

            $topicsOfTheBook = [];

        
            foreach ($topics as $topicName) {
                $savedTopic = Topic::where('name', '=', $topicName)->first();
                
                if($savedTopic)
                {
                    if($savedTopic->name == $topicName)
                    {
                        $existTopics[] = $topicName;
                        $topicsOfTheBook[] = $savedTopic->id;
                    }
                }
                else 
                {
                    $createdTopic = Topic::create([
                        'name' => $topicName,
                    ]);

                    $newTopics[] = $createdTopic->name;

                    $createdTopics[] = $createdTopic->name;

                    $topicsOfTheBook[] = $createdTopic->id;

                }
            }

            $existTopics = implode(", ", $existTopics);
            $newTopics = implode(", ", $newTopics);

            $notificationTopics = "Estos autores se crearon exitosamente: $newTopics. \r\n Estos ya estaban en nuestra base de datos: $existTopics" ;
            $request->session()->flash('notificationTopics', $notificationTopics);
        // ----

        if($request->hasFile('coverImage'))
        {
            $destination_path = 'images/books/'.$validated['title'];
            $image = $request->file('coverImage');
            $image_name = $image->getClientOriginalName();
            $pathCoverImage = $request->file('coverImage')->storeAs($destination_path, $image_name, 'public');
        }

        if($request->hasFile('backCoverImage'))
        {
            $destination_path = 'images/books/'.$validated['title'];
            $image = $request->file('backCoverImage');
            $image_name = $image->getClientOriginalName();
            $pathBackCoverImage = $request->file('backCoverImage')->storeAs($destination_path, $image_name, 'public');
        }

        if($request->hasFile('audioBook'))
        {
            $destination_path = 'images/books/'.$validated['title'].'/';
            $audioBook = $request->file('audioBook');
            $audioBook_name = $audioBook->getClientOriginalName();
            $pathAudioBook = $audioBook->storeAs($destination_path, $audioBook_name, 'public');

            $extension_audioBook = $audioBook->extension();
        }

        if($request->hasFile('downloadable'))
        {
            $destination_path = 'images/books/'.$validated['title'];
            $image = $request->file('downloadable');
            $image_name = $image->getClientOriginalName();
            $pathDownloadable = $request->file('downloadable')->storeAs($destination_path, $image_name, 'public');
        }


        $book = Book::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'synopsis' => $request['synopsis-original'],
            'note' => isset($validated['note']) ? $validated['note'] : null,
            'year' => isset($validated['year']) ? $validated['year'] : null,
            'collection' => isset($validated['collection']) ? $validated['collection'] : null,
            'edition' => isset($validated['edition']) ? $validated['edition'] : null,
            'editorial' => $validated['editorial'],
            'language_id' => $validated['language_id'],
            'city' => isset($validated['city']) ? $validated['city'] : null ,
            'country_id' => $validated['country_id'],
            'pages' => isset($validated['pages']) ? $validated['pages'] : null ,
            'isbn' => $validated['isbn'],
            'downloadable' => isset($pathDownloadable) ? $pathDownloadable : null,
            'url' => isset($validated['url']) ? $validated['url'] : null ,
            'coverImage' => isset($pathCoverImage) ? $pathCoverImage : 'public/images/books/default',
            'backCoverImage' => isset($pathBackCoverImage) ? $pathBackCoverImage : 'public/images/books/default',
            'audiobook' => isset($pathAudioBook) ? $pathAudioBook : null,
            'format' => isset($extension_audioBook) ? $extension_audioBook : null,
        ]);

        if (isset($request->extraImages)) {
            
            $extraImages = $request->extraImages;
            
            foreach ($extraImages as $image) {
                //Guardar las imagenes en el servidor
                    $destination_path = 'images/books/'.$book->title;
                    
                    $image_name = $image->getClientOriginalName();
                    $path = $image->storeAs($destination_path, $image_name, 'public');

                    $book->extraImages()->create([
                        'image' => $path,
                    ]);
            }
        }
        
            

        $book->authors()->sync($authorsOfTheBook);//
        $book->topics()->sync($topicsOfTheBook);//
        
        $notification = "El libro '$book->title' fue creado con éxito." ;
        $request->session()->flash('notification', $notification);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $book = Book::where('slug', '=', $slug)->firstOrFail();

        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $book = Book::where('slug', '=', $slug)->firstOrFail();

        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $notification = "Actualización con éxito";
        $request->session()->flash('notification', $notification);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $slug)
    {
        $book = Book::where('slug', '=', $slug)->firstOrFail();
        
        $notification = "Se ha eliminado '$book->name' y todo lo que contenía.";
        
        $book->delete();

        
        $request->session()->flash('notification', $notification);

        return redirect()->back();
    }
}
