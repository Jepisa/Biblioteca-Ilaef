<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Gender;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view()->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'role' => (isset($request->role_id) and auth()->user()->isPrincipalAdminOrProgrammer) ? 'exists:roles,id' : '',
            'gender' =>  (isset($request->gender)) ? $request->gender : Gender::firstOrCreate(['name' => 'Sin especificar'])->id,
            'country' => 'required|string|max:255|exists:countries,id',
            'state' => 'required|string|max:255|exists:states,id',
            'city' => 'string|max:255',
            'phoneNumber' => 'required|numeric',
            // 'email' => 'required|string|email|max:255|unique:users',
            'occupation' => 'required|exists:occupations,id',
            'password' => 'required|string|confirmed|min:6|max:255',
        ]);

        $user = User::find(auth()->user()->id);
            $user->name = $request->name;
            $user->lastName = $request->lastName;
            $user->role_id =  (isset($request->role_id)) ? $request->role_id : Role::firstOrCreate(['name' => 'Usuario'])->id ;
            $user->gender_id =  (isset($request->gender_id)) ? $request->gender_id : Gender::firstOrCreate(['name' => 'Sin especificar'])->id;
            $user->country_id = $request->country;
            $user->state_id = $request->state;
            $user->phoneNumber = $request->phoneNumber;
            $user->occupation_id = $request->occupation;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
        $user->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
