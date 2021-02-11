<?php

namespace App\Http\Livewire;

use App\Models\State;
use Livewire\Component;

class Register extends Component
{

    public $countries;
    public $states;
    public $occupations;
    public $referrers;
    public $roles;

    public $selectedCountry;

    public function render()
    {
        $statesOfCountry = ($this->selectedCountry) ? State::where('country_id', $this->selectedCountry)->get(['name','id']) : '' ;

        $this->states = $statesOfCountry;

        return view('livewire.forms.users.register');
    }
}
