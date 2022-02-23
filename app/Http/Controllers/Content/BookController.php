<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\Books\StoreBookRequest;
use App\Http\Requests\Content\Books\UpdateBookRequest;
use Illuminate\Support\Str;
use App\Models\Author;
use App\Models\Book;
use App\Models\Country;
use App\Models\Language;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

        //Agunas cosas necesarias
            $code = Str::random(8);
            $slugOfBook = Str::slug($validated['title']).'-'.$code;
            $destination_path = 'content/books/'.$slugOfBook;
            $disk = 'public';
        //
        if($request->hasFile('coverImage')) $pathCoverImage = $request->file('coverImage')->store($destination_path, $disk);

        if($request->hasFile('backCoverImage')) $pathBackCoverImage = $request->file('backCoverImage')->store($destination_path, $disk);

        if($request->hasFile('downloadable'))
        {
            $pathDownloadable = $request->file('downloadable')->store($destination_path, $disk);
            if($pathDownloadable) $extension_downloadable = $request->file('downloadable')->extension();    
        }

        if($request->hasFile('audioBook')) $pathAudioBook = $request->file('audioBook')->store($destination_path, $disk);

        if( (isset($pathCoverImage) and !$pathCoverImage) or (isset($pathBackCoverImage) and !$pathBackCoverImage) or (isset($pathDownloadable) and !$pathDownloadable) or (isset($pathAudioBook) and !$pathAudioBook) ){
            
            Storage::deleteDirectory($disk . '/' . $destination_path);
            //Notificaciones después de error al guardar achivos en el servidor
            $titleNotification = __('general.error.notification.saveFiles.title');
            $notification = __('general.error.notification.saveFiles.body', ['content' => __('general.content.book')]);
            $request->session()->flash('titleNotification', $titleNotification);
            $request->session()->flash('notification', $notification);
            return redirect()->back();
        }

        //Crea Book en BD
        $book = Book::create([
            'title'             => $validated['title'],
            'slug'              => $slugOfBook,
            'synopsis'          => $request['synopsis-original'],
            'note'              => !empty($validated['note']) ? $validated['note'] : null,
            'year'              => !empty($validated['year']) ? $validated['year'] : null,
            'collection'        => !empty($validated['collection']) ? $validated['collection'] : null,
            'edition'           => !empty($validated['edition']) ? $validated['edition'] : null,
            'editorial'         => $validated['editorial'],
            'language_id'       => $validated['language_id'],
            'city'              => !empty($validated['city']) ? $validated['city'] : null,
            'country_id'        => $validated['country_id'],
            'pages'             => !empty($validated['pages']) ? $validated['pages'] : null,
            'isbn'              => !empty($validated['isbn']) ? $validated['isbn'] : null,
            'downloadable'      => isset($pathDownloadable) ? $pathDownloadable : null,
            'url'               => !empty($validated['url']) ? $validated['url'] : null,
            'coverImage'        => isset($pathCoverImage) ? $pathCoverImage : 'content/books/default.jpg',
            'backCoverImage'    => isset($pathBackCoverImage) ? $pathBackCoverImage : null,
            'audiobook'         => isset($pathAudioBook) ? $pathAudioBook : null,
            'format'            => isset($extension_downloadable) ? $extension_downloadable : null,
        ]);

        // if(!$book) Log::channel('slack')->critical("Problm!\n We have a problem for save a book!!!\nSaludos, Jean Piere");//This is for to send a message to Slack

        if (isset($request->extraImages)) {
            
            $extraImages = $request->extraImages;
            $errorImages = 0;
            foreach ($extraImages as $image) 
            {
                //Guardar las imagenes en el servidor                    
                $path = $image->store($destination_path, $disk);

                if(!$path){
                    $errorImages++;
                    continue;
                }
                $book->extraImages()->create([
                    'image' => $path,
                ]);
            }
            if($errorImages > 0){
                $request->session()->flash('errorExtraImages', __('general.error.notification.saveFiles.errorExtraImages', ['qty' => $errorImages]));
            }
        } 

        //Guardar y asignar Authors - Topics existentes
        $book->authors()->sync($validated['existAuthors']);
        $book->topics()->sync($validated['existTopics']);

        //Guardar nuevos Authors - Topics
        if (!empty($validated['newAuthors'])) {
            $newAuthors = [];

            foreach ($validated['newAuthors'] as $newAuthor) {
                $newAuthors[] = Author::firstOrCreate([
                    'name' => $newAuthor,
                ])->id;
            }

            $book->authors()->syncWithoutDetaching($newAuthors);
        }

        if (!empty($validated['newTopics'])) {
            $newTopics = [];

            foreach ($validated['newTopics'] as $newTopic) {
                $newTopics[] = Topic::firstOrCreate([
                    'name' => $newTopic,
                ])->id;
            }

            $book->topics()->syncWithoutDetaching($newTopics);
        }

        //Se crea el contador de views del Book
        $book->counter()->create(['views' => 0 ]);//A la table del contador le puedo poner más columnas (a parte de 'views'), como 'favorites', 'downloads'
        
        //Notificaciones después de crear un Book
        $titleNotification = __('books.create.notification.title');
        $notification = __('books.create.notification.body', ['title' => $book->title]);
        $request->session()->flash('titleNotification', $titleNotification);
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
        $content = Book::where('slug', '=', $slug)->firstOrFail();
        //Contar las visitas a cada libro
        $content->counter()->update([
                'views' => $content->counter->views + 1,
            ],[
                'timestamps' => false
            ]);
        $content->counter->views++;
        return view('results', compact('content'));
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
        $topics = Topic::all();
        $languages = Language::all();
        $countries = Country::all();
        
        $book->authors_id = array_column($book->authors->toArray(), 'id');
        $book->topics_id = array_column($book->topics->toArray(), 'id');


        return view('content.books.edit', compact('book', 'authors', 'topics', 'languages', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\Books\UpdateBookRequest  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, $slug)
    {
        $book = Book::where('slug', '=', $slug)->firstOrFail();

        $datesBook = $request->except('downloadable','coverImage','backCoverImage','extraimages','audiobook', '_token', '_method');
        $datesBook['synopsis'] = $datesBook['synopsis-original'];

        /* $datesBook = $request->validated()->except('downloadable','coverImage','backCoverImage','extraimages','audiobook'); //Esto sería se creo un request aparte para las validaciones */

        //Agunas cosas necesarias para el almacenamiennto de los archivos
            $code = Str::random(8);
            $datesBook['slug'] =  ($book->title != $datesBook['title']) ? Str::slug($datesBook['title']).'-'.$code : $book->slug;
            $destination_path = 'content/books/'.$datesBook['slug'];
            $disk = 'public';
        //

        
        if($book->title != $datesBook['title'])
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

        $a = $datesBook['existAuthors'];
        sort($a);
        $b = array_column($book->authors->toArray(), 'id');
        sort($b);

        if(!empty($datesBook['existAuthors']) and $a != $b)
        {
            $book->authors()->sync($datesBook['existAuthors']);
        }
        if(!empty($datesBook['newAuthors']))
        {
            $newAuthors = [];

            foreach ($datesBook['newAuthors'] as $newAuthor) {
                $newAuthors[] = Author::firstOrCreate([
                    'name' => $newAuthor,
                ])->id;
            }

            $book->authors()->syncWithoutDetaching($newAuthors);
        }
        
        
        if(!empty($datesBook['existTopics']))
        {
            $book->topics()->sync($datesBook['existTopics']);
        }
        if(!empty($datesBook['newTopics']))
        {
            $newTopics = [];

            foreach ($datesBook['newTopics'] as $newTopic) {
                $newTopics[] = Topic::firstOrCreate([
                    'name' => $newTopic,
                ])->id;
            }

            $book->topics()->syncWithoutDetaching($newTopics);
        }

        

        if($request->hasFile('coverImage'))
        {
            if( $book->title != $datesBook['title'] and Storage::delete('public/'.$datesBook['coverImage']))
            {
                $datesBook['coverImage'] = $request->file('coverImage')->store($destination_path, $disk);
            }
            elseif(Storage::delete('public/'.$book->coverImage))
            {
                $datesBook['coverImage'] = $request->file('coverImage')->store($destination_path, $disk);
                
            }else{
                Log::error("No se pudo eliminar la anterior Imagen de Tapa");
            }
        }

        if($request->hasFile('backCoverImage'))
        {
            if( $book->title != $datesBook['title'] and ($book->backCoverImage == null or Storage::delete('public/'.$datesBook['backCoverImage'])) )
            {
                $datesBook['backCoverImage'] = $request->file('backCoverImage')->store($destination_path, $disk);
            }
            elseif($book->backCoverImage == null or Storage::delete('public/'.$book->backCoverImage))
            {
                $datesBook['backCoverImage'] = $request->file('backCoverImage')->store($destination_path, $disk);
                
            }else{
                Log::error("No se pudo eliminar la anterior Imagen de Contra Tapa");
            }
        }

        if($request->hasFile('downloadable'))
        {
            if( $book->title != $datesBook['title'] and ($book->downloadable == null or Storage::delete('public/'.$datesBook['downloadable'])) )
            {
                $datesBook['downloadable'] = $request->file('downloadable')->store($destination_path, $disk);
            }
            elseif($book->downloadable == null or Storage::delete('public/'.$book->downloadable))
            {
                $datesBook['downloadable'] = $request->file('downloadable')->store($destination_path, $disk);
            }else{
                Log::error("No se pudo eliminar el downloadable anterior");
            }
            if($datesBook['downloadable']) $datesBook['format'] = $request->file('downloadable')->extension();
        }

        if($request->hasFile('audioBook'))
        {
            if( $book->title != $datesBook['title'] and ($book->audioBook == null or Storage::delete('public/'.$datesBook['audioBook'])) )
            {
                $datesBook['audioBook'] = $request->file('audioBook')->store($destination_path, $disk);
            }
            elseif($book->audioBook == null or Storage::delete('public/'.$book->audioBook))
            {
                $datesBook['audioBook'] = $request->file('audioBook')->store($destination_path, $disk);                
            }else{
                Log::error("No se pudo eliminar el anterior audiobook");
            }

        }

        

        if( (isset($datesBook['coverImage']) and !$datesBook['coverImage']) or (isset($datesBook['backCoverImage']) and !$datesBook['backCoverImage']) or (isset($datesBook['downloadable']) and !$datesBook['downloadable']) or (isset($datesBook['audioBook']) and !$datesBook['audioBook']) ){
            
            Storage::deleteDirectory($disk . '/' . $destination_path);
            //Notificaciones después de error al guardar achivos en el servidor
            $titleNotification = __('general.error.notification.saveFiles.title');
            $notification = __('general.error.notification.saveFiles.body', ['content' => __('general.content.book')]);
            $request->session()->flash('titleNotification', $titleNotification);
            $request->session()->flash('notification', $notification);
            return redirect()->back();
        }
        
        $book->update($datesBook);

        if (isset($request->extraImages)) {
            
            foreach ($book->extraImages as $previousImage) {
                Storage::delete('public/'.$previousImage->image);
            }
            $book->extraImages()->delete();
            $errorImages = 0;
            $extraImages = $request->extraImages;
            
            foreach ($extraImages as $image) 
            {
                //Guardar las nuevas imagenes
                    
                    $path = $image->store($destination_path, $disk);

                    if(!$path){
                        $errorImages++;
                        continue;
                    }
                    
                    $book->extraImages()->create([
                        'image' => $path,
                    ]);
            }

            if($errorImages > 0){
                $request->session()->flash('errorExtraImages', __('general.error.notification.saveFiles.errorExtraImages', ['qty' => $errorImages]));
            }
        }


        //Notificaciones después de editar un Book
        $titleNotification = __('books.edit.notification.title');
        $notification = __('books.edit.notification.body', ['title' => $book->title]);
        $request->session()->flash('titleNotification', $titleNotification);
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
        
        $titleNotification = __('books.delete.notification.title');
        $notification = __('books.delete.notification.body', ['title' => $titleOfDeletedBook]);
        $request->session()->flash('titleNotification', $titleNotification);
        $request->session()->flash('notification', $notification);

        return redirect()->back();
    }
}
