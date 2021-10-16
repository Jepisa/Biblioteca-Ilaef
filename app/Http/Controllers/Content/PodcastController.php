<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Podcast\StorePodcastRequest;
use Illuminate\Support\Str;
use App\Models\Author;
use App\Models\Country;
use App\Models\Language;
use App\Models\Podcast;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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
     * @param  \Illuminate\Http\Requests\Podcast\StorePodcastRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePodcastRequest $request)
    {   

        
        $validated = $request->validated();

        //Agunas cosas necesarias
            $code = Str::random(8);
            $slugOfPodcast = Str::slug($validated['title']).'-'.$code;
            $destination_path = 'content/podcasts/'.$slugOfPodcast;
            $disk = 'public';
        //
        if($request->hasFile('coverImage')) $pathCoverImage = $request->file('coverImage')->store($destination_path, $disk);

        if($request->hasFile('backCoverImage')) $pathBackCoverImage = $request->file('backCoverImage')->store($destination_path, $disk);

        if($request->hasFile('downloadable'))
        {
            $pathDownloadable = $request->file('downloadable')->store($destination_path, $disk);
            if($pathDownloadable) $extension_downloadable = $request->file('downloadable')->extension();    
        }

        if($request->hasFile('audiopodcast')) $pathAudiopodcast = $request->file('audiopodcast')->store($destination_path, $disk);

        if( (isset($pathCoverImage) and !$pathCoverImage) or (isset($pathBackCoverImage) and !$pathBackCoverImage) or (isset($pathDownloadable) and !$pathDownloadable) or (isset($pathAudiopodcast) and !$pathAudiopodcast) ){
            
            Storage::deleteDirectory($disk . '/' . $destination_path);
            //Notificaciones después de error al guardar achivos en el servidor
            $titleNotification = __('general.error.notification.saveFiles.title');
            $notification = __('general.error.notification.saveFiles.body', ['content' => __('general.content.podcast')]);
            $request->session()->flash('titleNotification', $titleNotification);
            $request->session()->flash('notification', $notification);
            return redirect()->back();
        }

        //Crea Podcast en BD
        $podcast = Podcast::create([
            'title'             => $validated['title'],
            'slug'              => $slugOfPodcast,
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
            'coverImage'        => isset($pathCoverImage) ? $pathCoverImage : 'content/podcasts/default',
            'backCoverImage'    => isset($pathBackCoverImage) ? $pathBackCoverImage : null,
            'audiopodcast'         => isset($pathAudiopodcast) ? $pathAudiopodcast : null,
            'format'            => isset($extension_downloadable) ? $extension_downloadable : null,
        ]);

        // if(!$podcast) Log::channel('slack')->critical("Problm!\n We have a problem for save a Podcast!!!\nSaludos, Jean Piere");//This is for to send a message to Slack

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
                $podcast->extraImages()->create([
                    'image' => $path,
                ]);
            }
            if($errorImages > 0){
                $request->session()->flash('errorExtraImages', __('general.error.notification.saveFiles.errorExtraImages', ['qty' => $errorImages]));
            }
        } 

        //Guardar y asignar Authors - Topics existentes
        $podcast->authors()->sync($validated['existAuthors']);
        $podcast->topics()->sync($validated['existTopics']);

        //Guardar nuevos Authors - Topics
        if (!empty($validated['newAuthors'])) {
            $newAuthors = [];

            foreach ($validated['newAuthors'] as $newAuthor) {
                $newAuthors[] = Author::firstOrCreate([
                    'name' => $newAuthor,
                ])->id;
            }

            $podcast->authors()->syncWithoutDetaching($newAuthors);
        }

        if (!empty($validated['newTopics'])) {
            $newTopics = [];

            foreach ($validated['newTopics'] as $newTopic) {
                $newTopics[] = Topic::firstOrCreate([
                    'name' => $newTopic,
                ])->id;
            }

            $podcast->topics()->syncWithoutDetaching($newTopics);
        }

        //Se crea el contador de views del Podcast
        $podcast->counter()->create(['views' => 0 ]);//A la table del contador le puedo poner más columnas (a parte de 'views'), como 'favorites', 'downloads'
        
        //Notificaciones después de crear un Podcast
        $titleNotification = __('podcasts.create.notification.title');
        $notification = __('podcasts.create.notification.body', ['title' => $podcast->title]);
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
        $podcast = Podcast::where('slug', '=', $slug)->firstOrFail();
        //Contar las visitas a cada libro
        $podcast->counter()->update([
                'views' => $podcast->counter->views + 1,
            ],[
                'timestamps' => false
            ]);
        $podcast->counter->views++;
        return view('content.podcasts.show', compact('podcast'));
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
        $topics = Topic::all();
        $languages = Language::all();
        $countries = Country::all();
        
        $podcast->authors_id = array_column($podcast->authors->toArray(), 'id');
        $podcast->topics_id = array_column($podcast->topics->toArray(), 'id');


        return view('content.podcasts.edit', compact('podcast', 'authors', 'topics', 'languages', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\Podcast\UpdatePodcastRequest  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePodcastRequest $request, $slug)
    {
        $podcast = Podcast::where('slug', '=', $slug)->firstOrFail();

        $datesPodcast = $request->except('downloadable','coverImage','backCoverImage','extraimages','audiopodcast', '_token', '_method');
        $datesPodcast['synopsis'] = $datesPodcast['synopsis-original'];

        /* $datesPodcast = $request->validated()->except('downloadable','coverImage','backCoverImage','extraimages','audiopodcast'); //Esto sería se creo un request aparte para las validaciones */

        //Agunas cosas necesarias para el almacenamiennto de los archivos
            $code = Str::random(8);
            $datesPodcast['slug'] =  ($podcast->title != $datesPodcast['title']) ? Str::slug($datesPodcast['title']).'-'.$code : $podcast->slug;
            $destination_path = 'content/podcasts/'.$datesPodcast['slug'];
            $disk = 'public';
        //

        
        if($podcast->title != $datesPodcast['title'])
        { 
            if ( Storage::rename("public/content/podcasts/$podcast->slug", "public/content/podcasts/".$datesPodcast['slug']) ) 
            {
                $datesPodcast['coverImage'] = Str::replaceFirst($podcast->slug, $datesPodcast['slug'], $podcast->coverImage);
                
                ($podcast->backCoverImage) ? $datesPodcast['backCoverImage'] = Str::replaceFirst($podcast->slug, $datesPodcast['slug'], $podcast->backCoverImage) : '';
                ($podcast->downloadable) ? $datesPodcast['downloadable'] = Str::replaceFirst($podcast->slug, $datesPodcast['slug'], $podcast->downloadable) : '';
                ($podcast->audiopodcast) ? $datesPodcast['audiopodcast'] = Str::replaceFirst($podcast->slug, $datesPodcast['slug'], $podcast->audiopodcast) : '';

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

        $a = $datesPodcast['existAuthors'];
        sort($a);
        $b = array_column($podcast->authors->toArray(), 'id');
        sort($b);

        if(!empty($datesPodcast['existAuthors']) and $a != $b)
        {
            $podcast->authors()->sync($datesPodcast['existAuthors']);
        }
        if(!empty($datesPodcast['newAuthors']))
        {
            $newAuthors = [];

            foreach ($datesPodcast['newAuthors'] as $newAuthor) {
                $newAuthors[] = Author::firstOrCreate([
                    'name' => $newAuthor,
                ])->id;
            }

            $podcast->authors()->syncWithoutDetaching($newAuthors);
        }
        
        
        if(!empty($datesPodcast['existTopics']))
        {
            $podcast->topics()->sync($datesPodcast['existTopics']);
        }
        if(!empty($datesPodcast['newTopics']))
        {
            $newTopics = [];

            foreach ($datesPodcast['newTopics'] as $newTopic) {
                $newTopics[] = Topic::firstOrCreate([
                    'name' => $newTopic,
                ])->id;
            }

            $podcast->topics()->syncWithoutDetaching($newTopics);
        }

        

        if($request->hasFile('coverImage'))
        {
            if( $podcast->title != $datesPodcast['title'] and Storage::delete('public/'.$datesPodcast['coverImage']))
            {
                $datesPodcast['coverImage'] = $request->file('coverImage')->store($destination_path, $disk);
            }
            elseif(Storage::delete('public/'.$podcast->coverImage))
            {
                $datesPodcast['coverImage'] = $request->file('coverImage')->store($destination_path, $disk);
                
            }else{
                Log::error("No se pudo eliminar la anterior Imagen de Tapa");
            }
        }

        if($request->hasFile('backCoverImage'))
        {
            if( $podcast->title != $datesPodcast['title'] and ($podcast->backCoverImage == null or Storage::delete('public/'.$datesPodcast['backCoverImage'])) )
            {
                $datesPodcast['backCoverImage'] = $request->file('backCoverImage')->store($destination_path, $disk);
            }
            elseif($podcast->backCoverImage == null or Storage::delete('public/'.$podcast->backCoverImage))
            {
                $datesPodcast['backCoverImage'] = $request->file('backCoverImage')->store($destination_path, $disk);
                
            }else{
                Log::error("No se pudo eliminar la anterior Imagen de Contra Tapa");
            }
        }

        if($request->hasFile('downloadable'))
        {
            if( $podcast->title != $datesPodcast['title'] and ($podcast->downloadable == null or Storage::delete('public/'.$datesPodcast['downloadable'])) )
            {
                $datesPodcast['downloadable'] = $request->file('downloadable')->store($destination_path, $disk);
            }
            elseif($podcast->downloadable == null or Storage::delete('public/'.$podcast->downloadable))
            {
                $datesPodcast['downloadable'] = $request->file('downloadable')->store($destination_path, $disk);
            }else{
                Log::error("No se pudo eliminar el downloadable anterior");
            }
            if($datesPodcast['downloadable']) $datesPodcast['format'] = $request->file('downloadable')->extension();
        }

        if($request->hasFile('audiopodcast'))
        {
            if( $podcast->title != $datesPodcast['title'] and ($podcast->audiopodcast == null or Storage::delete('public/'.$datesPodcast['audiopodcast'])) )
            {
                $datesPodcast['audiopodcast'] = $request->file('audiopodcast')->store($destination_path, $disk);
            }
            elseif($podcast->audiopodcast == null or Storage::delete('public/'.$podcast->audiopodcast))
            {
                $datesPodcast['audiopodcast'] = $request->file('audiopodcast')->store($destination_path, $disk);                
            }else{
                Log::error("No se pudo eliminar el anterior audiopodcast");
            }

        }

        

        if( (isset($datesPodcast['coverImage']) and !$datesPodcast['coverImage']) or (isset($datesPodcast['backCoverImage']) and !$datesPodcast['backCoverImage']) or (isset($datesPodcast['downloadable']) and !$datesPodcast['downloadable']) or (isset($datesPodcast['audiopodcast']) and !$datesPodcast['audiopodcast']) ){
            
            Storage::deleteDirectory($disk . '/' . $destination_path);
            //Notificaciones después de error al guardar achivos en el servidor
            $titleNotification = __('general.error.notification.saveFiles.title');
            $notification = __('general.error.notification.saveFiles.body', ['content' => __('general.content.podcast')]);
            $request->session()->flash('titleNotification', $titleNotification);
            $request->session()->flash('notification', $notification);
            return redirect()->back();
        }
        
        $podcast->update($datesPodcast);

        if (isset($request->extraImages)) {
            
            foreach ($podcast->extraImages as $previousImage) {
                Storage::delete('public/'.$previousImage->image);
            }
            $podcast->extraImages()->delete();
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
                    
                    $podcast->extraImages()->create([
                        'image' => $path,
                    ]);
            }

            if($errorImages > 0){
                $request->session()->flash('errorExtraImages', __('general.error.notification.saveFiles.errorExtraImages', ['qty' => $errorImages]));
            }
        }


        //Notificaciones después de editar un Podcast
        $titleNotification = __('podcasts.edit.notification.title');
        $notification = __('podcasts.edit.notification.body', ['title' => $podcast->title]);
        $request->session()->flash('titleNotification', $titleNotification);
        $request->session()->flash('notification', $notification);

        return redirect()->route('podcast.edit', ['slug' => $podcast->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $slug)
    {
        $podcast = Podcast::where('slug', '=', $slug)->firstOrFail();
        
        //Eliminar la vinculación en la bd con los autores y los temas
            $podcast->authors()->detach();
            $podcast->topics()->detach();

        //Eliminar la vinculación en la bd con las Imagenes extras
            $podcast->extraImages()->delete();

        //Eliminar Archivo descargable  //Eliminar Imagen de Tapa //Eliminar Imagen de Contratapa 
        // Y Eliminar Audiolibro //Eliminar las imagenes extras (todo del servidor) 
        // Y Eliminar hasta la carpeta (directorio) del libro
            Storage::deleteDirectory('public/content/podcasts/'.$podcast->slug);
        
        //Eliminar su Contador
            $podcast->counter()->delete();
        //
        $titleOfDeletedPodcast = $podcast->title;
        $podcast->delete();
        
        $titleNotification = __('podcasts.delete.notification.title');
        $notification = __('podcasts.delete.notification.body', ['title' => $titleOfDeletedPodcast]);
        $request->session()->flash('titleNotification', $titleNotification);
        $request->session()->flash('notification', $notification);

        return redirect()->back();
    }
}
