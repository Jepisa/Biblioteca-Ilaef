<?php

namespace App\Http\Requests\Books;
use Illuminate\Support\Str;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // return auth()->user()->role->name == "Administrador" or auth()->user()->role->name == "Administrador Principal" or auth()->user()->role->name == "Programador" ;
    }

    protected function prepareForValidation()
    {
        
        //Esto es solo un ejemplo, pero no funca
        $this->merge([
            'synopsis-original' => $this->synopsis,
            'synopsis' => str_replace ("\r\n"," ",$this->synopsis),
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|unique:books|max:255',
            'authorsName' => 'required|string',
            'topicsName' => 'required|string',
            // 'authors' => 'required|array|min:1',
            // 'authors.*' => 'required|integer|distinct|exists:authors,id',
            // 'topics' => 'required|array|min:1',
            // 'topics.*' => 'required|integer|distinct|exists:topics,id',
            'synopsis' => 'required|min:400|max:1200',//Le cambié el min de 400 a 100 porque no sé si van a llegar...
            'note' => 'nullable|string|max:600',
            'year' => 'nullable|integer|min:1000|max:3000',
            'collection' => 'nullable|string|max:255',
            'edition' => 'nullable|string|max:255',
            'editorial' => 'required|string|max:255',
            'language_id' => 'required|integer|exists:languages,id',
            'city' => 'nullable|string|max:255',
            'country_id' => 'required|integer|exists:countries,id',
            'pages' => 'nullable|integer',
            'isbn' => 'required|string|max:255|unique:books,isbn',
            'downloadable' => 'file|mimes:pdf,doc',
            'url' => 'nullable|url',
            'coverImage' => 'required|file|mimes:jpg,png,jpeg|dimensions:min_width=600,min_height=800,max_width=1800,max_height=2300',
            'extraimages' => 'array',
            'extraimages.*' => 'file|mimes:jpg,png,jpeg|between:40,3000',
            'backCoverImage' => 'file|mimes:jpg,png,jpeg|between:40,4000',
            'audioBook' => 'nullable|file|mimes:mp3,wma,aac',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'country_id.required' => 'El :attribute es requerido',
        ];
    }

    public function attributes()
    {
        return [
            'authors' => 'Autor/es',
            'topics' => 'Tema/s',
            'topics.*' => 'Tema/s',
            'synopsis' => 'Sinópsis',
            'note' => 'Nota',
            'year' => 'Año',
            'collection' => 'Colección',
            'edition' => 'Edición',
            'editorial' => 'Editorial',
            'language_id' => 'Idioma',
            'city' => 'Ciudad',
            'country_id' => 'País',
            'pages' => 'Páginas',
            'isbn' => 'ISBN',
            'downloadable' => 'Archivo descargable',
            'url' => 'URL',
            'coverImage' => 'Imagen de tapa',
            'extraimages' => 'Imagenes extras',
            'backCoverImage' => 'Imagen de contratapa',
            'audioBook' => 'Audio Libro',
            'format' => 'Formato del Audio Libro',
        ];
    }
}
