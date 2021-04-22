<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Gender;
use App\Models\Role;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Occupation;
use App\Models\Referrer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $country = Country::all()->random();
        $state = State::firstOrCreate(['name' => $this->faker->name().random_int(0, 100)], ['country_id' => $country->id, 'country_code' => 'AR', 'flag' => 1]);
        $city = City::Create(
                                ['name' => 'Escobar'.random_int(0, 2000),
                                'state_id'=> $state->id,
                                // 'state_code'=> 'X', 
                                'country_id'=> $country->id, 
                                'country_code'=> 'AR', 
                                // 'latitude'=> '-31.67890000', 
                                // 'longitude'=> '-63.87964000', 
                                'created_at'=> now(), 
                                'updated_at'=> now(), 
                                // 'flag'=> 1, 
                                // 'wikiDataId'=> 'Q7193761'
        ]);
        
        return [
            'name' => $this->faker->name,
            'lastName' => $this->faker->lastName,
            'gender_id' => Gender::all()->random()->id,
            'role_id' => Role::all()->random()->id,
            'status' => true,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'city_id' => $city->id,
            'phoneNumber' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'occupation_id' => Occupation::all()->random()->id,
            'referrer_id' => Referrer::all()->random()->id,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            
        ];
    }
}
