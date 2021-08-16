<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ChangePassword extends Component
{

    public $name;
    public $lastName;
    public $country;
    public $state;
    public $telephone;
    public $occupation;
    public $password;
    public $password_confirmation;

    public $role;

    

    public function render()
    {
        return view('livewire.forms.users.change-password');
    }
}
