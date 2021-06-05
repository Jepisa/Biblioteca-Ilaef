<?php

namespace App\Http\Controllers;

use App\Http\Requests\Advertisement\StoreAdvertisement;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $advertisements = Advertisement::all()->sortBy('position');
        $advertisements = Advertisement::orderBy('position', 'asc')->paginate(10);
        return view('advertisement.index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('advertisement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\Advertisement\StoreAdvertisement  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdvertisement $request)
    {
        //Agunas cosas necesarias
            // $code = Str::random(8);
            // $slugOfPodcast = Str::slug($validated['title']).'-'.$code;
            // $destination_path = 'content/podcasts/'.$slugOfPodcast;
            // $disk = 'public';


            $destination_path = 'Advertisement/'.$request->owner.'/'.$request->name;
            $disk = 'public';
            
        //
        // $validated = $request->validated();

        if($request->hasFile('image'))
        {
            $pathImage = $request->file('image')->store($destination_path, $disk);   
        }
        $newAdvertisement = new Advertisement;
            $newAdvertisement->name = $request->name;
            $newAdvertisement->owner = $request->owner;
            $newAdvertisement->image = $pathImage;
            $newAdvertisement->url = $request->url;
            $newAdvertisement->launching = $request->launching;
            $newAdvertisement->expiration = $request->expiration;
            $newAdvertisement->information = $request->information;
            $newAdvertisement->status = $request->status == 'true' ? true : false;

            if ( isset($request->position) ) {
                $advertisements = Advertisement::where('position', '>=', $request->position)->get();
                foreach ($advertisements as $advertisement) {
                    $advertisement->position++;
                    $advertisement->saveQuietly();
                }
                $newAdvertisement->position = $request->position;
            }
            else
            {   
                if (Advertisement::all()->count() > 0) {
                    $lastPosition = Advertisement::max('position');
                    $newAdvertisement->position = $lastPosition + 1;
                }
                else
                {
                    $newAdvertisement->position = 1;//Esto es solo si no hay nada en la tabla Advertisement
                }
            }
        $newAdvertisement->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $advertisement = Advertisement::where('name', '=', $name)->firstOrFail();
        return view('advertisement.show', compact('advertisement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit($advertisementId)
    {
        $advertisement = Advertisement::where('id', '=', $advertisementId)->firstOrFail();
        return view('advertisement.edit', compact('advertisement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advertisement  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $advertisement = Advertisement::findOrFail($id);

        $request->validate([
            'name' => ['required','string','max:255',Rule::unique('advertisements')->ignore($advertisement->id), 'required'],// Este tirará la validacion porque no se está exceptuando a sí mismo ¡ARREGLAR!
            'owner' => 'required|string|max:255',
            'image' => 'file|mimes:jpg,png,jpeg',//Preguntar a Valeria las dimensiones // |dimensions:min_width=600,min_height=800,max_width=1800,max_height=2300
            'url' => 'nullable|url',
            'launching' => 'required|date|after:yesterday',
            'expiration' => 'required|date|after_or_equal:today',
            'position' => 'nullable|integer|min:1', //Cambiar el mensaje de error de position cuando manda el form vacio 
            'status' => 'required|boolean',
        ]);

        $cambios = 0;

        $advertisement = Advertisement::where('name', '=', $request->name)->firstOrFail();
            ($advertisement->name === $request->name) ? $advertisement->name = $request->name : $cambios++;
            ($advertisement->owner === $request->owner) ? $advertisement->owner = $request->owner : $cambios++;

        if($request->hasFile('image'))
        {
            Storage::delete($advertisement->image);
            $destination_path = 'Advertisement/'.$request->owner.'/'.$request->name;
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $pathImage = $request->file('image')->storeAs($destination_path, $image_name, 'public');

            $advertisement->image = $pathImage;

            //Se supone que si entro el admin mando una imagen y lo tomo como un cambio
            $cambios++;
        }

        
            
            ($advertisement->url === $request->url) ? $advertisement->url = $request->url : $cambios++;
            ($advertisement->launching === $request->launching) ? $advertisement->launching = $request->launching : $cambios++;
            ($advertisement->expiration === $request->expiration) ? $advertisement->expiration = $request->expiration : $cambios++;
            ($advertisement->status === $request->status) ? $advertisement->status = $request->status : $cambios++;
            ($advertisement->information === $request->information) ? $advertisement->information = $request->information : $cambios++;

            if ( $request->position != $advertisement->position ) {
                $advertisements = Advertisement::where('position', '>=', $request->position)->orderBy('position', 'asc')->get();
                foreach ($advertisements as $advertisement) {
                    $advertisement->position++;
                    $advertisement->saveQuietly();
                }
                ($advertisement->position === $request->position) ? $advertisement->position = $request->position : $cambios++;
            }
            
        ($cambios > 0) ? $advertisement->save() : $notification = 'No hubo ningun cambio';

        
        return redirect()->route('advertisement.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advertisement = Advertisement::where('id', '=', $id)->firstOrFail();
        $disk = 'public/';
        Storage::delete([$disk . $advertisement->image]);
        Storage::deleteDirectory($disk . 'Advertisement/' . $advertisement->owner . '/' . $advertisement->name);
        $advertisement->delete();
        return redirect()->back();
    }
}
