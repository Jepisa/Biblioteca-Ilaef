<?php

namespace App\Http\Requests\Advertisement;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvertisement extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:advertisements|max:255',
            'owner' => 'required|string|max:255',
            'image' => 'required|file|mimes:jpg,png,jpeg',//Preguntar a Valeria las dimensiones // |dimensions:min_width=600,min_height=800,max_width=1800,max_height=2300
            'url' => 'nullable|url',
            'launching' => 'required|date|after:yesterday',
            'expiration' => 'required|date|after_or_equal:today',
            'position' => 'nullable|integer|min:1', //Cambiar el mensaje de error de position cuando manda el form vacio 
            'status' => 'required|boolean',
        ];
    }
}
