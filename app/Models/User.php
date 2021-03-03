<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastName',
        'gender_id',
        'role_id',
        'status',
        'country_id',
        'state_id',
        'city_id',
        'phoneNumber',
        'occupation_id',
        'referrer_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isPrincipalAdminOrProgrammer()
    {
        return auth()->user()->role->name == "Administrador Principal" or auth()->user()->role->name == "Programador";
    }


    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }
    
    public function referrer()
    {
        return $this->belongsTo(Referrer::class);
    }
}
