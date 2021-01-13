<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
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

        if ( Auth::check() ) 
        {
            $userRole = Auth::user()->role->name;
            
            if( ($userRole == 'Administrador Principal') ) 
            {
                $roles = Role::where('visibility', true)->get();
                
                if($roles->count() > 0) return view('auth.register')->with('roles', $roles);
                else return view('auth.register');
            }
            if( $userRole == 'Programador')
            {
                $roles = Role::all();
                return view('auth.register')->with('roles', $roles);
            }
            if( $userRole == 'Usuario' OR $userRole == 'Administrador') 
            {
                return redirect()->route('home');
            }

            
        }
        else
        {
            return view('auth.register');
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
            if(Auth::user()->role->name == 'Administrador Principal' )
            {
                $roles = Role::where('visibility', true)->get('id')->toArray();
                if($roles)
                {
                    $rolesIdVisible = array_map( function ($role) { return $role['id']; }, $roles);
                    
                    $ruleRole_id = [ Rule::in($rolesIdVisible) ] ;
                    
                }
            }
            if( Auth::user()->role->name == 'Programador' )
            {
                $ruleRole_id = 'exists:rules,id';
            }
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role_id' => (isset($ruleRole_id)) ? $ruleRole_id : '',
            'password' => 'required|string|confirmed|min:8',
        ]);

        if( Auth::check() )
        {
            $userRole = Auth::user()->role->name;
            if( $userRole == 'Administrador Principal' OR $userRole == 'Programador') 
            {
                $user = User::create([
                    'name' => $request->name,
                    'role_id' =>  (isset($request->role_id)) ? $request->role_id : Role::firstOrCreate(['name' => 'Usuario'])->id ,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                event(new Registered($user));

                
                $notification = 'Nuevo '.$user->role->name.' creado con éxito!';
                $request->session()->flash('notification', $notification); 
            }

            return redirect()->back();
        }
        else
        {
            Auth::login($user = User::create([
                'name' => $request->name,
                'role_id' => Role::firstOrCreate(['name' => 'Usuario'])->id, //Usuario común
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]));

            event(new Registered($user));

            return redirect(RouteServiceProvider::HOME);
        }
    }
}
