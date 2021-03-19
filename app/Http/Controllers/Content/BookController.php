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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

        return view('content.books.create-edit', compact('authors', 'topics', 'languages', 'countries'));
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
                        'name' => trim($authorName),
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
            
            foreach ($extraImages as $image) 
            {
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
        $book->counter()->create(['views' => 0 ]);

        
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
        //Contar las visitas a cada libro
        $book->counter()->update([
            'views' => $book->counter->views + 1,
            ]);
        
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
        // $authors = Author::all();
        $authorsName = [];

        foreach ($book->authors as $author) {
            $authorsName[] = $author->name;
        }
        $authorsName = implode(", ", $authorsName);


        $topicsName = [];
        foreach ($book->topics as $topic) {
            $topicsName[] = $topic->name;
        }
        $topicsName = implode(", ", $topicsName);

        $topics = Topic::all();
        $languages = Language::all();
        $countries = Country::all();

        return view('content.books.create-edit', compact('book','authorsName', 'topicsName', 'languages', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {

        $book = Book::where('slug', '=', $slug)->firstOrFail();

        // $datesBook = $request->validated()->except('downloadable','coverImage','backCoverImage','extraimages','audiobook');
        $datesBook = $request->except('downloadable','coverImage','backCoverImage','extraimages','audiobook', '_token', '_method');
        
        $request['originalSynopsis'] = $request->synopsis;
        $request['synopsis'] = str_replace ("\r\n"," ",$request->synopsis);
        
        $validated = $request->validate([
            'title' => [Rule::unique('books')->ignore($book->id)],
            'authorsName' => 'required|string',
            'topicsName' => 'required|string',
            // 'authors' => 'required|array|min:1',
            // 'authors.*' => 'required|integer|distinct|exists:authors,id',
            // 'topics' => 'required|array|min:1',
            // 'topics.*' => 'required|integer|distinct|exists:topics,id',
            'synopsis' => 'required|min:400|max:1200',
            'note' => 'nullable|string|max:600',
            'year' => 'nullable|integer|min:1000|max:3000',
            'collection' => 'nullable|string|max:255',
            'edition' => 'nullable|string|max:255',
            'editorial' => 'required|string|max:255',
            'language_id' => 'required|integer|exists:languages,id',
            'city' => 'nullable|string|max:255',
            'country_id' => 'required|integer|exists:countries,id',
            'pages' => 'nullable|integer',
            'isbn' => ['required','string','max:255', Rule::unique('books')->ignore($book->id)],
            'downloadable' => 'file|mimes:pdf,doc',
            'url' => 'nullable|url',
            'coverImage' => 'file|mimes:jpg,png,jpeg|dimensions:min_width=600,min_height=800,max_width=1800,max_height=2300',
            'extraimages' => 'array',
            'extraimages.*' => 'file|mimes:jpg,png,jpeg|between:40,3000',
            'backCoverImage' => 'file|mimes:jpg,png,jpeg|between:40,4000',
            'audioBook' => 'nullable|file|mimes:mp3,wma,aac',
        ]);

        $request['synopsis'] = $request->originalSynopsis;

        
        if($book->title != $datesBook['title'])
        {
            if (Storage::rename( 'public/images/books/'.$book->title,'public/images/books/'.$datesBook['title'],)) 
            {
                $datesBook['coverImage'] = Str::replaceFirst($book->title, $datesBook['title'], $book->coverImage);
                
                ($book->backCoverImage) ? $datesBook['backCoverImage'] = Str::replaceFirst($book->title, $datesBook['title'], $book->backCoverImage) : '';
                ($book->downloadable) ? $datesBook['downloadable'] = Str::replaceFirst($book->title, $datesBook['title'], $book->downloadable) : '';
                ($book->audiobook) ? $datesBook['audiobook'] = Str::replaceFirst($book->title, $datesBook['title'], $book->audiobook) : '';

                if($book->extraImages)
                {
                    foreach ($book->extraImages as $image) 
                    {
                        $image->update([
                            'image' => Str::replaceFirst($book->title, $datesBook['title'], $image->image),
                        ]); 
                    }                
                }
            }
        }
        if(isset($datesBook['authorsName']))
        {
            $authorsName = [];
            foreach ($book->authors as $author) {
                $authorsName[] = $author->name;
            }
            $authorsName = implode(", ", $authorsName);

            $arrayAuthorsName = explode(',', $datesBook['authorsName']);

            $datesBook['authorsName'] = [];
            foreach ($arrayAuthorsName as $authorName) {
                $datesBook['authorsName'][] = trim($authorName);
            }

            $datesBook['authorsName'] = implode(", ", $datesBook['authorsName']);

            if($authorsName != $datesBook['authorsName'])
            {
            //Authors
                $authors = explode(",", $datesBook['authorsName']);

                $existAuthors = [];
                $newAuthors = [];

                $createdAuthors = [];

                $authorsOfTheBook = [];

            
                foreach ($authors as $authorName) {
                    $savedAuthor = Author::where('name', '=', trim($authorName))->first();
                    if($savedAuthor){
                        if(Str::lower($savedAuthor->name) == Str::lower(trim($authorName)))
                        {
                            $existAuthors[] = $authorName;

                            $authorsOfTheBook[] = $savedAuthor->id;
                        }
                    }
                    else 
                    {
                        $createdAuthor = Author::create([
                            'name' => trim($authorName),
                        ]);

                        $newAuthors[] = $createdAuthor->name;

                        $createdAuthors[] = $createdAuthor->name;

                        $authorsOfTheBook[] = $createdAuthor->id;

                    }
                }

                $existAuthors = implode(", ", $existAuthors);
                $newAuthors = implode(", ", $newAuthors);

                $book->authors()->sync($authorsOfTheBook);

                $notificationAuthors = "Estos autores se crearon exitosamente: $newAuthors. \r\n Estos ya estaban en nuestra base de datos: $existAuthors" ;
                $request->session()->flash('notificationAuthors', $notificationAuthors);
            //
            }
        }
        
        if(isset($datesBook['topicsName']))
        {
            $topicsName = [];
            foreach ($book->topics as $topic) {
                $topicsName[] = $topic->name;
            }
            $topicsName = implode(", ", $topicsName);

            $arrayTopicsName = explode(',', $datesBook['topicsName']);

            $datesBook['topicsName'] = [];
            foreach ($arrayTopicsName as $topicName) {
                $datesBook['topicsName'][] = trim($topicName);
            }

            $datesBook['topicsName'] = implode(", ", $datesBook['topicsName']);

            if($topicsName != $datesBook['topicsName'])
            {
                //Topics
                    $topics = explode(",", $datesBook['topicsName']);

                    $existTopics = [];
                    $newTopics = [];

                    $createdTopics = [];

                    $topicsOfTheBook = [];

                
                    foreach ($topics as $topicName) {
                        $savedTopic = Topic::where('name', '=', trim($topicName))->first();
                        
                        if($savedTopic)
                        {
                            if(Str::lower($savedTopic->name) == Str::lower(trim($topicName)))
                            {
                                $existTopics[] = $topicName;
                                $topicsOfTheBook[] = $savedTopic->id;
                            }
                        }
                        else 
                        {
                            $createdTopic = Topic::create([
                                'name' => trim($topicName),
                            ]);

                            $newTopics[] = $createdTopic->name;

                            $createdTopics[] = $createdTopic->name;

                            $topicsOfTheBook[] = $createdTopic->id;

                        }
                    }

                    $existTopics = implode(", ", $existTopics);
                    $newTopics = implode(", ", $newTopics);

                    $book->topics()->sync($topicsOfTheBook);


                    $notificationTopics = "Estos autores se crearon exitosamente: $newTopics. \r\n Estos ya estaban en nuestra base de datos: $existTopics" ;
                    $request->session()->flash('notificationTopics', $notificationTopics);
                // ----
            }
        }

        if($request->hasFile('coverImage'))
        {
            Storage::delete('public/'.$book->coverImage);
            $destination_path = 'images/books/'.$datesBook['title'];
            $coverImage = $request->file('coverImage');
            $image_name = $coverImage->getClientOriginalName();
            $datesBook['coverImage'] = $coverImage->storeAs($destination_path, $image_name, 'public');
        }

        if($request->hasFile('backCoverImage'))
        {
            Storage::delete('public/'.$book->backCoverImage);
            $destination_path = 'images/books/'.$datesBook['title'];
            $backCoverImage = $request->file('backCoverImage');
            $image_name = $backCoverImage->getClientOriginalName();
            $datesBook['backCoverImage'] = $backCoverImage->storeAs($destination_path, $image_name, 'public');
        }

        if($request->hasFile('audioBook'))
        {
            Storage::delete('public/'.$book->audioBook);
            $destination_path = 'images/books/'.$datesBook['title'].'/';
            $audioBook = $request->file('audioBook');
            $audioBook_name = $audioBook->getClientOriginalName();
            $datesBook['audioBook'] = $audioBook->storeAs($destination_path, $audioBook_name, 'public');

            $datesBook['format'] = $audioBook->extension();
        }

        if($request->hasFile('downloadable'))
        {
            Storage::delete('public/'.$book->downloadable);
            $destination_path = 'images/books/'.$datesBook['title'];
            $image = $request->file('downloadable');
            $image_name = $image->getClientOriginalName();

            $datesBook['downloadable'] = $request->file('downloadable')->storeAs($destination_path, $image_name, 'public');
        }

        $datesBook['slug'] = Str::slug($datesBook['title']);
        
        $book->update($datesBook);

        if (isset($request->extraImages)) {
            
            foreach ($book->extraImages as $previousImage) {
                Storage::delete('public/'.$previousImage->image);
            }

            $extraImages = $request->extraImages;
            
            foreach ($extraImages as $image) 
            {
                //Guardar las imagenes en el servidor
                    $destination_path = 'images/books/'.$book->title;
                    
                    $image_name = $image->getClientOriginalName();
                    $path = $image->storeAs($destination_path, $image_name, 'public');

                    $book->extraImages()->create([
                        'image' => $path,
                    ]);
            }
        }

        

        

        $notification = "Actualizado con éxito";
        $request->session()->flash('notification', $notification);

        return redirect()->route('book.edit', ['slug' => $book->slug]);
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
        
        //Eliminar la vinculación en la bd con los autores y los temas
            $book->authors()->detach();
            $book->topics()->detach();

        //Eliminar la vinculación en la bd con las Imagenes extras
            $book->extraImages()->delete();

        //Eliminar Archivo descargable  //Eliminar Imagen de Tapa //Eliminar Imagen de Contratapa 
        //Eliminar Audiolibro //Eliminar las imagenes extras (todo del servidor) 
        //Eliminar hasta la carpeta (directorio) del libro
        Storage::deleteDirectory('public/images/books/'.$book->title);
        
        //Eliminar su Contador (que aún no lo creé)
        
        //
        $titleOfDeletedBook = $book->title;
        $book->delete();
        
        $notification = "Se ha eliminado '$titleOfDeletedBook' y todo lo que contenía.";
        
        
        $request->session()->flash('notification', $notification);

        return redirect()->back();
    }
}
