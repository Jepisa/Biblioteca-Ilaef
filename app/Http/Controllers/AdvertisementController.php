<?php

namespace App\Http\Controllers;

use App\Http\Requests\Advertisement\StoreAdvertisement;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $advertisements = Advertisement::where('position', '>=', 1)->orderBy('position', 'asc')->get();
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
        // $validated = $request->validated();

        if($request->hasFile('image'))
        {
            $destination_path = 'Advertisement/'.$request->owner.'/'.$request->name;
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $extension = $request->file('')->extension();
            $new_image_name = $image_name.$extension;
            
            $pathImage = $request->file('image')->storeAs($destination_path, $new_image_name, 'public');
        }
        $newAdvertisement = new Advertisement;
            $newAdvertisement->name = $request->name;
            $newAdvertisement->owner = $request->owner;
            $newAdvertisement->image = $pathImage;
            $newAdvertisement->url = $request->url;
            $newAdvertisement->launching = $request->launching;
            $newAdvertisement->expiration = $request->expiration;
            $newAdvertisement->status = $request->status;

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
    public function edit($name)
    {
        $advertisement = Advertisement::where('name', '=', $name)->firstOrFail();
        return view('advertisement.edit', compact('advertisement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        $request->validate([
            'name' => 'required|string|unique:advertisements|max:255',// Este tirará la validacion porque no se está exceptuando a sí mismo ¡ARREGLAR!
            'owner' => 'required|string|max:255',
            'image' => 'file|mimes:jpg,png,jpeg',//Preguntar a Valeria las dimensiones // |dimensions:min_width=600,min_height=800,max_width=1800,max_height=2300
            'url' => 'nullable|url',
            'launching' => 'required|date|after:yesterday',
            'expiration' => 'required|date|after_or_equal:today',
            'position' => 'nullable|integer|min:1', //Cambiar el mensaje de error de position cuando manda el form vacio 
            'status' => 'required|boolean',
        ]);

        $cambios = 0;

        $newAdvertisement = Advertisement::where('name', '=', $request->name)->firstOrFail();
            ($newAdvertisement->name === $request->name) ? $newAdvertisement->name = $request->name : $cambios++;
            ($newAdvertisement->owner === $request->owner) ? $newAdvertisement->owner = $request->owner : $cambios++;

        if($request->hasFile('image'))
        {
            Storage::delete($newAdvertisement->image);
            $destination_path = 'Advertisement/'.$request->owner.'/'.$request->name;
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $pathImage = $request->file('image')->storeAs($destination_path, $image_name, 'public');

            $newAdvertisement->image = $pathImage;

            //Se supone que si entro el admin mando una imagen y lo tomo como un cambio
            $cambios++;
        }

        
            
            ($newAdvertisement->url === $request->url) ? $newAdvertisement->url = $request->url : $cambios++;
            ($newAdvertisement->launching === $request->launching) ? $newAdvertisement->launching = $request->launching : $cambios++;
            ($newAdvertisement->expiration === $request->expiration) ? $newAdvertisement->expiration = $request->expiration : $cambios++;
            ($newAdvertisement->status === $request->status) ? $newAdvertisement->status = $request->status : $cambios++;

            if ( $request->position != $newAdvertisement->position ) {
                $advertisements = Advertisement::where('position', '>=', $request->position)->orderBy('position', 'asc')->get();
                foreach ($advertisements as $advertisement) {
                    $advertisement->position++;
                    $advertisement->saveQuietly();
                }
                ($newAdvertisement->position === $request->position) ? $newAdvertisement->position = $request->position : $cambios++;
            }
            
        ($cambios > 0) ? $newAdvertisement->save() : $notification = 'No hubo ningun cambio';

        return redirect()->route('advertisement.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($name)
    {
        $advertisement = Advertisement::where('name', '=', $name)->firstOrFail();
        Storage::delete([$advertisement->image]);
        $advertisement->delete();
        return redirect()->back();
    }
}
