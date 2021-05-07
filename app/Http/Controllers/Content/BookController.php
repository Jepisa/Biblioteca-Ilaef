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
        $books = Book::orderBy('created_at', 'desc')->paginate(10);

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

        //Agunas cosas necesarias
            $slugOfBook = Str::slug($validated['title']);
            $destination_path = 'content/books/'.$slugOfBook;
            $disk = 'public';
        //

        if($request->hasFile('coverImage'))
        {
            $image_name = Str::slug($request->file('coverImage')->getClientOriginalName());
            $extension = $request->file('coverImage')->extension();
            $new_image_name = $image_name.'.'.$extension;
            $pathCoverImage = $request->file('coverImage')->storeAs($destination_path, $new_image_name, $disk);
        }

        if($request->hasFile('backCoverImage'))
        {
            $image_name = Str::slug($request->file('backCoverImage')->getClientOriginalName());
            $extension = $request->file('backCoverImage')->extension();
            $new_image_name = $image_name.'.'.$extension;
            $pathBackCoverImage = $request->file('backCoverImage')->storeAs($destination_path, $new_image_name, $disk);
        }

        if($request->hasFile('audioBook'))
        {
            $audioBook_name = Str::slug($request->file('audioBook')->getClientOriginalName());
            $extension = $request->file('audioBook')->extension();
            $new_image_name = $image_name.'.'.$extension;
            $pathAudioBook = $request->file('audioBook')->storeAs($destination_path, $audioBook_name, $disk);

            $extension_audioBook = $request->file('audioBook')->extension();
        }

        if($request->hasFile('downloadable'))
        {
            $image_name = Str::slug($request->file('downloadable')->getClientOriginalName());
            $extension = $request->file('downloadable')->extension();
            $new_image_name = $image_name.'.'.$extension;
            $pathDownloadable = $request->file('downloadable')->storeAs($destination_path, $new_image_name, $disk);
        }

        //Crea Book en BD
        $book = Book::create([
            'title' => $validated['title'],
            'slug' => $slugOfBook,
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
            'isbn' => isset($validated['isbn']) ? $validated['isbn'] : null,
            'downloadable' => isset($pathDownloadable) ? $pathDownloadable : null,
            'url' => isset($validated['url']) ? $validated['url'] : null ,
            'coverImage' => isset($pathCoverImage) ? $pathCoverImage : 'public/content/books/default', //Aún no existe una imagen por default
            'backCoverImage' => isset($pathBackCoverImage) ? $pathBackCoverImage : 'public/content/books/default', //Aún no existe una imagen por default
            'audiobook' => isset($pathAudioBook) ? $pathAudioBook : null,
            'format' => isset($extension_audioBook) ? $extension_audioBook : null,
        ]);

        if (isset($request->extraImages)) {
            
            $extraImages = $request->extraImages;
            
            foreach ($extraImages as $image) 
            {
                //Guardar las imagenes en el servidor                    
                    $image_name = Str::slug($image->getClientOriginalName());
                    $extension = $image->extension();
                    $new_image_name = $image_name.'.'.$extension;
                    $path = $image->storeAs($destination_path, $new_image_name, $disk);

                    $book->extraImages()->create([
                        'image' => $path,
                    ]);
            }
        } 

        //Después hay que remplazar esta manera de optener y cuardar los Authors and Topics
        //Guardar y asignar Authors
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
        //Guardar y asignar Topics
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

        $book->authors()->sync($authorsOfTheBook);
        $book->topics()->sync($topicsOfTheBook);
        
        //Se crea el contador de views del Book
        $book->counter()->create(['views' => 0 ]);//A la table del contador le puedo poner más columnas (a parte de 'views'), como 'favorites', 'downloads'
        
        //Notificaciones en después de cargar Book
        $notification = "El libro \"$book->title\" fue creado con éxito." ;
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
        $authors = Author::all();
        
        $authorsArray = $book->authors->toArray();
        $authorsArray = array_map(function($a)
        {
            return $a['name'];
        }, $authorsArray);
        $book->authorsArray = $authorsArray;

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

        return view('content.books.create-edit', compact('book','authorsName', 'topicsName', 'languages', 'countries', 'authors'));
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

        $datesBook = $request->except('downloadable','coverImage','backCoverImage','extraimages','audiobook', '_token', '_method');
        /* $datesBook = $request->validated()->except('downloadable','coverImage','backCoverImage','extraimages','audiobook'); //Esto sería se creo un request aparte para las validaciones */

        //Agunas cosas necesarias para el almacenamiennto de los archivos
            $datesBook['slug'] = Str::slug($datesBook['title']);
            $destination_path = 'content/books/'.$datesBook['slug'];
            $disk = 'public';
        //

        
        $request['originalSynopsis'] = $request->synopsis;
        $request['synopsis'] = str_replace("\r\n"," ",$request->synopsis);
        
        /** En el caso de que haga las validaciones, hace lo de 'store' para la synopsis */
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
            'isbn' => ['nullable','string','max:255', Rule::unique('books')->ignore($book->id)],
            'downloadable' => 'file|mimes:pdf,doc',
            'url' => 'nullable|url',
            'coverImage' => 'file|mimes:jpg,png,jpeg|dimensions:min_width=600,min_height=800,max_width=1800,max_height=2300',
            'extraimages' => 'array',
            'extraimages.*' => 'file|mimes:jpg,png,jpeg|between:40,3000',
            'backCoverImage' => 'file|mimes:jpg,png,jpeg|between:40,4000',
            'audioBook' => 'nullable|file|mimes:mp3,wma,aac',
        ]);

        $datesBook['slug'] = Str::slug($datesBook['title']);
        
        if($book->title != $datesBook['title'] and $book->slug != $datesBook['slug'])
        {
            
            if ( Storage::rename("public/content/books/$book->slug", "public/content/books/".$datesBook['slug']) ) 
            {
                $datesBook['coverImage'] = Str::replaceFirst($book->slug, $datesBook['slug'], $book->coverImage);
                
                ($book->backCoverImage) ? $datesBook['backCoverImage'] = Str::replaceFirst($book->slug, $datesBook['slug'], $book->backCoverImage) : '';
                ($book->downloadable) ? $datesBook['downloadable'] = Str::replaceFirst($book->slug, $datesBook['slug'], $book->downloadable) : '';
                ($book->audiobook) ? $datesBook['audiobook'] = Str::replaceFirst($book->slug, $datesBook['slug'], $book->audiobook) : '';

                if($book->extraImages)
                {
                    foreach ($book->extraImages as $extraImage)
                    {
                        $extraImage->update([
                            'image' => Str::replaceFirst($book->slug, $datesBook['slug'], $extraImage->image),
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
            /** Replicar la parte de las notificaciones y los 'if' por cada cambio detectado y también ver la posibilidad de que no haga un update si nada a cambiado (si es posibli también hacer que no pueda hacerse un submit si no hubo un cambio y se agrego algo, como nuevos archivos)*/
            if(!Storage::exists('public/'.$book->coverImage) or Storage::delete('public/'.$book->coverImage))
            {
                $image_name = Str::slug($request->file('coverImage')->getClientOriginalName());
                $extension = $request->file('coverImage')->extension();
                $new_image_name = $image_name.'.'.$extension;
                $datesBook['coverImage'] = $request->file('coverImage')->storeAs($destination_path, $new_image_name, $disk);
                
                ($datesBook['coverImage']) ? $notifications['coverImage'] = "La nueva imagen de Tapa se a guardado con éxito" : $notifications['coverImage'] = 'No se puedo guardar la nueva Imagen de Tapa';
            }
            else
            {
                $notifications['coverImage'] = "No se pudo eliminar la antarior Imagen de Tapa"; //Acá puedo mandar un mail con el error al programador
            }
        }

        if($request->hasFile('backCoverImage'))
        {
            Storage::delete('public/'.$book->backCoverImage);

            $image_name = Str::slug($request->file('backCoverImage')->getClientOriginalName());
            $extension = $request->file('backCoverImage')->extension();
            $new_image_name = $image_name.'.'.$extension;
            $datesBook['backCoverImage'] = $request->file('backCoverImage')->storeAs($destination_path, $new_image_name, $disk);
        }

        if($request->hasFile('audioBook'))
        {
            Storage::delete('public/'.$book->audioBook);

            $audioBook_name = Str::slug($request->file('audioBook')->getClientOriginalName());
            $extension = $request->file('audioBook')->extension();
            $new_image_name = $image_name.'.'.$extension;
            $datesBook['audioBook'] = $request->file('audioBook')->storeAs($destination_path, $audioBook_name, $disk);

            $datesBook['format'] = $request->file('audioBook')->extension();
        }

        if($request->hasFile('downloadable'))
        {
            Storage::delete('public/'.$book->downloadable);

            $image_name = Str::slug($request->file('downloadable')->getClientOriginalName());
            $extension = $request->file('downloadable')->extension();
            $new_image_name = $image_name.'.'.$extension;
            $datesBook['downloadable'] = $request->file('downloadable')->storeAs($destination_path, $new_image_name, $disk);
        }

        
        
        $book->update($datesBook);

        if (isset($request->extraImages)) {
            
            foreach ($book->extraImages as $previousImage) {
                Storage::delete('public/'.$previousImage->image);
            }

            $extraImages = $request->extraImages;
            
            foreach ($extraImages as $image) 
            {
                //Guardar las nuevas imagenes
                    
                    $image_name = Str::slug($image->getClientOriginalName());
                    $extension = $image->extension();
                    $new_image_name = $image_name.'.'.$extension;
                    $path = $image->storeAs($destination_path, $new_image_name, $disk);

                    $book->extraImages()->create([
                        'image' => $path,
                    ]);
            }
        }

        

        

        $notification = "'$book->title' fue actualizado con éxito";
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
        // Y Eliminar Audiolibro //Eliminar las imagenes extras (todo del servidor) 
        // Y Eliminar hasta la carpeta (directorio) del libro
            Storage::deleteDirectory('public/content/books/'.$book->slug);
        
        //Eliminar su Contador
            $book->counter()->delete();
        //
        $titleOfDeletedBook = $book->title;
        $book->delete();
        
        $notification = "Se ha eliminado \"$titleOfDeletedBook\" y todo lo que contenía.";
        
        
        $request->session()->flash('notification', $notification);

        return redirect()->back();
    }
}
