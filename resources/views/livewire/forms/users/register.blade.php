<div>
    <div class="text-center my-4">
        <h3 class="text-2xl">Creá una cuenta. Es gratis</h3>
    </div>

    <!-- Validation Errors -->

    @if ($errors->any())
        <div class="mb-4" :errors="$errors">
            <div class="font-medium text-red-600">
                {{ __('Whoops! Something went wrong.') }}
            </div>

            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
 
        <!-- Name and Last Name -->
        <div class="w-full flex justify-between mb-6">
            <!-- Name -->
            <div class="w-input-form">
                <x-input id="name" class="mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-label for="name" :value="__('Name')" />
            </div>
            
            <!-- Last Name -->
            <div class="w-input-form">
                <x-input id="lastName" class="mt-1 w-full" type="text" name="lastName" :value="old('lastName')" required />
                <x-label for="lastName" :value="__('Last Name')" />
            </div>
        </div>

        <!-- Country and State -->
        <div class="w-full flex justify-between">

            <!-- Country -->
            <div class="w-input-form mb-6">
                {{-- <x-input id="country" class="mt-1 w-full" type="text" name="country" :value="old('country')" required autofocus /> --}}
                <select id="country" class="w-full" name="country" wire:model="selectedCountry" :value="old('country')" required>
                    <option selected disabled>
                        Seleccione un país
                    </option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">
                            {{ $country->name }}
                        </option>
                    @endforeach
                    
                </select>
                <x-label for="country" :value="__('Country')" />
            </div>
            
            <!-- State -->
            <div class="w-input-form mb-6">
                {{-- <x-input id="state" class="mt-1 w-full" type="text" name="state" :value="old('state')" required /> --}}
                <select id="state" class="w-full" name="state" required>
                    <option value="Seleccione una provincia" selected disabled>
                        Seleccione una provincia
                    </option>
                    @if ($states)
                        
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}">
                            {{ $state->name }}
                        </option>
                    @endforeach
                    @endif
                    
                </select>
                
                <x-label for="state" :value="__('State')" />
            </div>
        </div>

        <!-- Telephone and Email Address -->
        <div class="w-full flex justify-between mb-6">
            <div class="w-input-form">
                <x-input id="phoneNumber" class="block mt-1 w-full" type="tel" name="phoneNumber" :value="old('phoneNumber')" required />
                <x-label for="phoneNumber" :value="__('Telephone')" />
            </div>
            <div class="w-input-form">
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-label for="email" :value="__('Email')" />
            </div>
        </div>
        
        <!-- Occupation and Referrer -->
        <div class="w-full flex justify-between">

            <!-- Occupation -->
            <div class="w-input-form mb-6">
                <select id="occupation" class="w-full" name="occupation" :value="old('occupation')" required >
                    <option selected disabled>
                        Selecciona una Ocupación
                    </option>
                    @foreach ($occupations as $occupation)
                        <option value="{{ $occupation->id }}" >
                            {{ $occupation->name }}
                        </option>
                    @endforeach
                    
                </select>
                <x-label for="occupation" :value="__('Occupation')" />
            </div>

            
            
            <!-- Referrer -->
            <div class="w-input-form mb-6">
                <select id="referrer" class="w-full" name="referrer" required>
                    <option selected disabled>
                        Nos conoces por...
                    </option>
                    @if ($referrers)
                        
                    @foreach ($referrers as $referrer)
                        <option value="{{ $referrer->id }}">
                            {{ $referrer->name }}
                        </option>
                    @endforeach
                    @endif
                    
                </select>
                
                <x-label for="referrer" :value="__('Nos conocés por')" />
            </div>
        </div>
        
        <!--Password and Confirm Password -->
        <div class="w-full flex justify-between mb-6">
            <!-- Password -->
            <div class="w-input-form">
                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <x-label for="password" :value="__('Password')" />
            </div>

            <!-- Confirm Password -->
            <div class="w-input-form">

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
                <x-label for="password_confirmation" :value="__('Confirm Password')" />
            </div>
        </div>
        @auth
        <!-- Roles -->
            @if (isset($roles))
                
                <!-- Role -->
                <div class="mb-6">
                    <x-label for="role" :value="__('Role')" />

                    {{--
                    <x-input id="role" class="block mt-1 w-full" type="text" name="role_id" :value="old('role_id')" required />

                    <option {{ (Auth::user()->role->name == 'Administrador Principal') ? 'selected="selected"' : '' }} value="{{ HOla1 }}">
                        {{ Label }}
                    </option> --}}

                    <select name="role_id">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">
                                {{ $role->name }}
                            </option>
                        @endforeach
                        
                    </select>

                </div>

            @endif
        @endauth


        <div class="flex items-center justify-center mt-4">

            <x-button class="w-3/6 justify-center">
                {{ __('REGISTRATE') }}
            </x-button>
        </div>
    </form>
</div>
