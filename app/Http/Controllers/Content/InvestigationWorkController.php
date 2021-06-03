<?php

namespace App\Http\Controllers\content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\InvestigationWorks\StoreInvestigationWorkRequest;
use App\Http\Requests\Content\InvestigationWorks\UpdateInvestigationWorkRequest;
use Illuminate\Support\Str;
use App\Models\Author;
use App\Models\InvestigationWork;
use App\Models\Country;
use App\Models\Language;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InvestigationWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $investigation_works = InvestigationWork::orderBy('created_at', 'desc')->paginate(10);

        return view('content.investigation-works.index', compact('investigation_works'));
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

        return view('content.investigation-works.create', compact('authors', 'topics', 'languages', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\InvestigationWorks\StoreInvestigationWorkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvestigationWorkRequest $request)
    {

        $validated = $request->validated();

        //Agunas cosas necesarias
            $code = Str::random(8);
            $slugOfInvestigationWork = Str::slug($validated['title']).'-'.$code;
            $destination_path = 'content/investigation-works/'.$slugOfInvestigationWork;
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
            $notification = __('general.error.notification.saveFiles.body', ['content' => __('general.content.investigationwork')]);
            $request->session()->flash('titleNotification', $titleNotification);
            $request->session()->flash('notification', $notification);
            return redirect()->back();
        }

        //Crea Investigation Work en BD
        $investigation_work = InvestigationWork::create([
            'title'             => $validated['title'],
            'slug'              => $slugOfInvestigationWork,
            'synopsis'          => $request['synopsis-original'],
            'note'              => !empty($validated['note']) ? $validated['note'] : null,
            'year'              => !empty($validated['year']) ? $validated['year'] : null,
            'sources'           => $validated['sources'],
            'language_id'       => $validated['language_id'],
            'city'              => !empty($validated['city']) ? $validated['city'] : null,
            'country_id'        => $validated['country_id'],
            'pages'             => !empty($validated['pages']) ? $validated['pages'] : null,
            'isbn'              => !empty($validated['isbn']) ? $validated['isbn'] : null,
            'downloadable'      => isset($pathDownloadable) ? $pathDownloadable : null,
            'url'               => !empty($validated['url']) ? $validated['url'] : null,
            'coverImage'        => isset($pathCoverImage) ? $pathCoverImage : 'content/investigation-works/default',
            'backCoverImage'    => isset($pathBackCoverImage) ? $pathBackCoverImage : null,
            'format'            => isset($extension_downloadable) ? $extension_downloadable : null,
        ]);

        // if(!$investigation_work) Log::channel('slack')->critical("Problm!\n We have a problem for save a investigation work!!!\nSaludos, Jean Piere");//This is for to send a message to Slack

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

                $investigation_work->extraImages()->create([
                    'image' => $path,
                ]);
            }

            if ($errorImages > 0) {
                $request->session()->flash('errorExtraImages', __('general.error.notification.saveFiles.errorExtraImages', ['qty' => $errorImages]));
            }
        } 

        //Guardar y asignar Authors - Topics existentes
        $investigation_work->authors()->sync($validated['existAuthors']);
        $investigation_work->topics()->sync($validated['existTopics']);

        //Guardar nuevos Authors - Topics
        if (!empty($validated['newAuthors'])) {
            $newAuthors = [];

            foreach ($validated['newAuthors'] as $newAuthor) {
                $newAuthors[] = Author::firstOrCreate([
                    'name' => $newAuthor,
                ])->id;
            }

            $investigation_work->authors()->syncWithoutDetaching($newAuthors);
        }

        if (!empty($validated['newTopics'])) {
            $newTopics = [];

            foreach ($validated['newTopics'] as $newTopic) {
                $newTopics[] = Topic::firstOrCreate([
                    'name' => $newTopic,
                ])->id;
            }

            $investigation_work->topics()->syncWithoutDetaching($newTopics);
        }

        //Se crea el contador de views del Investigation Work
        $investigation_work->counter()->create(['views' => 0 ]);//A la table del contador le puedo poner más columnas (a parte de 'views'), como 'favorites', 'downloads'
        
        //Notificaciones después de crear un Investigation Work
        $titleNotification = __('investigation-works.create.notification.title');
        $notification = __('investigation-works.create.notification.body', ['title' => $investigation_work->title]);
        $request->session()->flash('titleNotification', $titleNotification);
        $request->session()->flash('notification', $notification);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $investigation_work = InvestigationWork::where('slug', '=', $slug)->firstOrFail();
        //Contar las visitas a cada investigation work
        $investigation_work->counter()->update([
                'views' => $investigation_work->counter->views + 1,
            ],[
                'timestamps' => false
            ]);
        $investigation_work->counter->views++;
        return view('content.investigation-works.show', compact('investigation_work'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $investigation_work = InvestigationWork::where('slug', '=', $slug)->firstOrFail();
        $authors = Author::all();
        $topics = Topic::all();
        $languages = Language::all();
        $countries = Country::all();
        
        $investigation_work->authors_id = array_column($investigation_work->authors->toArray(), 'id');
        $investigation_work->topics_id = array_column($investigation_work->topics->toArray(), 'id');


        return view('content.investigation-works.edit', compact('investigation_work', 'authors', 'topics', 'languages', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\InvestigationWorks\UpdateInvestigationWorkRequest  $request
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvestigationWorkRequest $request, $slug)
    {
        $investigation_work = InvestigationWork::where('slug', '=', $slug)->firstOrFail();

        $dateInvestigationWork = $request->except('downloadable','coverImage','backCoverImage','extraimages', '_token', '_method');
        $dateInvestigationWork['synopsis'] = $dateInvestigationWork['synopsis-original'];

        /* $dateInvestigationWork = $request->validated()->except('downloadable','coverImage','backCoverImage','extraimages'); //Esto sería se creo un request aparte para las validaciones */

        //Agunas cosas necesarias para el almacenamiennto de los archivos
            $code = Str::random(8);
            $dateInvestigationWork['slug'] =  ($investigation_work->title != $dateInvestigationWork['title']) ? Str::slug($dateInvestigationWork['title']).'-'.$code : $investigation_work->slug;
            $destination_path = 'content/investigation-works/'.$dateInvestigationWork['slug'];
            $disk = 'public';
        //

        
        if($investigation_work->title != $dateInvestigationWork['title'])
        { 
            if ( Storage::rename("public/content/investigation-works/$investigation_work->slug", "public/content/investigation-works/".$dateInvestigationWork['slug']) ) 
            {
                $dateInvestigationWork['coverImage'] = Str::replaceFirst($investigation_work->slug, $dateInvestigationWork['slug'], $investigation_work->coverImage);
                
                ($investigation_work->backCoverImage) ? $dateInvestigationWork['backCoverImage'] = Str::replaceFirst($investigation_work->slug, $dateInvestigationWork['slug'], $investigation_work->backCoverImage) : '';
                ($investigation_work->downloadable) ? $dateInvestigationWork['downloadable'] = Str::replaceFirst($investigation_work->slug, $dateInvestigationWork['slug'], $investigation_work->downloadable) : '';

                if($investigation_work->extraImages)
                {
                    foreach ($investigation_work->extraImages as $extraImage)
                    {
                        $extraImage->update([
                            'image' => Str::replaceFirst($investigation_work->slug, $dateInvestigationWork['slug'], $extraImage->image),
                        ]); 
                    }                
                }
            }
        }

        $a = $dateInvestigationWork['existAuthors'];
        sort($a);
        $b = array_column($investigation_work->authors->toArray(), 'id');
        sort($b);

        if(!empty($dateInvestigationWork['existAuthors']) and $a != $b)
        {
            $investigation_work->authors()->sync($dateInvestigationWork['existAuthors']);
        }
        if(!empty($dateInvestigationWork['newAuthors']))
        {
            $newAuthors = [];

            foreach ($dateInvestigationWork['newAuthors'] as $newAuthor) {
                $newAuthors[] = Author::firstOrCreate([
                    'name' => $newAuthor,
                ])->id;
            }

            $investigation_work->authors()->syncWithoutDetaching($newAuthors);
        }
        
        
        if(!empty($dateInvestigationWork['existTopics']))
        {
            $investigation_work->topics()->sync($dateInvestigationWork['existTopics']);
        }
        if(!empty($dateInvestigationWork['newTopics']))
        {
            $newTopics = [];

            foreach ($dateInvestigationWork['newTopics'] as $newTopic) {
                $newTopics[] = Topic::firstOrCreate([
                    'name' => $newTopic,
                ])->id;
            }

            $investigation_work->topics()->syncWithoutDetaching($newTopics);
        }

        

        if($request->hasFile('coverImage'))
        {
            if( $investigation_work->title != $dateInvestigationWork['title'] and Storage::delete('public/'.$dateInvestigationWork['coverImage']))
            {
                $dateInvestigationWork['coverImage'] = $request->file('coverImage')->store($destination_path, $disk);
            }
            elseif(Storage::delete('public/'.$investigation_work->coverImage))
            {
                $dateInvestigationWork['coverImage'] = $request->file('coverImage')->store($destination_path, $disk);
                
            }else{
                Log::error("No se pudo eliminar la anterior Imagen de Tapa");
            }
        }

        if($request->hasFile('backCoverImage'))
        {
            if( $investigation_work->title != $dateInvestigationWork['title'] and ($investigation_work->backCoverImage == null or Storage::delete('public/'.$dateInvestigationWork['backCoverImage'])) )
            {
                $dateInvestigationWork['backCoverImage'] = $request->file('backCoverImage')->store($destination_path, $disk);
            }
            elseif($investigation_work->backCoverImage == null or Storage::delete('public/'.$investigation_work->backCoverImage))
            {
                $dateInvestigationWork['backCoverImage'] = $request->file('backCoverImage')->store($destination_path, $disk);
                
            }else{
                Log::error("No se pudo eliminar la anterior Imagen de Contra Tapa");
            }
        }

        if($request->hasFile('downloadable'))
        {
            if( $investigation_work->title != $dateInvestigationWork['title'] and ($investigation_work->downloadable == null or Storage::delete('public/'.$dateInvestigationWork['downloadable'])) )
            {
                $dateInvestigationWork['downloadable'] = $request->file('downloadable')->store($destination_path, $disk);
                $dateInvestigationWork['format'] = $request->file('downloadable')->extension();
            }
            elseif($investigation_work->downloadable == null or Storage::delete('public/'.$investigation_work->downloadable))
            {
                $dateInvestigationWork['downloadable'] = $request->file('downloadable')->store($destination_path, $disk);
                $dateInvestigationWork['format'] = $request->file('downloadable')->extension();
            }else{
                Log::error("No se pudo eliminar el anterior descargable");
            }

            if ($dateInvestigationWork['downloadable']) $dateInvestigationWork['format'] = $request->file('downloadable')->extension();
        }

        if((isset($dateInvestigationWork['coverImage']) and !$dateInvestigationWork['coverImage']) or (isset($dateInvestigationWork['backCoverImage']) and !$dateInvestigationWork['backCoverImage']) or (isset($dateInvestigationWork['downloadable']) and !$dateInvestigationWork['downloadable'])) {
            Storage::deleteDirectory($destination_path);

            //Notificaciones después de error al guardar archivos en el servidor
            $titleNotification = __('general.error.notification.saveFiles.title');
            $notification = __('general.error.notification.saveFiles.body', ['content' => __('general.content.investigationwork')]);
            $request->session()->flash('titleNotification', $titleNotification);
            $request->session()->flash('notification', $notification);
            return redirect()->back();
        }

        
        
        $investigation_work->update($dateInvestigationWork);

        if (isset($request->extraImages)) {
            
            foreach ($investigation_work->extraImages as $previousImage) {
                Storage::delete('public/'.$previousImage->image);
            }
            $investigation_work->extraImages()->delete();
            
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

                    $investigation_work->extraImages()->create([
                        'image' => $path,
                    ]);
            }

            if ($errorImages > 0) {
                $request->session()->flash('errorExtraImages', __('general.error.notification.saveFiles.errorExtraImages', ['qty' => $errorImages]));
            }
        }


        //Notificaciones después de editar un Investigation Work
        $titleNotification = __('investigation-works.edit.notification.title');
        $notification = __('investigation-works.edit.notification.body', ['title' => $investigation_work->title]);
        $request->session()->flash('titleNotification', $titleNotification);
        $request->session()->flash('notification', $notification);

        return redirect()->route('investigationwork.edit', ['slug' => $investigation_work->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $slug)
    {
        $investigation_work = InvestigationWork::where('slug', '=', $slug)->firstOrFail();
        
        //Eliminar la vinculación en la bd con los autores y los temas
            $investigation_work->authors()->detach();
            $investigation_work->topics()->detach();

        //Eliminar la vinculación en la bd con las Imagenes extras
            $investigation_work->extraImages()->delete();

        //Eliminar Archivo descargable  //Eliminar Imagen de Tapa //Eliminar Imagen de Contratapa 
        //Eliminar las imagenes extras (todo del servidor) 
        // Y Eliminar hasta la carpeta (directorio) del trabajo de investigacion
            Storage::deleteDirectory('public/content/investigation-works/'.$investigation_work->slug);
        
        //Eliminar su Contador
            $investigation_work->counter()->delete();
        //
        $titleOfDeletedInvestigationWork = $investigation_work->title;
        $investigation_work->delete();
        
        $titleNotification = __('investigation-works.delete.notification.title');
        $notification = __('investigation-works.delete.notification.body', ['title' => $titleOfDeletedInvestigationWork]);
        $request->session()->flash('titleNotification', $titleNotification);
        $request->session()->flash('notification', $notification);

        return redirect()->back();
    }
}
