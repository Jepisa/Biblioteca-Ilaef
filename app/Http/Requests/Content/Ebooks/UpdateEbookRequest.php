<?php

namespace App\Http\Requests\Content\Ebooks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Ebook;
use App\Models\Author;
use App\Models\Topic;

class UpdateEbookRequest extends FormRequest
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
            'synopsis-original' => is_null($this->synopsis) ? $this->synopsis : trim($this->synopsis),
            'synopsis'          => str_replace ("\r\n"," ",$this->synopsis),
            'existAuthors'      => $existAuthors,
            'newAuthors'        => $newAuthors,
            'existTopics'       => $existTopics,
            'newTopics'         => $newTopics,

            'title'             => is_null($this->title) ? $this->title : trim($this->title),
            'note'              => is_null($this->note) ? $this->note : trim($this->note),
            'year'              => is_null($this->year) ? $this->year : trim($this->year),
            'collection'        => is_null($this->collection) ? $this->collection : trim($this->collection),
            'edition'           => is_null($this->edition) ? $this->edition : trim($this->edition),
            'editorial'         => is_null($this->editorial) ? $this->editorial : trim($this->editorial),
            'city'              => is_null($this->city) ? $this->city : trim($this->city),
            'pages'             => is_null($this->pages) ? $this->pages : trim($this->pages),
            'isbn'              => is_null($this->isbn) ? $this->isbn : trim($this->isbn),
            'url'               => is_null($this->url) ? $this->url : trim($this->url),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ebook = Ebook::where('slug', '=', $this->slug)->firstOrFail();
        /** En el caso de que haga las validaciones, hace lo de 'store' para la synopsis */
        return [
            'title' => [Rule::unique('ebooks')->ignore($ebook->id), 'required'],
            'authors' => 'required|array|min:1',
            'newAuthors.*' => 'nullable|string|distinct|unique:authors,name',
            'existAuthors.*' => 'integer|distinct|exists:authors,id',
            'topics' => 'required|array|min:1',
            'newTopics.*' => 'nullable|string|distinct|unique:topics,name',
            'existTopics.*' => 'integer|distinct|exists:topics,id',
            'synopsis' => 'max:1200',
            'note' => 'nullable|string|max:600',
            'year' => 'nullable|integer|min:1000|max:3000',
            'collection' => 'nullable|string|max:255',
            'edition' => 'nullable|string|max:255',
            'editorial' => 'required|string|max:255',
            'language_id' => 'required|integer|exists:languages,id',
            'city' => 'nullable|string|max:255',
            'country_id' => 'required|integer|exists:countries,id',
            'pages' => 'nullable|integer',
            'isbn' => ['nullable','string','max:255', Rule::unique('ebooks')->ignore($ebook->id)],
            'downloadable' => 'file|mimes:epub,mobi,azw3,bbeb',
            'url' => 'nullable|url',
            'coverImage' => 'file|mimes:jpg,png,jpeg',
            'extraimages' => 'array',
            'extraimages.*' => 'file|mimes:jpg,png,jpeg',
            'backCoverImage' => 'file|mimes:jpg,png,jpeg',
        ];
    }
}
