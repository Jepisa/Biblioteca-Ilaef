<?php

namespace App\Http\Controllers\content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\Ebooks\StoreEbookRequest;
use App\Http\Requests\Content\Ebooks\UpdateEbookRequest;
use Illuminate\Support\Str;
use App\Models\Author;
use App\Models\Ebook;
use App\Models\Country;
use App\Models\Language;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ebooks = Ebook::orderBy('created_at', 'desc')->paginate(10);

        return view('content.ebooks.index', compact('ebooks'));
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

        return view('content.ebooks.create', compact('authors', 'topics', 'languages', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\Ebooks\StoreEbookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEbookRequest $request)
    {
        
        $validated = $request->validated();

        //Agunas cosas necesarias
            $code = Str::random(8);
            $slugOfEbook = Str::slug($validated['title']).'-'.$code;
            $destination_path = 'content/ebooks/'.$slugOfEbook;
            $disk = 'public';
        //
        if($request->hasFile('coverImage')) $pathCoverImage = $request->file('coverImage')->store($destination_path, $disk);

        if($request->hasFile('backCoverImage')) $pathBackCoverImage = $request->file('backCoverImage')->store($destination_path, $disk);
        
        if($request->hasFile('downloadable'))
        {
            $pathDownloadable = $request->file('downloadable')->store($destination_path, $disk);

            if ($pathDownloadable) $extension_downloadable = $request->file('downloadable')->extension();
        }

        if((isset($pathCoverImage) and !$pathCoverImage) or (isset($pathBackCoverImage) and !$pathBackCoverImage) or (isset($pathDownloadable) and !$pathDownloadable)) {
            Storage::deleteDirectory($disk.'/'.$destination_path);

            //Notificaciones después de error al guardar archivos en el servidor
            $titleNotification = __('general.error.notification.saveFiles.title');
            $notification = __('general.error.notification.saveFiles.body', ['content' => __('general.content.ebook')]);
            $request->session()->flash('titleNotification', $titleNotification);
            $request->session()->flash('notification', $notification);
            return redirect()->back();
        }

        //Crea Ebook en BD
        $ebook = Ebook::create([
            'title'             => $validated['title'],
            'slug'              => $slugOfEbook,
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
            'coverImage'        => isset($pathCoverImage) ? $pathCoverImage : 'public/content/ebooks/default',
            'backCoverImage'    => isset($pathBackCoverImage) ? $pathBackCoverImage : null,
            'format'            => isset($extension_downloadable) ? $extension_downloadable : null,
        ]);

        // if(!$ebook) Log::channel('slack')->critical("Problm!\n We have a problem for save a ebook!!!\nSaludos, Jean Piere");//This is for to send a message to Slack

        if (isset($request->extraImages)) {
            
            $extraImages = $request->extraImages;
            $errorImages = 0;

            foreach ($extraImages as $image) 
            {
                //Guardar las imagenes en el servidor                    
                $path = $image->store($destination_path, $disk);

                if (!$path) {
                    $errorImages++;
                    continue;
                }

                $ebook->extraImages()->create([
                    'image' => $path,
                ]);
            }

            if ($errorImages > 0) {
                $request->session()->flash('errorExtraImages', __('general.error.notification.saveFiles.errorExtraImages', ['qty' => $errorImages]));
            }
        } 

        //Guardar y asignar Authors - Topics existentes
        $ebook->authors()->sync($validated['existAuthors']);
        $ebook->topics()->sync($validated['existTopics']);

        //Guardar nuevos Authors - Topics
        if (!empty($validated['newAuthors'])) {
            $newAuthors = [];

            foreach ($validated['newAuthors'] as $newAuthor) {
                $newAuthors[] = Author::firstOrCreate([
                    'name' => $newAuthor,
                ])->id;
            }

            $ebook->authors()->syncWithoutDetaching($newAuthors);
        }

        if (!empty($validated['newTopics'])) {
            $newTopics = [];

            foreach ($validated['newTopics'] as $newTopic) {
                $newTopics[] = Topic::firstOrCreate([
                    'name' => $newTopic,
                ])->id;
            }

            $ebook->topics()->syncWithoutDetaching($newTopics);
        }

        //Se crea el contador de views del Ebook
        $ebook->counter()->create(['views' => 0 ]);//A la table del contador le puedo poner más columnas (a parte de 'views'), como 'favorites', 'downloads'
        
        //Notificaciones después de crear un Ebook
        $titleNotification = __('ebooks.create.notification.title');
        $notification = __('ebooks.create.notification.body', ['title' => $ebook->title]);
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
        $ebook = Ebook::where('slug', '=', $slug)->firstOrFail();
        //Contar las visitas a cada e-libro
        $ebook->counter()->update([
                'views' => $ebook->counter->views + 1,
            ],[
                'timestamps' => false
            ]);
        $ebook->counter->views++;
        return view('content.ebooks.show', compact('ebook'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $ebook = Ebook::where('slug', '=', $slug)->firstOrFail();
        $authors = Author::all();
        $topics = Topic::all();
        $languages = Language::all();
        $countries = Country::all();
        
        $ebook->authors_id = array_column($ebook->authors->toArray(), 'id');
        $ebook->topics_id = array_column($ebook->topics->toArray(), 'id');


        return view('content.ebooks.edit', compact('ebook', 'authors', 'topics', 'languages', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\Ebooks\UpdateEbookRequest  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEbookRequest $request, $slug)
    {
        $ebook = Ebook::where('slug', '=', $slug)->firstOrFail();

        $datesEbook = $request->except('downloadable','coverImage','backCoverImage','extraimages', '_token', '_method');
        $datesEbook['synopsis'] = $datesEbook['synopsis-original'];

        /* $datesEbook = $request->validated()->except('downloadable','coverImage','backCoverImage','extraimages'); //Esto sería se creo un request aparte para las validaciones */

        //Agunas cosas necesarias para el almacenamiennto de los archivos
            $code = Str::random(8);
            $datesEbook['slug'] =  ($ebook->title != $datesEbook['title']) ? Str::slug($datesEbook['title']).'-'.$code : $ebook->slug;
            $destination_path = 'content/ebooks/'.$datesEbook['slug'];
            $disk = 'public';
        //

        
        if($ebook->title != $datesEbook['title'])
        { 
            if ( Storage::rename("public/content/ebooks/$ebook->slug", "public/content/ebooks/".$datesEbook['slug']) ) 
            {
                $datesEbook['coverImage'] = Str::replaceFirst($ebook->slug, $datesEbook['slug'], $ebook->coverImage);
                
                ($ebook->backCoverImage) ? $datesEbook['backCoverImage'] = Str::replaceFirst($ebook->slug, $datesEbook['slug'], $ebook->backCoverImage) : '';
                ($ebook->downloadable) ? $datesEbook['downloadable'] = Str::replaceFirst($ebook->slug, $datesEbook['slug'], $ebook->downloadable) : '';

                if($ebook->extraImages)
                {
                    foreach ($ebook->extraImages as $extraImage)
                    {
                        $extraImage->update([
                            'image' => Str::replaceFirst($ebook->slug, $datesEbook['slug'], $extraImage->image),
                        ]); 
                    }                
                }
            }
        }

        $a = $datesEbook['existAuthors'];
        sort($a);
        $b = array_column($ebook->authors->toArray(), 'id');
        sort($b);

        if(!empty($datesEbook['existAuthors']) and $a != $b)
        {
            $ebook->authors()->sync($datesEbook['existAuthors']);
        }
        if(!empty($datesEbook['newAuthors']))
        {
            $newAuthors = [];

            foreach ($datesEbook['newAuthors'] as $newAuthor) {
                $newAuthors[] = Author::firstOrCreate([
                    'name' => $newAuthor,
                ])->id;
            }

            $ebook->authors()->syncWithoutDetaching($newAuthors);
        }
        
        
        if(!empty($datesEbook['existTopics']))
        {
            $ebook->topics()->sync($datesEbook['existTopics']);
        }
        if(!empty($datesEbook['newTopics']))
        {
            $newTopics = [];

            foreach ($datesEbook['newTopics'] as $newTopic) {
                $newTopics[] = Topic::firstOrCreate([
                    'name' => $newTopic,
                ])->id;
            }

            $ebook->topics()->syncWithoutDetaching($newTopics);
        }

        

        if($request->hasFile('coverImage'))
        {
            if( $ebook->title != $datesEbook['title'] and Storage::delete('public/'.$datesEbook['coverImage']))
            {
                $datesEbook['coverImage'] = $request->file('coverImage')->store($destination_path, $disk);
            }
            elseif(Storage::delete('public/'.$ebook->coverImage))
            {
                $datesEbook['coverImage'] = $request->file('coverImage')->store($destination_path, $disk);
                
            }else{
                Log::error("No se pudo eliminar la anterior Imagen de Tapa");
            }
        }

        if($request->hasFile('backCoverImage'))
        {
            if( $ebook->title != $datesEbook['title'] and ($ebook->backCoverImage == null or Storage::delete('public/'.$datesEbook['backCoverImage'])) )
            {
                $datesEbook['backCoverImage'] = $request->file('backCoverImage')->store($destination_path, $disk);
            }
            elseif($ebook->backCoverImage == null or Storage::delete('public/'.$ebook->backCoverImage))
            {
                $datesEbook['backCoverImage'] = $request->file('backCoverImage')->store($destination_path, $disk);
                
            }else{
                Log::error("No se pudo eliminar la anterior Imagen de Contra Tapa");
            }
        }

        if($request->hasFile('downloadable'))
        {
            if( $ebook->title != $datesEbook['title'] and ($ebook->downloadable == null or Storage::delete('public/'.$datesEbook['downloadable'])) )
            {
                $datesEbook['downloadable'] = $request->file('downloadable')->store($destination_path, $disk);
                $datesEbook['format'] = $request->file('downloadable')->extension();
            }
            elseif($ebook->downloadable == null or Storage::delete('public/'.$ebook->downloadable))
            {
                $datesEbook['downloadable'] = $request->file('downloadable')->store($destination_path, $disk);
                $datesEbook['format'] = $request->file('downloadable')->extension();
            }else{
                Log::error("No se pudo eliminar el anterior descargable");
            }

            if ($datesEbook['downloadable']) $datesEbook['format'] = $request->file('downloadable')->extension();
        }

        if((isset($datesEbook['coverImage']) and !$datesEbook['coverImage']) or (isset($datesEbook['backCoverImage']) and !$datesEbook['backCoverImage']) or (isset($datesEbook['downloadable']) and !$datesEbook['downloadable'])) {
            Storage::deleteDirectory($destination_path);

            //Notificaciones después de error al guardar archivos en el servidor
            $titleNotification = __('general.error.notification.saveFiles.title');
            $notification = __('general.error.notification.saveFiles.body', ['content' => __('general.content.ebook')]);
            $request->session()->flash('titleNotification', $titleNotification);
            $request->session()->flash('notification', $notification);
            return redirect()->back();
        }

        
        
        $ebook->update($datesEbook);

        if (isset($request->extraImages)) {
            
            foreach ($ebook->extraImages as $previousImage) {
                Storage::delete('public/'.$previousImage->image);
            }
            $ebook->extraImages()->delete();
            
            $extraImages = $request->extraImages;
            $errorImages = 0;
            
            foreach ($extraImages as $image) 
            {
                //Guardar las nuevas imagenes
                    
                    $path = $image->store($destination_path, $disk);

                    if (!$path) {
                        $errorImages++;
                        continue;
                    }

                    $ebook->extraImages()->create([
                        'image' => $path,
                    ]);
            }

            if ($errorImages > 0) {
                $request->session()->flash('errorExtraImages', __('general.error.notification.saveFiles.errorExtraImages', ['qty' => $errorImages]));
            }
        }


        //Notificaciones después de editar un Ebook
        $titleNotification = __('ebooks.edit.notification.title');
        $notification = __('ebooks.edit.notification.body', ['title' => $ebook->title]);
        $request->session()->flash('titleNotification', $titleNotification);
        $request->session()->flash('notification', $notification);

        return redirect()->route('ebook.edit', ['slug' => $ebook->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $slug)
    {
        $ebook = Ebook::where('slug', '=', $slug)->firstOrFail();
        
        //Eliminar la vinculación en la bd con los autores y los temas
            $ebook->authors()->detach();
            $ebook->topics()->detach();

        //Eliminar la vinculación en la bd con las Imagenes extras
            $ebook->extraImages()->delete();

        //Eliminar Archivo descargable  //Eliminar Imagen de Tapa //Eliminar Imagen de Contratapa 
        //Eliminar las imagenes extras (todo del servidor) 
        // Y Eliminar hasta la carpeta (directorio) del libro
            Storage::deleteDirectory('public/content/ebooks/'.$ebook->slug);
        
        //Eliminar su Contador
            $ebook->counter()->delete();
        //
        $titleOfDeletedEbook = $ebook->title;
        $ebook->delete();
        
        $titleNotification = __('ebooks.delete.notification.title');
        $notification = __('ebooks.delete.notification.body', ['title' => $titleOfDeletedEbook]);
        $request->session()->flash('titleNotification', $titleNotification);
        $request->session()->flash('notification', $notification);

        return redirect()->back();
    }
}
