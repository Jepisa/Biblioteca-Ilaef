<?php

namespace App\Http\Requests\Books;
use Illuminate\Support\Str;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Author;
use App\Models\Topic;

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
        $existAuthors = array();
        $newAuthors = array();

        if (!empty($this->authors)) {
            foreach ($this->authors as $author) {
                (is_numeric($author) and Author::where('id', '=', $author)->exists()) ? ($existAuthors[] = $author) : ($newAuthors[] = $author);
            }
        }

        $existTopics = array();
        $newTopics = array();

        if (!empty($this->topics)) {
            foreach ($this->topics as $topic) {
                (is_numeric($topic) and Topic::where('id', '=', $topic)->exists()) ? ($existTopics[] = $topic) : ($newTopics[] = $topic);
            }
        }

        //Esto es solo un ejemplo, pero no funca
        $this->merge([
            'synopsis-original' => $this->synopsis,
            'synopsis' => str_replace ("\r\n"," ",$this->synopsis),
            'existAuthors' => $existAuthors,
            'newAuthors' => $newAuthors,
            'existTopics' => $existTopics,
            'newTopics' => $newTopics,
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
            'authors' => 'required|array|min:1',
            'newAuthors.*' => 'nullable|string|distinct|unique:authors,name',
            'existAuthors.*' => 'integer|distinct|exists:authors,id',
            'topics' => 'required|array|min:1',
            'newTopics.*' => 'nullable|string|distinct|unique:topics,name',
            'existTopics.*' => 'integer|distinct|exists:topics,id',
            'synopsis' => 'nullable|string|max:1200',
            'note' => 'nullable|string|max:600',
            'year' => 'nullable|integer|min:1000|max:3000',
            'collection' => 'nullable|string|max:255',
            'edition' => 'nullable|string|max:255',
            'editorial' => 'required|string|max:255',
            'language_id' => 'required|integer|exists:languages,id',
            'city' => 'nullable|string|max:255',
            'country_id' => 'required|integer|exists:countries,id',
            'pages' => 'nullable|integer',
            'isbn' => 'nullable|string|max:255|unique:books,isbn',
            'downloadable' => 'file|mimes:pdf,doc',
            'url' => 'nullable|url',
            'coverImage' => 'required|file|mimes:jpg,png,jpeg', //|dimensions:min_width=600,min_height=800,max_width=1800,max_height=2300',
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
