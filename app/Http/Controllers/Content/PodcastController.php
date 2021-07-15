<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Books\StoreBookRequest;
use Illuminate\Support\Str;
use App\Models\Author;
use App\Models\Country;
use App\Models\Language;
use App\Models\Podcast;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PodcastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $podcasts = Podcast::orderBy('created_at', 'desc')->paginate(10);

        return view('content.podcasts.index', compact('podcasts'));
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

        return view('content.podcasts.create-edit', compact('authors', 'topics', 'languages', 'countries'));
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
            $slugOfPodcast = Str::slug($validated['title']);
            $destination_path = 'content/podcasts/'.$slugOfPodcast;
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

        if($request->hasFile('audioPodcast'))
        {
            $audioPodcast_name = Str::slug($request->file('audioPodcast')->getClientOriginalName());
            $extension = $request->file('audioPodcast')->extension();
            $new_image_name = $image_name.'.'.$extension;
            $pathAudioPodcast = $request->file('audioPodcast')->storeAs($destination_path, $audioPodcast_name, $disk);

            $extension_audioPodcast = $request->file('audioPodcast')->extension();
        }

        if($request->hasFile('downloadable'))
        {
            $image_name = Str::slug($request->file('downloadable')->getClientOriginalName());
            $extension = $request->file('downloadable')->extension();
            $new_image_name = $image_name.'.'.$extension;
            $pathDownloadable = $request->file('downloadable')->storeAs($destination_path, $new_image_name, $disk);
        }

        //Crea Book en BD
        $podcast = Podcast::create([
            'title' => $validated['title'],
            'slug' => $slugOfPodcast,
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
            'coverImage' => isset($pathCoverImage) ? $pathCoverImage : 'public/content/podcasts/default', //Aún no existe una imagen por default
            'backCoverImage' => isset($pathBackCoverImage) ? $pathBackCoverImage : 'public/content/podcasts/default', //Aún no existe una imagen por default
            'audioPodcast' => isset($pathAudioPodcast) ? $pathAudioPodcast : null,
            'format' => isset($extension_audioPodcast) ? $extension_audioPodcast : null,
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

                    $podcast->extraImages()->create([
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

            $authorsOfThePodcast = [];
        
            foreach ($authors as $authorName) {
                $savedAuthor = Author::where('name', '=', $authorName)->first();
                if($savedAuthor){
                    if($savedAuthor->name == $authorName)
                    {
                        $existAuthors[] = $authorName;

                        $authorsOfThePodcast[] = $savedAuthor->id;
                    }
                }
                else 
                {
                    $createdAuthor = Author::create([
                        'name' => trim($authorName),
                    ]);

                    $newAuthors[] = $createdAuthor->name;

                    $createdAuthors[] = $createdAuthor->name;

                    $authorsOfThePodcast[] = $createdAuthor->id;

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

            $topicsOfThePodcast = [];

        
            foreach ($topics as $topicName) {
                $savedTopic = Topic::where('name', '=', $topicName)->first();
                
                if($savedTopic)
                {
                    if($savedTopic->name == $topicName)
                    {
                        $existTopics[] = $topicName;
                        $topicsOfThePodcast[] = $savedTopic->id;
                    }
                }
                else 
                {
                    $createdTopic = Topic::create([
                        'name' => $topicName,
                    ]);

                    $newTopics[] = $createdTopic->name;

                    $createdTopics[] = $createdTopic->name;

                    $topicsOfThePodcast[] = $createdTopic->id;

                }
            }

            $existTopics = implode(", ", $existTopics);
            $newTopics = implode(", ", $newTopics);

            $notificationTopics = "Estos autores se crearon exitosamente: $newTopics. \r\n Estos ya estaban en nuestra base de datos: $existTopics" ;
            $request->session()->flash('notificationTopics', $notificationTopics);
        // ----

        $podcast->authors()->sync($authorsOfThePodcast);
        $podcast->topics()->sync($topicsOfThePodcast);
        
        //Se crea el contador de views del Book
        $podcast->counter()->create(['views' => 0 ]);//A la table del contador le puedo poner más columnas (a parte de 'views'), como 'favorites', 'downloads'
        
        //Notificaciones en después de cargar Book
        $notification = "El podcast \"$podcast->title\" fue creado con éxito." ;
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
        $podcast = Podcast::where('slug', '=', $slug)->firstOrFail();
        //Contar las visitas a cada podcast
        $podcast->counter()->update([
            'views' => $podcast->counter->views + 1,
            ]);
        
        return view('podcast.show', compact('podcast'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $podcast = Podcast::where('slug', '=', $slug)->firstOrFail();
        $authors = Author::all();
        
        $authorsArray = $podcast->authors->toArray();
        $authorsArray = array_map(function($a)
        {
            return $a['name'];
        }, $authorsArray);
        $podcast->authorsArray = $authorsArray;

        $authorsName = [];

        foreach ($podcast->authors as $author) {
            $authorsName[] = $author->name;
        }
        $authorsName = implode(", ", $authorsName);


        $topicsName = [];
        foreach ($podcast->topics as $topic) {
            $topicsName[] = $topic->name;
        }
        $topicsName = implode(", ", $topicsName);

        $topics = Topic::all();
        $languages = Language::all();
        $countries = Country::all();

        return view('content.podcasts.create-edit', compact('podcast','authorsName', 'topicsName', 'languages', 'countries', 'authors'));
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

        $podcast = Podcast::where('slug', '=', $slug)->firstOrFail();

        $datesPodcast = $request->except('downloadable','coverImage','backCoverImage','extraimages','audioPodcast', '_token', '_method');
        /* $datesPodcast = $request->validated()->except('downloadable','coverImage','backCoverImage','extraimages','audioPodcast'); //Esto sería se creo un request aparte para las validaciones */

        //Agunas cosas necesarias para el almacenamiennto de los archivos
            $datesPodcast['slug'] = Str::slug($datesPodcast['title']);
            $destination_path = 'content/podcasts/'.$datesPodcast['slug'];
            $disk = 'public';
        //

        
        $request['originalSynopsis'] = $request->synopsis;
        $request['synopsis'] = str_replace("\r\n"," ",$request->synopsis);
        
        /** En el caso de que haga las validaciones, hace lo de 'store' para la synopsis */
        $validated = $request->validate([
            'title' => [Rule::unique('podcasts')->ignore($podcast->id)],
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
            'isbn' => ['nullable','string','max:255', Rule::unique('podcasts')->ignore($podcast->id)],
            'downloadable' => 'file|mimes:pdf,doc',
            'url' => 'nullable|url',
            'coverImage' => 'file|mimes:jpg,png,jpeg|dimensions:min_width=600,min_height=800,max_width=1800,max_height=2300',
            'extraimages' => 'array',
            'extraimages.*' => 'file|mimes:jpg,png,jpeg|between:40,3000',
            'backCoverImage' => 'file|mimes:jpg,png,jpeg|between:40,4000',
            'audioPodcast' => 'nullable|file|mimes:mp3,wma,aac',
        ]);

        $datesPodcast['slug'] = Str::slug($datesPodcast['title']);
        
        if($podcast->title != $datesPodcast['title'] and $podcast->slug != $datesPodcast['slug'])
        { 
            if ( Storage::rename("public/content/podcasts/$podcast->slug", "public/content/podcasts/".$datesPodcast['slug']) ) 
            {
                $datesPodcast['coverImage'] = Str::replaceFirst($podcast->slug, $datesPodcast['slug'], $podcast->coverImage);
                
                ($podcast->backCoverImage) ? $datesPodcast['backCoverImage'] = Str::replaceFirst($podcast->slug, $datesPodcast['slug'], $podcast->backCoverImage) : '';
                ($podcast->downloadable) ? $datesPodcast['downloadable'] = Str::replaceFirst($podcast->slug, $datesPodcast['slug'], $podcast->downloadable) : '';
                ($podcast->audiobook) ? $datesPodcast['audioPodcast'] = Str::replaceFirst($podcast->slug, $datesPodcast['slug'], $podcast->audiobook) : '';

                if($podcast->extraImages)
                {
                    foreach ($podcast->extraImages as $extraImage)
                    {
                        $extraImage->update([
                            'image' => Str::replaceFirst($podcast->slug, $datesPodcast['slug'], $extraImage->image),
                        ]); 
                    }                
                }
            }
        }

        if(isset($datesPodcast['authorsName']))
        {
            $authorsName = [];
            foreach ($podcast->authors as $author) {
                $authorsName[] = $author->name;
            }
            $authorsName = implode(", ", $authorsName);

            $arrayAuthorsName = explode(',', $datesPodcast['authorsName']);

            $datesPodcast['authorsName'] = [];
            foreach ($arrayAuthorsName as $authorName) {
                $datesPodcast['authorsName'][] = trim($authorName);
            }

            $datesPodcast['authorsName'] = implode(", ", $datesPodcast['authorsName']);

            if($authorsName != $datesPodcast['authorsName'])
            {
            //Authors
                $authors = explode(",", $datesPodcast['authorsName']);

                $existAuthors = [];
                $newAuthors = [];

                $createdAuthors = [];

                $authorsOfThePodcast = [];

            
                foreach ($authors as $authorName) {
                    $savedAuthor = Author::where('name', '=', trim($authorName))->first();
                    if($savedAuthor){
                        if(Str::lower($savedAuthor->name) == Str::lower(trim($authorName)))
                        {
                            $existAuthors[] = $authorName;

                            $authorsOfThePodcast[] = $savedAuthor->id;
                        }
                    }
                    else 
                    {
                        $createdAuthor = Author::create([
                            'name' => trim($authorName),
                        ]);

                        $newAuthors[] = $createdAuthor->name;

                        $createdAuthors[] = $createdAuthor->name;

                        $authorsOfThePodcast[] = $createdAuthor->id;

                    }
                }

                $existAuthors = implode(", ", $existAuthors);
                $newAuthors = implode(", ", $newAuthors);

                $podcast->authors()->sync($authorsOfThePodcast);

                $notificationAuthors = "Estos autores se crearon exitosamente: $newAuthors. \r\n Estos ya estaban en nuestra base de datos: $existAuthors" ;
                $request->session()->flash('notificationAuthors', $notificationAuthors);
            //
            }
        }
        
        if(isset($datesPodcast['topicsName']))
        {
            $topicsName = [];
            foreach ($podcast->topics as $topic) {
                $topicsName[] = $topic->name;
            }
            $topicsName = implode(", ", $topicsName);

            $arrayTopicsName = explode(',', $datesPodcast['topicsName']);

            $datesPodcast['topicsName'] = [];
            foreach ($arrayTopicsName as $topicName) {
                $datesPodcast['topicsName'][] = trim($topicName);
            }

            $datesPodcast['topicsName'] = implode(", ", $datesPodcast['topicsName']);

            if($topicsName != $datesPodcast['topicsName'])
            {
                //Topics
                    $topics = explode(",", $datesPodcast['topicsName']);

                    $existTopics = [];
                    $newTopics = [];

                    $createdTopics = [];

                    $topicsOfThePodcast = [];

                
                    foreach ($topics as $topicName) {
                        $savedTopic = Topic::where('name', '=', trim($topicName))->first();
                        
                        if($savedTopic)
                        {
                            if(Str::lower($savedTopic->name) == Str::lower(trim($topicName)))
                            {
                                $existTopics[] = $topicName;
                                $topicsOfThePodcast[] = $savedTopic->id;
                            }
                        }
                        else 
                        {
                            $createdTopic = Topic::create([
                                'name' => trim($topicName),
                            ]);

                            $newTopics[] = $createdTopic->name;

                            $createdTopics[] = $createdTopic->name;

                            $topicsOfThePodcast[] = $createdTopic->id;

                        }
                    }

                    $existTopics = implode(", ", $existTopics);
                    $newTopics = implode(", ", $newTopics);

                    $podcast->topics()->sync($topicsOfThePodcast);


                    $notificationTopics = "Estos autores se crearon exitosamente: $newTopics. \r\n Estos ya estaban en nuestra base de datos: $existTopics" ;
                    $request->session()->flash('notificationTopics', $notificationTopics);
                // ----
            }
        }

        

        if($request->hasFile('coverImage'))
        {
            /** Replicar la parte de las notificaciones y los 'if' por cada cambio detectado y también ver la posibilidad de que no haga un update si nada a cambiado (si es posibli también hacer que no pueda hacerse un submit si no hubo un cambio y se agrego algo, como nuevos archivos)*/
            if(!Storage::exists('public/'.$podcast->coverImage) or Storage::delete('public/'.$podcast->coverImage))
            {
                $image_name = Str::slug($request->file('coverImage')->getClientOriginalName());
                $extension = $request->file('coverImage')->extension();
                $new_image_name = $image_name.'.'.$extension;
                $datesPodcast['coverImage'] = $request->file('coverImage')->storeAs($destination_path, $new_image_name, $disk);
                
                ($datesPodcast['coverImage']) ? $notifications['coverImage'] = "La nueva imagen de Tapa se a guardado con éxito" : $notifications['coverImage'] = 'No se puedo guardar la nueva Imagen de Tapa';
            }
            else
            {
                $notifications['coverImage'] = "No se pudo eliminar la antarior Imagen de Tapa"; //Acá puedo mandar un mail con el error al programador
            }
        }

        if($request->hasFile('backCoverImage'))
        {
            Storage::delete('public/'.$podcast->backCoverImage);

            $image_name = Str::slug($request->file('backCoverImage')->getClientOriginalName());
            $extension = $request->file('backCoverImage')->extension();
            $new_image_name = $image_name.'.'.$extension;
            $datesPodcast['backCoverImage'] = $request->file('backCoverImage')->storeAs($destination_path, $new_image_name, $disk);
        }

        if($request->hasFile('audioPodcast'))
        {
            Storage::delete('public/'.$podcast->audioBook);

            $audioPodcast_name = Str::slug($request->file('audioPodcast')->getClientOriginalName());
            $extension = $request->file('audioPodcast')->extension();
            $new_image_name = $audioPodcast_name.'.'.$extension;
            $datesPodcast['audioPodcast'] = $request->file('audioPodcast')->storeAs($destination_path, $audioPodcast_name, $disk);

            $datesPodcast['format'] = $request->file('audioPodcast')->extension();
        }

        if($request->hasFile('downloadable'))
        {
            Storage::delete('public/'.$podcast->downloadable);

            $image_name = Str::slug($request->file('downloadable')->getClientOriginalName());
            $extension = $request->file('downloadable')->extension();
            $new_image_name = $image_name.'.'.$extension;
            $datesPodcast['downloadable'] = $request->file('downloadable')->storeAs($destination_path, $new_image_name, $disk);
        }

        
        
        $podcast->update($datesPodcast);

        if (isset($request->extraImages)) {
            
            foreach ($podcast->extraImages as $previousImage) {
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

                    $podcast->extraImages()->create([
                        'image' => $path,
                    ]);
            }
        }

        

        

        $notification = "'$podcast->title' fue actualizado con éxito";
        $request->session()->flash('notification', $notification);

        return redirect()->route('book.edit', ['slug' => $podcast->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $slug)
    {
        $book = Podcast::where('slug', '=', $slug)->firstOrFail();
        
        //Eliminar la vinculación en la bd con los autores y los temas
            $book->authors()->detach();
            $book->topics()->detach();

        //Eliminar la vinculación en la bd con las Imagenes extras
            $book->extraImages()->delete();

        //Eliminar Archivo descargable  //Eliminar Imagen de Tapa //Eliminar Imagen de Contratapa 
        // Y Eliminar Audiopodcast //Eliminar las imagenes extras (todo del servidor) 
        // Y Eliminar hasta la carpeta (directorio) del podcast
            Storage::deleteDirectory('public/content/podcasts/'.$book->slug);
        
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
