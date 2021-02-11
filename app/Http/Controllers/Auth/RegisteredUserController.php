<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use App\Models\Role;
use App\Models\Gender;
use App\Models\Occupation;
use App\Models\Referrer;
use App\Models\State;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::all();
        $states = State::all();
        $occupations = Occupation::all();
        $referrers = Referrer::all();

        if ( Auth::check() ) 
        {
            $userRole = Auth::user()->role->name;
            
            
            if( $userRole == 'Usuario' OR $userRole == 'Administrador') 
            {
                return redirect()->route('home');
            }
            elseif( ($userRole == 'Administrador Principal') AND Role::where('visibility', true)->count() > 0) 
            {
                $roles = Role::where('visibility', true)->get();
            }
            elseif( $userRole == 'Programador')
            {
                $roles = Role::all();
            }
            
            return view('auth.register', compact('roles', 'countries', 'states', 'occupations', 'referrers'));
        }
        else
        {
            return view('auth.register',compact('countries', 'states', 'occupations', 'referrers'));
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        
        if( Auth::check() AND isset($request->role_id))
        {
            $userRole= Auth::user()->role->name;

            if( $userRole == 'Administrador Principal' )
            {
                $roles = Role::where('visibility', true)->get('id')->toArray();
                if($roles)
                {
                    $rolesIdVisible = array_map( function ($role) { return $role['id']; }, $roles);
                    
                    $ruleRole_id = [ Rule::in($rolesIdVisible) ] ;
                    
                }
            }
            elseif( $userRole == 'Programador' )
            {
                $ruleRole_id = 'exists:roles,id';
            }
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'role' => (isset($ruleRole_id)) ? $ruleRole_id : '',
            'country' => 'required|string|max:255|exists:countries,id',
            'state' => 'required|string|max:255|exists:states,id',
            'city' => 'string|max:255', //Esto será opcional después en su perfil
            'phoneNumber' => 'required|numeric',
            'email' => 'required|string|email|max:255|unique:users',
            'occupation' => 'required|exists:occupations,id',
            'referrer' => 'required|exists:referrers,id',
            
            'password' => 'required|string|confirmed|min:6|max:255',
        ]);

        if( Auth::check() )
        {
            if( $userRole == 'Administrador Principal' OR $userRole == 'Programador') 
            {
                $newUser = User::create([
                    'name' => $request->name,
                    'lastName' => $request->lastName,
                    'role_id' =>  (isset($request->role_id)) ? $request->role_id : Role::firstOrCreate(['name' => 'Usuario'])->id ,
                    'gender_id' =>  (isset($request->gender_id)) ? $request->gender_id : Gender::firstOrCreate(['name' => 'Sin especificar'])->id ,
                    'country_id' => $request->country,
                    'state_id' => $request->state,
                    'phoneNumber' => $request->phoneNumber,
                    'occupation_id' => $request->occupation,
                    'referrer_id' => $request->referrer,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                if ($newUser) 
                {
                    event(new Registered($newUser));

                    $notification = 'Nuevo '.$newUser->role->name.' creado con éxito!';
                    $request->session()->flash('notification', $notification);
                } else 
                {
                    //Se necesita arreglar esto para que el la vista aparezca con un  color rojo
                    $notification = 'Perdón, no se pudo crear al nuevo Usuario/Administrador/Administrador Principal, si el error persiste comuniquese con el Programador';
                    $request->session()->flash('notification', $notification);
                }
                
                 
            }

            return redirect()->back();
        }
        else
        {
            Auth::login($newUser = User::create([
                'name' => $request->name,
                'lastName' => $request->lastName,
                'gender_id' => Gender::firstOrCreate(['name' => 'Sin especificar'])->id,
                'role_id' => Role::firstOrCreate(['name' => 'Usuario'])->id, //Usuario común
                'country_id' => $request->country,
                'state_id' => $request->state,
                'phoneNumber' => $request->phoneNumber,
                'occupation_id' => $request->occupation,
                'referrer_id' => $request->referrer,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]));

            event(new Registered($newUser));

            return redirect(RouteServiceProvider::HOME);
        }
    }
}
